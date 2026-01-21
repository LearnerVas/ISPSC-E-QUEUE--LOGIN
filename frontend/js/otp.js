function verifyOTP() {
    const otp = document.getElementById("otp").value;
  
    fetch("/backend/auth/verify_otp.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: "otp=" + otp,
    })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          window.location.href = "/frontend/dashboard.html";
        } else {
          document.getElementById("otpError").innerText = data.error;
        }
      });
  }
  