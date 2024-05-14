<?php
include '../model/pdo.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the start date and end date from the request

    if (isset($_POST['startDate']) && isset($_POST['endDate'])) {
        $startDate = $_POST['startDate'];
        $endDate = $_POST['endDate'];
    } else {
        $startDate = '2000-01-01';
        $endDate = date('Y-m-d');
    }
    // // Perform the filtering logic here
    // $db = new PDO('mysql:host=localhost;dbname=shopmatkinh_db', 'root', '');
    // $stmt = $db->prepare("SELECT hoadon.*, users.username as tenKH, trangthai.trangthai as TT
    //                     FROM hoadon 
    //                     INNER JOIN users ON hoadon.maKH = users.userID
    //                     INNER JOIN trangthai ON hoadon.trangthai = trangthai.ma
    //                     WHERE ngayxuatHD BETWEEN :startDate AND :endDate");
    // $stmt->bindParam(':startDate', $startDate);
    // $stmt->bindParam(':endDate', $endDate);
    // $stmt->execute();
    // $filteredData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $sql = "SELECT hoadon.*, users.username as tenKH, trangthai.trangthai as TT
            FROM hoadon 
            INNER JOIN users ON hoadon.mataikhoan = users.    userID
            INNER JOIN trangthai ON hoadon.trangthai = trangthai.ma
            WHERE ngayxuatHD BETWEEN '$startDate' AND '$endDate'
            ORDER BY hoadon.maHD";
    $filteredData = pdo_query($sql);

    $sql = ("SELECT * FROM trangthai");
    $trangThai = pdo_query($sql);

    // Generate the filtered data table HTML
    $filteredTableHTML = '';

    // Iterate over the filtered data and generate table rows
    foreach ($filteredData as $item) {
        extract($item);
        $xem = "index.php?act=CTHoaDon&id=" . $maHD;

        // Generate the status select field HTML
        $statusSelectHTML = '<select class="status-select" data-hoadon-id="' . $maHD . '">';
        foreach ($trangThai as $status) {
            $selected = $status['ma'] == $trangthai ? ' selected' : '';
            $statusSelectHTML .= '<option value="' . $status['ma'] . '"' . $selected . '>' . $status['trangthai'] . '</option>';
        }
        $statusSelectHTML .= '</select>';

        $filteredTableHTML .= '<tr>
                <td>' . $maHD . '</td>  
                <td>' . $ngayxuatHD . '</td>
                <td>' . $mataikhoan . '</td>
                <td>' . $thanhtien . '</td>
                <td>' . $statusSelectHTML . '</td>
                <td><a href="' . $xem . '"><input type="button" value="Xem"></a>
            </tr>';
    }

    // Send the filtered table HTML as the response
    echo $filteredTableHTML;
}
?>