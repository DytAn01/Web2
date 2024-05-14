<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết hóa đơn</title>
</head>

<body>
    <div id="chitiet">
        <h1>Chi tiết hóa đơn</h1>
        <p>Mã hóa đơn: <?php echo $maHD; ?></p>
        <p>Ngày xuất hóa đơn: <?php echo $ngayxuatHD; ?></p>
        <p style="margin-bottom: 20px">Tổng tiền: <?php echo number_format($thanhtien, 0, ',', '.'); ?> VND</p>

        <table>
            <thead>
                <tr>
                    <th>Tên sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Đơn giá</th>
                    <th>Tổng tiền</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $item) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['tensp']); ?></td>
                        <td><?php echo htmlspecialchars($item['soluong']); ?></td>
                        <td><?php echo number_format($item['tongtien'] / $item['soluong'], 0, ',', '.'); ?> VND</td>
                        <td><?php echo number_format($item['tongtien'], 0, ',', '.'); ?> VND</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

</body>

<style>
    chitiet {
        margin: 20px;
        width: 80%;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    table,
    th,
    td {
        border: 1px solid black;
    }

    th,
    td {
        padding: 8px;
        text-align: left;
    }
</style>

</html>