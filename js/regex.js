
    document.addEventListener('DOMContentLoaded', function() {
        // Lấy thẻ input và span error
        var hotenInput = document.getElementById('hoten');
        var hotenError = document.getElementById('hotenerrortxt');

        // Thêm sự kiện blur cho input
        hotenInput.addEventListener('blur', function() {
            validateHoten(); // Gọi hàm validateHoten khi input mất focus
        });

        // Lấy các ô input khác
        var otherInputs = document.querySelectorAll('.login-group input:not(#hoten)');

        // Thêm sự kiện input cho các ô input khác
        otherInputs.forEach(function(input) {
            input.addEventListener('input', function() {
                validateHoten(); // Gọi hàm validateHoten khi nhập vào ô khác
            });
        });

        // Hàm kiểm tra định dạng tên người dùng và hiển thị thông báo lỗi
        function validateHoten() {
            // Kiểm tra định dạng tên người dùng
            var hotenPattern = /^[a-zA-Z\s]{3,50}$/; // Chỉ chấp nhận các ký tự chữ và khoảng trắng, từ 3 đến 50 ký tự
            var hotenValue = hotenInput.value.trim(); // Lấy giá trị và loại bỏ khoảng trắng ở đầu và cuối
            if (!hotenPattern.test(hotenValue)) {
                // Nếu định dạng không hợp lệ, hiển thị thông báo lỗi
                hotenError.style.display = 'block';
            } else {
                // Nếu định dạng hợp lệ, ẩn thông báo lỗi
                hotenError.style.display = 'none';
            }
        }
    });

