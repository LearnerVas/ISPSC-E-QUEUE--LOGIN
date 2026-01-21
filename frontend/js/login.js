async function login() {
    const type = document.getElementById('type').value;
    const gmail = document.getElementById('gmail').value;
    const id = document.getElementById('id')?.value;
  
    const res = await fetch('/backend/auth/login.php', {
      method: 'POST',
      body: JSON.stringify({ type, gmail, id })
    });

    document.addEventListener("DOMContentLoaded", () => {
      const idInput = document.getElementById("student_id");
    
      if (idInput) {
        idInput.addEventListener("input", () => {
          idInput.value = idInput.value.toUpperCase();
        });
      }
    });
    
    document.getElementById("loginForm").addEventListener("submit", e => {
      e.preventDefault();
    
      const email = document.getElementById("email").value;
      const studentIdEl = document.getElementById("student_id");
      const student_id = studentIdEl ? studentIdEl.value.toUpperCase() : "";
    
      fetch("/backend/auth/login.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `email=${encodeURIComponent(email)}&student_id=${encodeURIComponent(student_id)}`
      })
      .then(res => res.json())
      .then(data => {
        if (!data.success) {
          alert(data.error);
          return;
        }
    
        // ✅ SEND OTP (POST, NOT GET)
        return fetch("/backend/auth/send_otp.php", {
          method: "POST",
          headers: { "Content-Type": "application/x-www-form-urlencoded" },
          body: `email=${encodeURIComponent(email)}`
        });
      })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          // ✅ THIS IS WHERE REDIRECT HAPPENS
          window.location.href = "/frontend/otp.html";
        } else {
          alert(data.error || "OTP failed");
        }
      })
      .catch(err => {
        console.error(err);
        alert("System error");
      });
    });
    

  
    if (res.ok) {
      await fetch('/backend/auth/send_otp.php');
      alert("OTP sent");
    }

    function showError(msg) {
      alert("⚠️ " + msg);
    }
    

  }
  