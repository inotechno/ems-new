import mysql from 'mysql2/promise';

// Konfigurasi database
const dbConfig = {
  host: process.env.DB_HOST || 'localhost',
  user: process.env.DB_USER || 'root',
  password: process.env.DB_PASSWORD || '',
  database: process.env.DB_NAME || 'employee_system',
  waitForConnections: true,
  connectionLimit: 10,
  queueLimit: 0
};

// Buat connection pool
const pool = mysql.createPool(dbConfig);

// Fungsi untuk menjalankan query secara asynchronous
export async function queryAsync(sql, params = []) {
  try {
    const [rows] = await pool.execute(sql, params);
    return rows;
  } catch (error) {
    console.error('Database query error:', error);
    throw error;
  }
}

// Fungsi untuk mendapatkan connection dari pool
export async function getConnection() {
  try {
    const connection = await pool.getConnection();
    return connection;
  } catch (error) {
    console.error('Database connection error:', error);
    throw error;
  }
}

// Fungsi untuk menutup pool
export async function closePool() {
  try {
    await pool.end();
    console.log('Database pool closed');
  } catch (error) {
    console.error('Error closing database pool:', error);
  }
}

export default pool; 