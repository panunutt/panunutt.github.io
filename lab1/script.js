document.getElementById('loginForm').addEventListener('submit', function(event) {
    event.preventDefault();

    // ข้อมูลที่ใช้ในการตรวจสอบ (สามารถเปลี่ยนแปลงได้)
    const validUsername = "user";
    const validPassword = "password123";

    // ดึงข้อมูลจากฟอร์ม
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;

    // ตรวจสอบความถูกต้องของข้อมูล
    if (username === validUsername && password === validPassword) {
        alert('Login Successful!');
        // สามารถเปลี่ยนเส้นทางไปยังหน้าอื่นได้ เช่น window.location.href = "dashboard.html";
    } else {
        const errorMessage = document.getElementById('error-message');
        errorMessage.textContent = 'Invalid username or password!';
        errorMessage.style.display = 'block';
    }
});
