function RegexData() {
    // Lấy các giá trị từ form
    var hoten = document.getElementById("hoten").value;
    var dienthoai = document.getElementById("dienthoai").value;
    var diachi = document.getElementById("diachi").value;
    var email = document.getElementById("email").value;
    var tendangnhap = document.getElementById("tendangnhap").value;
    var pass = document.getElementById("pass").value;
    var repass = document.getElementById("repass").value;

    // Biểu thức chính quy
    var usernamePattern = /^[a-zA-Z0-9]+$/;
    var passwordPattern = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;
    var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    var phonePattern = /^[0-9]{10}$/; // Số điện thoại phải có 10 hoặc 11 chữ số
    var namePattern = /^.{3,50}$/; // Tên phải có từ 3 đến 50 ký tự

    // Kiểm tra tên
    if (!namePattern.test(hoten)) {
        document.getElementById("hotenerrortxt").style.display = "block";
        return false;
    } else {
        document.getElementById("hotenerrortxt").style.display = "none";
    }

    // Kiểm tra số điện thoại
    if (!phonePattern.test(dienthoai)) {
        document.getElementById("dienthoaierrortxt").style.display = "block";
        return false;
    } else {
        document.getElementById("dienthoaierrortxt").style.display = "none";
    }

    // Kiểm tra địa chỉ
    if (diachi.length < 3) {
        document.getElementById("diachierrortxt").style.display = "block";
        return false;
    } else {
        document.getElementById("diachierrortxt").style.display = "none";
    }

    // Kiểm tra email
    if (!emailPattern.test(email)) {
        document.getElementById("emailerrortxt").style.display = "block";
        return false;
    } else {
        document.getElementById("emailerrortxt").style.display = "none";
    }

    // Kiểm tra tên đăng nhập
    if (!usernamePattern.test(tendangnhap)) {
        document.getElementById("usernameerrortxt").style.display = "block";
        return false;
    } else {
        document.getElementById("usernameerrortxt").style.display = "none";
    }

    // Kiểm tra mật khẩu
    if (!passwordPattern.test(pass)) {
        document.getElementById("passerrortxt").style.display = "block";
        return false;
    } else {
        document.getElementById("passerrortxt").style.display = "none";
    }

    // Kiểm tra mật khẩu nhập lại
    if (pass !== repass) {
        document.getElementById("repasserrortxt").style.display = "block";
        return false;
    } else {
        document.getElementById("repasserrortxt").style.display = "none";
    }

    // Nếu tất cả đều hợp lệ, gửi biểu mẫu
    document.getElementById("registerForm").submit();
}