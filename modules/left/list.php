<?php
// Ensure the database connection is available (included from config.php)
$sql_loai = "SELECT * FROM loaisp ORDER BY idloaisp ASC";
$result_loai = mysqli_query($conn, $sql_loai);
if (!$result_loai) {
    die('Query failed: ' . mysqli_error($conn));
}
?>
<div class="box_list">
    <div class="tieude">
        <h3>Loại phụ kiện</h3>
    </div>
    <ul class="list">
        <?php
        while ($dong_loai = mysqli_fetch_array($result_loai)) {
        ?>
            <li><a href="index.php?quanly=loaisp&id=<?php echo htmlspecialchars($dong_loai['idloaisp']) ?>"><?php echo htmlspecialchars($dong_loai['tenloaisp']) ?></a></li>
        <?php
        }
        ?>
    </ul>
</div><!-- Ket thuc div box loai phu kien -->

<?php
$sql_khang = "SELECT * FROM khangsp ORDER BY idkhangsp ASC";
$result_khang = mysqli_query($conn, $sql_khang);
if (!$result_khang) {
    die('Query failed: ' . mysqli_error($conn));
}
?>
<div class="box_list">
    <div class="tieude">
        <h3>Thương hiệu</h3>
    </div>
    <ul class="list">
        <?php
        while ($dong_khang = mysqli_fetch_array($result_khang)) {
        ?>
            <li><a href="index.php?quanly=khangsp&id=<?php echo htmlspecialchars($dong_khang['idkhangsp']) ?>"><?php echo htmlspecialchars($dong_khang['tenkhangsp']) ?></a></li>
        <?php
        }
        ?>
    </ul>
</div><!-- Ket thuc div box thuong khang -->

<div class="box_list">
    <div class="tieude">
        <h3>Hàng bán chạy</h3>
    </div>
    <?php
    $sql_banchay = "SELECT * FROM sanpham ORDER BY idsanpham DESC LIMIT 8";
    $result_banchay = mysqli_query($conn, $sql_banchay);
    if (!$result_banchay) {
        die('Query failed: ' . mysqli_error($conn));
    }
    ?>
    <ul class="hangbanchay">    
        <?php
        while ($dong_banchay = mysqli_fetch_array($result_banchay)) {
        ?>
            <li><a href="?quanly=chitietsp&idloaisp=<?php echo htmlspecialchars($dong_banchay['loaisp']) ?>&id=<?php echo htmlspecialchars($dong_banchay['idsanpham']) ?>">
                <img src="admincp/modules/quanlysanpham/uploads/<?php echo htmlspecialchars($dong_banchay['hinhanh']) ?>" width="150" height="150" />
                <p><?php echo htmlspecialchars($dong_banchay['tensp']) ?></p>
                <p style="color:red;"><?php echo number_format($dong_banchay['giadexuat']) . ' VNĐ' ?></p>
            </a></li>
        <?php
        }
        ?>
    </ul>
</div><!-- Ket thuc div box hang ban chay -->

<div class="box_list">
    <?php
    $sql = "SELECT * FROM tintuc";
    $result_tin = mysqli_query($conn, $sql);
    if (!$result_tin) {
        die('Query failed: ' . mysqli_error($conn));
    }
    ?>
    <div class="tieude">
        <h3>Tin tức sản phẩm</h3>
    </div>
    <ul class="tintucsp">    
        <?php
        while ($dong_tin = mysqli_fetch_array($result_tin)) {
        ?>
            <li><a href="#">
                <p style="float:left;"><img src="admincp/modules/quanlytintuc/uploads/<?php echo htmlspecialchars($dong_tin['hinhanh']) ?>" width="40" height="30" /></p>
                <p style="overflow:hidden;padding-left:5px;"><?php echo htmlspecialchars($dong_tin['tentintuc']) ?></p>
            </a></li>
        <?php
        }
        ?>
    </ul>
</div><!-- Ket thuc div box tin tức -->