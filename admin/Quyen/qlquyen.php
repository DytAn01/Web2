<?php

// Kiểm tra xem người dùng đã đăng nhập chưa và có phải là admin không
if (!isset($_SESSION['username']) || $_SESSION['user_role'] !== "0") {
    $thongbao = "Bạn không có quyền truy cập trang này";
    include 'home.php';
    exit;
}

// Xử lý khi admin lưu thay đổi quyền
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $manager_permissions = isset($_POST['manager_permissions']) ? $_POST['manager_permissions'] : [];
    $employee_permissions = isset($_POST['employee_permissions']) ? $_POST['employee_permissions'] : [];

    // Cập nhật quyền cho quản lý
    $sql = "UPDATE permissions SET can_access = 0 WHERE role_id = (SELECT ma FROM roles WHERE role = 'Quản lý')";
    pdo_execute($sql);

    foreach ($manager_permissions as $permission) {
        $sql = "UPDATE permissions SET can_access = 1 WHERE role_id = (SELECT ma FROM roles WHERE role = 'Quản lý') AND action = '$permission'";
        pdo_execute($sql);
    }

    // Cập nhật quyền cho nhân viên
    $sql = "UPDATE permissions SET can_access = 0 WHERE role_id = (SELECT ma FROM roles WHERE role = 'Nhân viên')";
    pdo_execute($sql);

    foreach ($employee_permissions as $permission) {
        $sql = "UPDATE permissions SET can_access = 1 WHERE role_id = (SELECT ma FROM roles WHERE role = 'Nhân viên') AND action = '$permission'";
        pdo_execute($sql);
    }
}

// Lấy danh sách các quyền truy cập từ CSDL
$sql = "SELECT action, can_access, role_id FROM permissions";
$permissions = pdo_query($sql);

if (empty($permissions)) {
    $all_actions = ['Sản Phẩm', 'Chất liệu', 'Đối tượng sử dụng', 'Kiểu dáng', 'User', 'Hóa đơn', 'Thống kê'];
    $roles = [1, 2]; // role_id cho Quản lý và Nhân viên

    foreach ($all_actions as $action) {
        foreach ($roles as $role_id) {
            $sql = "INSERT INTO permissions (action, can_access, role_id) VALUES ('$action', 0, '$role_id')";
            pdo_execute($sql);
        }
    }

    // Sau khi thêm, load lại danh sách permissions
    $sql = "SELECT action, can_access, role_id FROM permissions";
    $permissions = pdo_query($sql);
}
?>

<div>
    <h1>Thiết lập quyền</h1>

    <form action="" method="post">
        <?php
        // Lặp qua từng role_id
        foreach ([1, 2] as $role_id):
            ?>
            <h2><?php echo ($role_id == 1) ? 'Quản lý' : 'Nhân viên'; ?></h2>
            <div class="checkboxes">
                <?php
                // Lấy danh sách quyền cho role_id hiện tại
                $permissions_by_role = array_filter($permissions, function ($permission) use ($role_id) {
                    return $permission['role_id'] == $role_id;
                });

                // Lặp qua danh sách quyền của role_id hiện tại
                foreach ($permissions_by_role as $permission):
                    ?>
                    <div class="checkbox-container">
                        <label class="checkbox-label">
                            <input type="checkbox"
                                name="<?php echo ($role_id == 1) ? 'manager_permissions[]' : 'employee_permissions[]'; ?>"
                                value="<?php echo $permission['action']; ?>" <?php echo $permission['can_access'] ? 'checked' : ''; ?>>
                            <?php echo $permission['action']; ?>
                        </label>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>

        <button type="submit">Lưu thay đổi</button>
    </form>
</div>


<style>
    /* Style cho form */
    form {
        max-width: 600px;
        margin: 0 auto;
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    /* Style cho tiêu đề */
    h1 {
        text-align: center;
        margin-bottom: 20px;
    }

    h2 {
        margin-top: 20px;
    }

    /* Style cho checkbox */
    input[type="checkbox"] {
        margin-right: 5px;
    }

    /* Style cho nút Lưu thay đổi */
    button[type="submit"] {
        display: block;
        width: 100%;
        padding: 10px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    /* Hover effect cho nút Lưu thay đổi */
    button[type="submit"]:hover {
        background-color: #0056b3;
    }

    .checkboxes {
        display: flex;
        flex-wrap: wrap;
        align-content: space-around;
        height: 5rem;
    }

    /* Style cho mỗi checkbox */
    .checkbox-container {
        margin-right: 20px;
    }

    /* Style cho nhãn của checkbox */
    .checkbox-label {
        margin-bottom: 5px;
    }
</style>