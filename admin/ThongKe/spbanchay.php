<?php
include '../model/pdo.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST["start_date"])) {
        $start_date = $_POST["start_date"];
        $end_date = $_POST["end_date"];
    } else {
        $start_date = "2000-01-01";
        $end_date = date("Y-m-d");
    }

    echo $start_date;
    echo $end_date;

    $sql = "SELECT c.maSP, p.tenSP, SUM(c.soluong) AS total_quantity 
            FROM chitiethoadon c 
            JOIN hoadon h ON c.maHD = h.maHD 
            JOIN sanpham p ON c.maSP = p.maSP
            WHERE h.ngayxuatHD BETWEEN '$start_date' AND '$end_date'
            GROUP BY c.maSP, p.tenSP
            ORDER BY total_quantity DESC 
            LIMIT 5";

    $result = pdo_query($sql);

    if ($result) {
        echo "</br>";
        echo "<h3>Thống kê top 5 sản phẩm bán chạy từ $start_date đến $end_date:</h3>";
        echo "</br>";
        echo "<ul>";
        foreach ($result as $row) {
            echo "<li>" . $row["maSP"] . " - " . $row["tenSP"] . " - Số lượng: " . $row["total_quantity"] . "</li>";
        }
        echo "</ul>";
    } else {
        echo "Không có dữ liệu thống kê.";
    }
}

?>