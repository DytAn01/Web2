<div class="content">
    <h1>Thêm mới kiểu dáng</h1>
    <divc class="row">
        <form action="index.php?act=addKieuDang" method="post">
            <div class="row">
                Tên chất liệu: <input type="text" name="ten" required="true">
            </div>
            <div>
                <input type="submit" name="themmoi" value="Thêm mới">
                <a href="index.php?act=danhSachKieuDang"><input type="button" value="Danh sách"></a>
            </div>
            <?php if (isset($thongbao) && ($thongbao != ''))
                echo $thongbao; ?>
        </form>
</div>
</div>
</div>