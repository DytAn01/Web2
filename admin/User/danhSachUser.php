<div class="danhsach-container">
    <div class="title">
        <h1>Danh sách hóa đơn</h1>
    </div>

    <div class="date-picker">
        <form action="" id="search-form">

            <input type="submit" value="Tìm kiếm" style="margin-bottom: 5px">
        </form>
    </div>

    <div class="table-container">
        <table class="data-table">
            <tr>
                <td>ID</td>
                <td>Username</td>
                <td>Họ tên</td>
                <td>SĐT</td>
                <td>Email</td>
                <td>Địa chỉ</td>
                <td>Vai trò</td>
                <td></td>
            </tr>

            <?php
            foreach ($users as $user) {
                extract($user);
                $xoa = "index.php?act=xoaUser&id=" . $userID;

                echo '<tr>
                <td>' . $userID . '</td>
                <td>' . $username . '</td>
                <td>' . $hovaten . '</td>
                <td>' . $sodienthoai . '</td>
                <td>' . $email . '</td>
                <td>' . $diachi . '</td>
                <td>
                <select name="" class="role-select" id="' . $userID . '">';
                foreach ($roles as $role) {
                    extract($role);
                    $ma == $role_id ? $s = 'selected' : $s = '';
                    echo '<option value="' . $ma . '" ' . $s . '>' . $role . '</option>';
                }
                echo '</td>
                <td><a href="' . $xoa . '" onclick="return confirm(\'Bạn có chắc chắn muốn xóa đối tượng này?\')">
                    <input type="button" value="Xóa"></a></td>
                </tr>';

            }
            ?>
        </table>

        <script>
            $('.role-select').change(function () {
                // Lấy giá trị role_id mới từ select box
                var newRoleId = $(this).val();

                // Lấy user ID từ thuộc tính data-userid
                var userId = $(this).attr('id');

                // Gửi yêu cầu AJAX để cập nhật vai trò
                $.ajax({
                    url: 'User/updateUserRole.php',
                    method: 'POST',
                    data: { userId: userId, roleId: newRoleId },
                    success: function (response) {
                        // Xử lý kết quả nếu cần
                        console.log(response);
                    },
                    error: function (xhr, status, error) {
                        // Xử lý lỗi nếu có
                        console.error(xhr.responseText);
                    }
                });
            });
        </script>


        <div class="table-footer">
            <a href="index.php?act=addUser"><input type="button" value="Thêm"></a>
        </div>
        <script>
        </script>
    </div>
</div>