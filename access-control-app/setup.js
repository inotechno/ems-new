// Setup script untuk aplikasi Access Control
import { queryAsync } from './db.js';
import fs from 'fs';
import path from 'path';

async function setupDatabase() {
  try {
    console.log('Setting up database...');
    
    // Baca file SQL
    const schemaPath = path.join(process.cwd(), 'database-schema.sql');
    const whatsappFieldPath = path.join(process.cwd(), 'add-whatsapp-field.sql');
    
    if (fs.existsSync(schemaPath)) {
      const schema = fs.readFileSync(schemaPath, 'utf8');
      const statements = schema.split(';').filter(stmt => stmt.trim());
      
      for (const statement of statements) {
        if (statement.trim()) {
          await queryAsync(statement);
        }
      }
      console.log('Database schema created successfully');
    }
    
    if (fs.existsSync(whatsappFieldPath)) {
      const whatsappField = fs.readFileSync(whatsappFieldPath, 'utf8');
      const statements = whatsappField.split(';').filter(stmt => stmt.trim());
      
      for (const statement of statements) {
        if (statement.trim()) {
          await queryAsync(statement);
        }
      }
      console.log('WhatsApp field added successfully');
    }
    
    console.log('Database setup completed!');
  } catch (error) {
    console.error('Error setting up database:', error);
  }
}

async function createLogsDirectory() {
  try {
    const logsDir = path.join(process.cwd(), 'logs');
    if (!fs.existsSync(logsDir)) {
      fs.mkdirSync(logsDir);
      console.log('Logs directory created successfully');
    } else {
      console.log('Logs directory already exists');
    }
  } catch (error) {
    console.error('Error creating logs directory:', error);
  }
}

async function checkEnvironment() {
  console.log('Checking environment variables...');
  
  const requiredEnvVars = [
    'DB_HOST',
    'DB_USER', 
    'DB_PASSWORD',
    'DB_NAME'
  ];
  
  const missingVars = requiredEnvVars.filter(varName => !process.env[varName]);
  
  if (missingVars.length > 0) {
    console.warn('Warning: Missing environment variables:', missingVars);
    console.log('Please create a .env file with the required variables');
  } else {
    console.log('All required environment variables are set');
  }
}

async function main() {
  console.log('Starting setup...\n');
  
  await checkEnvironment();
  console.log('');
  
  await createLogsDirectory();
  console.log('');
  
  await setupDatabase();
  console.log('');
  
  console.log('Setup completed successfully!');
  console.log('You can now start the application with: npm start');
}

// Jalankan setup jika file ini dijalankan langsung
if (import.meta.url === `file://${process.argv[1]}`) {
  main().catch(console.error);
}

export { setupDatabase, createLogsDirectory, checkEnvironment }; 