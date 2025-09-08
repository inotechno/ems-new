// Contoh penggunaan untuk testing aplikasi
import axios from 'axios';

// Data contoh untuk testing
const testData = {
  event_log: JSON.stringify({
    ipAddress: "192.168.1.100",
    AccessControllerEvent: {
      employeeNoString: "12345",
      name: "John Doe",
      serialNo: "001"
    },
    dateTime: new Date().toISOString()
  })
};

// Fungsi untuk testing
async function testAttendance() {
  try {
    console.log('Testing attendance endpoint...');
    
    const response = await axios.post('http://127.0.0.1:7650/', testData, {
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      }
    });
    
    console.log('Response:', response.data);
  } catch (error) {
    console.error('Error:', error.response?.data || error.message);
  }
}

// Fungsi untuk testing health check
async function testHealthCheck() {
  try {
    console.log('Testing health check endpoint...');
    
    const response = await axios.get('http://127.0.0.1:7650/');
    
    console.log('Health check response:', response.data);
  } catch (error) {
    console.error('Error:', error.response?.data || error.message);
  }
}

// Jalankan test
async function runTests() {
  console.log('Starting tests...\n');
  
  await testHealthCheck();
  console.log('\n---\n');
  
  await testAttendance();
  console.log('\nTests completed!');
}

// Export untuk penggunaan di file lain
export { testAttendance, testHealthCheck, runTests };

// Jalankan jika file ini dijalankan langsung
if (import.meta.url === `file://${process.argv[1]}`) {
  runTests();
} 