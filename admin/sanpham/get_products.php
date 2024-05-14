<?php
$page = $_GET['page'];
$products_per_page = 10;
$offset = ($page - 1) * $products_per_page;

$sortBy = $_GET['sortBy'];
$sortType = $_GET['sortType'];

$db = new PDO("mysql:host=localhost;dbname=shopmatkinh_db;charset=utf8", "root", "");
$stmt = $db->prepare("SELECT sp.*, cl.ten as chatlieu_ten, dt.ten as doituong_ten, kd.ten as kieudang_ten
                    from sanpham as sp
                    inner join chatlieusp as cl on sp.machatlieu = cl.ma
                    inner join doituongsd as dt on sp.madoituongsd = dt.ma
                    inner join kieudang as kd on sp.makieudang = kd.ma 
                    order by $sortBy $sortType
                    LIMIT :offset, :limit ");
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->bindParam(':limit', $products_per_page, PDO::PARAM_INT);
$stmt->execute();

$danhsach = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Tạo và trả về HTML

foreach ($danhsach as $item) {
    extract($item);
    $sua = "index.php?act=loadUpdateSanPham&id=" . $maSP;
    $xoa = "index.php?act=xoaSanPham&id=" . $maSP;

    $imgpath = '../images/product/' . $img_src .  '_11zon.png';
    $img = "<img src='" . $imgpath . "' height='100'>";

    echo '<tr>
    <td>' . $maSP . '</td>
    <td>' . $tenSP . '</td>
    <td>' . $soluong . '</td>
    <td>' . $dongia . '</td>
    <td>' . $kieudang_ten . '</td>
    <td>' . $doituong_ten . '</td>
    <td>' . $chatlieu_ten . '</td>
    <td>' . $img . '</td>
    <td><a href="' . $sua . '"><input type="button" value="Sửa"></a>
    <a href="' . $xoa . '" onclick="return confirm(\'Bạn có chắc chắn muốn xóa sản phẩm này?\')">
            <input type="button" value="Xóa"></a></td>
</tr>';

}
?>