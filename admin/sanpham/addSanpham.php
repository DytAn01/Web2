<div class="content">
    <h1>Thêm mới sản phẩm</h1>
    <div class="row">
        <form action="index.php?act=addSanPham" method="post" enctype="multipart/form-data">
            <div class="row">
                Tên sản phẩm: <input type="text" name="tenSP" required="true">
            </div>
            <div class="row">
                Số lượng: <input type="number" name="soluong" required="true">
            </div>
            <div class="row">
                Đơn giá: <input type="text" name="dongia" required="true">
            </div>
            <div class="row">
                Kiểu dáng:
                <select name="kieudang" id="">
                    <?php
                    foreach ($listkieudang as $kieu) {
                        extract($kieu);
                        echo '<option value="' . $ma . '">' . $ten . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="row">
                Đối tượng sử dụng:
                <select name="doituongsd" id="">
                    <?php
                    foreach ($listdoituongsd as $kieu) {
                        extract($kieu);
                        echo '<option value="' . $ma . '">' . $ten . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="row">
                Chất liệu:
                <select name="chatlieu" id="">
                    <?php
                    foreach ($listchatlieu as $kieu) {
                        extract($kieu);
                        echo '<option value="' . $ma . '">' . $ten . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="row">
                img: <input type="file" name="img">
            </div>
            <div>
                <input type="submit" name="themmoi" value="Thêm mới">
                <a href="index.php?act=danhSachSanPham"><input type="button" value="Danh sách"></a>
            </div>
            <?php if (isset($thongbao) && ($thongbao != ''))
                echo $thongbao; ?>
        </form>
    </div>
</div>
</div>