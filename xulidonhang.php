<?php
include "dbconnect.php";

if ($conn) {
    $sql = "SELECT * FROM hoadon,";
    $result = $conn->query($sql);
    $data = array();
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    echo json_encode($data);
} else {
    echo "Lỗi kết nối đến cơ sở dữ liệu.";
}
?>