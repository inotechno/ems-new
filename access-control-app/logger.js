import log4js from 'log4js';

// Konfigurasi log4js
log4js.configure({
  appenders: {
    console: {
      type: 'console',
      layout: {
        type: 'pattern',
        pattern: '%d{yyyy-MM-dd hh:mm:ss.SSS} [%p] %c - %m'
      }
    },
    file: {
      type: 'file',
      filename: 'logs/app.log',
      maxLogSize: 10485760, // 10MB
      backups: 5,
      layout: {
        type: 'pattern',
        pattern: '%d{yyyy-MM-dd hh:mm:ss.SSS} [%p] %c - %m'
      }
    },
    errorFile: {
      type: 'file',
      filename: 'logs/error.log',
      maxLogSize: 10485760, // 10MB
      backups: 5,
      layout: {
        type: 'pattern',
        pattern: '%d{yyyy-MM-dd hh:mm:ss.SSS} [%p] %c - %m'
      }
    }
  },
  categories: {
    default: {
      appenders: ['console', 'file'],
      level: 'info'
    },
    error: {
      appenders: ['console', 'errorFile'],
      level: 'error'
    }
  }
});

// Buat logger instance
const logger = log4js.getLogger();

// Fungsi untuk error logger
const errorLogger = log4js.getLogger('error');

// Export logger dan error logger
export { errorLogger };
export default logger; 