<?php
extract($kieudang);
?>

<div class="content">
    <h1>Cập nhật kiểu dáng</h1>
    <form action="index.php?act=updateKieuDang" method="post">
        <div>
            Tên chất liệu: <input type="text" name="ten" value="<?php if ($ten != '')
                echo $ten; ?>">
        </div>
        <div>
            <input type="hidden" name="ma" value="<?php if ($ma > 0)
                echo $ma; ?>">
            <input type="submit" name="capnhat" value="Cập nhật">
            <a href="index.php?act=danhSachKieuDang"><input type="button" value="Danh sách"></a>
        </div>
        <?php if (isset($thongbao) && ($thongbao != ''))
            echo $thongbao; ?>
    </form>
</div>
</div>