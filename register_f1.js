document.getElementById("SignUpbtn").addEventListener("click", function () {
    window.location.href = "loging_f1.html"; // เปลี่ยนเป็นลิงก์ที่ต้องการ
    showToast("Register successfully")
  });

closeModal();
    document.getElementById('personalForm').reset();
    document.getElementById('preview').style.display = 'none';

    // แสดง toast
    document.getElementById('toast').style.display = 'block';
    setTimeout(() => {
      document.getElementById('toast').style.display = 'none';
    }, 100000);