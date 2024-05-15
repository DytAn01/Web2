<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js">
</script>
<script>
  function submitData() {
      $.ajax({
        url: 'account_process.php',
        type: 'post',
        data: {
          hoten: $("#hoten").val(),
          dienthoai: $("#dienthoai").val(),
          diachi: $("#diachi").val(),
          email: $("#email").val(),
          tendangnhap: $("#tendangnhap").val(),
          pass: $("#pass").val(),
          repass: $("#repass").val(),
          action: $("#action").val(),
        },
        success: function (response) {
          // if (response) {
          //   try {
              response = JSON.parse(response);
          //   } catch (e) {
          //     console.error('Invalid JSON:', response);
          //   }
          // } else {
          //   console.error('Response is empty');
          // }


          // Extracting data from the response
          let message = response.message;
          alert(message);
          // Handling login based on permissions and message
          // let maQuyenAdmin = [1, 5, 9, 13, 17, 21, 25, 29];

          if (message === "Đăng nhập thành công!") {
          //   if (quyen == 30 && quyen.length == 1) {
          //     var popup = document.getElementById('popup-login-successful');
          //     popup.classList.add("open-popup");
          //     return;
          //   }
          //   if(quyen.some(r=> maQuyenAdmin.includes(+r))) {
          //     alert("Đăng nhập thành công. Bạn sẽ được chuyển hướng về trang quản lý.");
          //     window.location.href = 'admin';
          //     return;
          //   }
            window.location.href = './index.php';
          }

          // // Handling registration success
          if (message === "Đăng ký thành công!") {
            alert("Đang chuyển sang trang đăng nhập")
            window.location.href = './signin.php';
          }

          // // Handling login failure messages
          // if (["Vui lòng nhập tên đăng nhập và mật khẩu", "Tên tài khoản hoặc mật khẩu sai", "Mật khẩu sai", "Đã có lỗi xảy ra. Vui lòng thử lại sau."].includes(message)) {
          //   var popup = document.getElementById('popup-login-fail');
          //   popup.querySelector('p').textContent = message;
          //   popup.classList.add("open-popup");
          // }

          // // Handling registration failure messages
          // else if (["Vui lòng nhập đầy đủ thông tin", "Mật khẩu không khớp", "Tên tài khoản đã tồn tại"].includes(message)) {
          //   var popup = document.getElementById('popup-register-fail');
          //   popup.querySelector('p').textContent = message;
          //   popup.classList.add("open-popup");
          // } else {
          //   alert(message); // Displaying other error messages
          // }
        }
      });
    }
  document.onkeydown = function () {
    if (window.event.keyCode == '13') {
      submitData();
    }
  }
</script>