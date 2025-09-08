import express from "express";
import multer from "multer";
import bodyParser from "body-parser";
import logger from "./logger.js"; // Import logger dari log4js
import { queryAsync } from "./db.js"; // Import queryAsync dari db.js
import crypto from "crypto";
import bcrypt from "bcrypt";
import EventEmitter from "events";
import moment from "moment-timezone"; // Import moment-timezone
import nodemailer from "nodemailer"; // Import nodemailer untuk email
import axios from "axios"; // Import axios untuk HTTP requests
import dotenv from "dotenv"; // Import dotenv untuk environment variables

// Load environment variables
dotenv.config();

// Inisialisasi aplikasi Express
const app = express();
const eventEmitter = new EventEmitter(); // Inisialisasi EventEmitter

const upload = multer();

app.use(bodyParser.json()); // Untuk menangani JSON jika diperlukan

// Konfigurasi email transporter
const emailTransporter = nodemailer.createTransporter({
  host: "smtp.gmail.com", // Sesuaikan dengan SMTP server Anda
  port: 587,
  secure: false,
  auth: {
    user: process.env.EMAIL_USER || "your-email@gmail.com",
    pass: process.env.EMAIL_PASSWORD || "your-app-password"
  }
});

// Fungsi untuk menghasilkan password acak
function generateRandomPassword(length = 12) {
  return crypto.randomBytes(length).toString("hex");
}

// Fungsi untuk menjalankan query database secara asynchronous
function formatDateInJakarta(date) {
  return moment(date).tz("Asia/Jakarta").format("YYYY-MM-DD HH:mm:ss");
}

// Fungsi untuk menghitung keterlambatan
function calculateLateStatus(timestamp) {
  const absenTime = moment(timestamp).tz("Asia/Jakarta");
  const date = absenTime.format("YYYY-MM-DD");
  const startTime = moment(`${date} 08:30:00`, "YYYY-MM-DD HH:mm:ss").tz("Asia/Jakarta");
  const endTime = moment(`${date} 10:00:00`, "YYYY-MM-DD HH:mm:ss").tz("Asia/Jakarta");

  let late = false;
  let diffLate = null;

  if (absenTime.isAfter(startTime) && absenTime.isSameOrBefore(endTime)) {
    late = true;
    const diffSeconds = absenTime.diff(startTime, "seconds");
    
    const hours = Math.floor(diffSeconds / 3600);
    const minutes = Math.floor((diffSeconds % 3600) / 60);
    const seconds = diffSeconds % 60;

    const diffLateParts = [];
    if (hours > 0) diffLateParts.push(`${hours} Jam`);
    if (minutes > 0) diffLateParts.push(`${minutes} Menit`);
    if (seconds > 0) diffLateParts.push(`${seconds} Detik`);

    diffLate = diffLateParts.join(" ");
  }

  return { late, diffLate };
}

// Fungsi untuk mengirim notifikasi WhatsApp
async function sendWhatsAppNotification(phoneNumber, message) {
  try {
    let noHp = phoneNumber.trim();
    if (noHp.startsWith("0")) {
      noHp = "62" + noHp.substring(1);
    }

    const url = "https://waha.tpm-facility.com/api/sendText";
    const data = {
      session: "default",
      chatId: noHp,
      text: message
    };

    const response = await axios.post(url, data, {
      headers: {
        "Content-Type": "application/json",
        "X-Api-Key": "dutaMas26"
      }
    });

    logger.info(`WhatsApp notification sent successfully to ${noHp}`, { response: response.data });
    return response.data;
  } catch (error) {
    logger.error(`WhatsApp API Error: ${error.message}`);
    return false;
  }
}

// Fungsi untuk mengirim email
async function sendEmailNotification(email, name, subject, description) {
  try {
    const mailOptions = {
      from: process.env.EMAIL_USER || "your-email@gmail.com",
      to: email,
      subject: subject,
      html: `
        <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;">
          <h2>Konfirmasi Absensi</h2>
          <p>${description.replace(/\n/g, '<br>')}</p>
          <hr>
          <p style="font-size: 12px; color: #666;">
            Email ini dikirim secara otomatis oleh sistem absensi.
          </p>
        </div>
      `
    };

    const result = await emailTransporter.sendMail(mailOptions);
    logger.info(`Email notification sent successfully to ${email}`, { messageId: result.messageId });
    return result;
  } catch (error) {
    logger.error(`Email send error: ${error.message}`);
    return false;
  }
}

// Fungsi untuk mengirim notifikasi keterlambatan
async function sendLateNotifications(employeeData, lateStatus) {
  const { late, diffLate } = lateStatus;
  
  if (!late) return;

  const timestamp = moment(employeeData.timestamp).tz("Asia/Jakarta").format("DD MMM YYYY, HH:mm");
  const description = `Halo ${employeeData.name},\n\nAbsensi Anda pada ${timestamp} telah tercatat. Namun, Anda mengalami keterlambatan selama ${diffLate}.\n\nTetap semangat dan selalu jaga kedisiplinan!\n\nTerima kasih.`;
  const subject = `Konfirmasi Absensi - Keterlambatan ${diffLate}`;

  // Kirim notifikasi WhatsApp jika nomor tersedia
  if (employeeData.whatsapp_number && employeeData.whatsapp_number.trim() !== "") {
    await sendWhatsAppNotification(employeeData.whatsapp_number, description);
    logger.info(`WhatsApp notification sent to ${employeeData.whatsapp_number} for late attendance`);
  }

  // Kirim email jika email tersedia
  if (employeeData.email && employeeData.email.trim() !== "") {
    await sendEmailNotification(employeeData.email, employeeData.name, subject, description);
    logger.info(`Email notification sent to ${employeeData.email} for late attendance`);
  }
}

// Listener untuk event 'receivedLog'
eventEmitter.on("receivedLog", async (parsedEventLog) => {
  console.log("Received log:", parsedEventLog);
  try {
    const ipAddress = parsedEventLog.ipAddress;
    const eventData = parsedEventLog.AccessControllerEvent;
    const dateTime = new Date(parsedEventLog.dateTime);

    const timestamp = formatDateInJakarta(dateTime);

    const siteId = 84;
    const siteLongitude = "106.798818";
    const siteLatitude = "-6.263122";

    const siteResults = await queryAsync("SELECT * FROM sites WHERE id = ?", [
      siteId,
    ]);

    const site = siteResults[0];
    if (!site) {
      logger.error("Site with ID " + siteId + " not found");
      return;
    }

    const machineResults = await queryAsync(
      "SELECT * FROM machines WHERE ip = ? and active = ?",
      [ipAddress, "yes"]
    );

    const machine = machineResults[0];
    if (!machine) {
      logger.error("Machine with IP address " + ipAddress + " not found");
      return;
    }

    const codeIp = machine.ip.split(".").pop();

    const employeeNoString = eventData.employeeNoString;
    if (!employeeNoString) {
      logger.error(
        "Invalid employeeNoString, timestamp: " +
          timestamp +
          " IpAddress: " +
          ipAddress
      );
      return;
    }

    let userResults = await queryAsync(
      "SELECT * FROM users WHERE username = ?",
      [employeeNoString]
    );
    let user = userResults[0];
    let employeeId = null; // Variable to hold employee_id

    if (!user) {
      const password = generateRandomPassword();
      const hashedPassword = await bcrypt.hash(employeeNoString, 10);

      const result = await queryAsync(
        "INSERT INTO users (username, name, email, password, created_at) VALUES (?, ?, ?, ?, ?)",
        [
          employeeNoString,
          eventData.name || null,
          employeeNoString + "@ems.com",
          hashedPassword,
          new Date(),
        ]
      );

      const userId = result.insertId; // Get the inserted user ID
      // Assign role (assuming a role assignment table exists)
      await queryAsync(
        "INSERT INTO model_has_roles (role_id, model_type, model_id) VALUES (?, ?, ?)",
        [2, "App\\Models\\User", userId] // Assuming role ID 2 corresponds to 'Employee'
      );

      // Create employee record
      await queryAsync(
        "INSERT INTO employees (id, user_id, created_at) VALUES (?, ?, ?)",
        [employeeNoString, userId, new Date()]
      );

      // Retrieve the employee record just created
      const employeeResults = await queryAsync(
        "SELECT * FROM employees WHERE user_id = ?",
        [userId]
      );

      const employee = employeeResults[0];
      employeeId = employee.id;

      userResults = await queryAsync("SELECT * FROM users WHERE username = ?", [
        employeeNoString,
      ]);

      user = userResults[0];
      logger.info(`User created: ${user.username}`);
    } else {
      // Fetch the existing employee record associated with this user
      const employeeResults = await queryAsync(
        "SELECT * FROM employees WHERE user_id = ?",
        [user.id]
      );

      const employee = employeeResults[0];
      employeeId = employee.id;
    }

    // Hitung status keterlambatan
    const lateStatus = calculateLateStatus(timestamp);

    const attendanceResults = await queryAsync(
      "SELECT * FROM attendances WHERE uid = ? AND state = ?",
      [eventData.serialNo + codeIp + machine.id, machine.id]
    );

    const attendance = attendanceResults[0];
    if (!attendance) {
      const result = await queryAsync(
        "INSERT INTO attendances (uid, employee_id, state, timestamp, type, event_id, site_id, longitude, latitude, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
        [
          eventData.serialNo + codeIp + machine.id,
          employeeId,
          machine.id,
          timestamp,
          1,
          4,
          siteId,
          siteLongitude,
          siteLatitude,
          new Date(),
        ]
      );

      logger.info(
        `Attendance created: ${result.insertId}, UID: ${eventData.serialNo}, Employee ID: ${employeeId}`
      );

      // Siapkan data untuk notifikasi
      const employeeData = {
        name: user.name,
        email: user.email,
        whatsapp_number: user.whatsapp_number || "", // Pastikan field ini ada di tabel users
        timestamp: timestamp
      };

      // Kirim notifikasi jika terlambat
      await sendLateNotifications(employeeData, lateStatus);

    } else {
      logger.info(
        `Attendance already exists: ${attendance.id}, UID: ${eventData.serialNo}, Employee ID: ${employeeId}`
      );
    }
  } catch (error) {
    logger.error(
      `Error in event processing: ${error.message}\nStack trace: ${error.stack}`
    );
  }
});

app.get("/", (req, res) => {
  return res.json({ status: "OK" });
});

// Endpoint untuk menangani multipart/form-data
app.post("/", upload.any(), async (req, res) => {
  try {
    let eventLog = req.body.event_log;
    logger.info("Received event log:", eventLog);
    console.log("Received event log:", eventLog);

    if (!eventLog) {
      return res.status(400).json({ error: "Event log is missing" });
    }

    // Parse the JSON string into an object
    let parsedEventLog;
    try {
      parsedEventLog = JSON.parse(eventLog);
    } catch (parseError) {
      return res.status(400).json({ error: "Invalid JSON format" });
    }

    // Emit the event for processing
    eventEmitter.emit("receivedLog", parsedEventLog);
    res.json({ status: "Event received and processing started" });
  } catch (error) {
    res.status(500).json({ error: "Internal server error" });
  }
});

const host = process.env.HOST || "127.0.0.1";
const port = process.env.PORT || 7650;

// Mulai server
const server = app.listen(port, host, () => {
  logger.info("Server started at http://" + host + ":" + port);
});

server.on("error", (err) => {
  logger.error(`Server error: ${err.message}`);
}); 