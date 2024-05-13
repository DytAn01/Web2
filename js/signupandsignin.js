/*******************************REGEX************************************ */
document.addEventListener("DOMContentLoaded", function() {
    // Lắng nghe sự kiện submit của form
    document.querySelector('.registration-form').addEventListener('submit', function(event) {
        // Kiểm tra điều kiện của từng trường input và hiển thị span tương ứng nếu có lỗi
        validateInput('hotentxt', 'hotenerrortxt', /^[a-zA-Z ]{3,50}$/, 'Tối thiểu 3 ký tự và tối đa 50 ký tự');
        validateInput('dienthoaitxt', 'dienthoaierrortxt', /^\d{10,12}$/, 'Số điện thoại không hợp lệ');
        validateInput('diachi', 'diachierrortxt', /^[a-zA-Z0-9\s,'-]*$/, 'Địa chỉ không hợp lệ');
        validateInput('emailtxt', 'emailerrortxt', /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/, 'Email không đúng định dạng');
        validateInput('tendangnhaptxt', 'usernameerrortxt', /^[a-zA-Z0-9]+$/, 'Username KHÔNG viết dấu, khoảng cách, in hoa và ký tự đặc biệt');
        validatePassword('passtxt', 'passerrortxt');
        validateRePassword('passtxt', 'repasstxt', 'passerrortxt', 'passerrortxt');

        // Ngăn chặn hành động mặc định của form
        event.preventDefault();
    });
});

// Hàm kiểm tra điều kiện và hiển thị span nếu có lỗi
function validateInput(inputId, spanId, regex, errorMessage) {
    var inputValue = document.querySelector('.registration-form input[name="' + inputId + '"]').value;
    var errorSpan = document.getElementById(spanId);
    if (!regex.test(inputValue)) {
        errorSpan.innerText = errorMessage; // Thiết lập thông báo lỗi
        errorSpan.style.display = 'block'; // Hiển thị span nếu có lỗi
    } else {
        errorSpan.style.display = 'none'; // Ẩn span nếu không có lỗi
    }
}

// Hàm kiểm tra mật khẩu không chứa khoảng trắng
function validatePassword(inputId, spanId) {
    var passwordValue = document.querySelector('.registration-form input[name="' + inputId + '"]').value;
    var errorSpan = document.getElementById(spanId);
    if (passwordValue.includes(' ')) {
        errorSpan.style.display = 'block'; // Hiển thị span nếu có lỗi
    } else {
        errorSpan.style.display = 'none'; // Ẩn span nếu không có lỗi
    }
}

// Hàm kiểm tra nhập lại mật khẩu khớp với mật khẩu đã nhập
function validateRePassword(passwordInputId, repasswordInputId, errorSpanId, errorSpanId2) {
    var passwordValue = document.querySelector('.registration-form input[name="' + passwordInputId + '"]').value;
    var repasswordValue = document.querySelector('.registration-form input[name="' + repasswordInputId + '"]').value;
    var errorSpan1 = document.getElementById(errorSpanId);
    var errorSpan2 = document.getElementById(errorSpanId2);
    if (passwordValue !== repasswordValue) {
        errorSpan1.style.display = 'block'; // Hiển thị span nếu có lỗi
        errorSpan2.style.display = 'block'; // Hiển thị span nếu có lỗi
    } else {
        errorSpan1.style.display = 'none'; // Ẩn span nếu không có lỗi
        errorSpan2.style.display = 'none'; // Ẩn span nếu không có lỗi
    }
}

// const submitBtn = document.getElementById('submitBtn');
// submitBtn.addEventListener('click', (e) => {
//     e.preventDefault()

// });