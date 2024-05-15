<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js">
</script>
<script>
 function RegexData() {
    var hoten = document.getElementById("hoten").value;
    var dienthoai = document.getElementById("dienthoai").value;
    var diachi = document.getElementById("diachi").value;
    var email = document.getElementById("email").value;
    var tendangnhap = document.getElementById("tendangnhap").value;
    var pass = document.getElementById("pass").value;
    var repass = document.getElementById("repass").value;

    var usernamePattern = /^[a-zA-Z0-9]+$/;
    var passwordPattern = /^(?=.*\S).{8,}$/;
    var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    var phonePattern = /^0\d{9}$/; 
    var namePattern = /^.{3,50}$/;

    var isValid = true;

    if (!namePattern.test(hoten)) {
        document.getElementById("hotenerrortxt").style.display = "block";
        isValid = false;
    } else {
        document.getElementById("hotenerrortxt").style.display = "none";
    }

    if (!phonePattern.test(dienthoai)) {
        document.getElementById("dienthoaierrortxt").style.display = "block";
        isValid = false;
    } else {
        document.getElementById("dienthoaierrortxt").style.display = "none";
    }

    if (diachi.length < 3) {
        document.getElementById("diachierrortxt").style.display = "block";
        isValid = false;
    } else {
        document.getElementById("diachierrortxt").style.display = "none";
    }

    if (!emailPattern.test(email)) {
        document.getElementById("emailerrortxt").style.display = "block";
        isValid = false;
    } else {
        document.getElementById("emailerrortxt").style.display = "none";
    }

    if (!usernamePattern.test(tendangnhap)) {
        document.getElementById("usernameerrortxt").style.display = "block";
        isValid = false;
    } else {
        document.getElementById("usernameerrortxt").style.display = "none";
    }

    if (!passwordPattern.test(pass)) {
        document.getElementById("passerrortxt").style.display = "block";
        isValid = false;
    } else {
        document.getElementById("passerrortxt").style.display = "none";
    }

    if (pass !== repass) {
        document.getElementById("repasserrortxt").style.display = "block";
        isValid = false;
    } else {
        document.getElementById("repasserrortxt").style.display = "none";
    }

    return isValid;
}

function submitData() {
    if(RegexData()){  
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
                response = JSON.parse(response);
                let message = response.message;
                alert(message);
                if (message === "Đăng nhập thành công!") {
                    window.location.href = './index.php';
                }
                if (message === "Đăng ký thành công!") {
                    alert("Đang chuyển sang trang đăng nhập")
                    window.location.href = './signin.php';
                }
            }
        });
    }
}
  document.onkeydown = function () {
    if (window.event.keyCode == '13') {
      submitData();
    }
  }
</script>