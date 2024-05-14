<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="css/style.css?v=<?php echo time(); ?>">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
    <div class="container">
        <div class="sidebar">
            <!-- Nội dung của sidebar -->
            <div class="boxcenter">
                <H1>Admin</H1>
                <a href="logout.php" style="color:white">Đăng xuất</a>
            </div>
            <div class="row mb menu">
                <ul>
                    <li><a href="index.php?act=qlquyen">Quyền</a></li>
                    <li><a href="index.php?act=sanpham">Sản phẩm</a></li>
                    <li><a href="index.php?act=chatlieu">Chất liệu sản phẩm</a></li>
                    <li><a href="index.php?act=doituongsudung">Đối tượng sử dụng</a></li>
                    <li><a href="index.php?act=kieudang">Kiểu dáng</a></li>
                    <li><a href="index.php?act=user">Người dùng</a></li>
                    <li><a href="index.php?act=hoadon">Hóa đơn</a></li>
                    <li><a href="index.php?act=thongke">Thống kê</a></li>
                </ul>
            </div>
        </div>