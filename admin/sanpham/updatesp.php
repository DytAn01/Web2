<?php
extract($sanpham);
$imgpath = './uploads/' . $img_src;
if (is_file($imgpath)) {
    $img = $imgpath;
} else {
    $img = '';
}
?>

<div class="content">
    <h1>Thêm mới sản phẩm</h1>
    <div class="row">
        <form action="index.php?act=updateSanPham" method="post" enctype="multipart/form-data">
            <div class="row">
                Tên sản phẩm: <input type="text" name="tenSP" value="<?php echo $tenSP ?>">
            </div>
            <div class="row">
                Số lượng: <input type="text" name="soluong" value="<?php echo $soluong ?>">
            </div>
            <div class="row">
                Đơn giá: <input type="text" name="dongia" value="<?php echo $dongia ?>">
            </div>
            <div class="row">
                Kiểu dáng:
                <select name="makieudang" id="">
                    <?php
                    var_dump($listkieudang);
                    foreach ($listkieudang as $kieu) {
                        extract($kieu);
                        $ma == $makieudang ? $s = 'selected' : $s = '';
                        echo '<option value="' . $ma . '" ' . $s . '>' . $ten . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="row">
                Đối tượng sử dụng:
                <select name="madoituongsd" id="">
                    <?php
                    var_dump($listdoituongsd);
                    foreach ($listdoituongsd as $doituong) {
                        extract($doituong);
                        $ma == $madoituongsd ? $s = 'selected' : $s = '';
                        echo '<option value="' . $ma . '" ' . $s . '>' . $ten . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="row">
                Chất liệu:
                <select name="machatlieu" id="">
                    <?php
                    foreach ($listchatlieu as $chatlieu) {
                        extract($chatlieu);
                        $ma == $machatlieu ? $s = 'selected' : $s = '';
                        echo '<option value="' . $ma . '" ' . $s . '>' . $ten . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="row">
                img: <input type="file" name="img">
                <img class="image" src="<?= $img; ?>" height='80'">
                <button onclick=" deleteImage(event)">Xóa</button>
            </div>

            <script>
                function deleteImage(event) {
                    event.preventDefault();

                    $.ajax({
                        url: 'SanPham/delete_image.php',
                        type: 'POST',
                        data: {
                            img: '<?= $img; ?>',
                            maSP: '<?= $maSP; ?>'
                        },
                        success: function (response) {
                            $('.image').attr('src', '');
                            alert(response);
                        }
                    });
                }
            </script>

            <div>
                <input type="hidden" name="maSP" value="<?php if ($maSP > 0)
                    echo $maSP; ?>">
                <input type="submit" name="capnhat" value="Cập nhật">
                <a href="index.php?act=sanpham"><input type="button" value="Danh sách"></a>
            </div>
            <?php if (isset($thongbao) && ($thongbao != ''))
                echo $thongbao; ?>
        </form>
    </div>
</div>
</div>