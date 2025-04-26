<?php

// Xử lý đăng ký
if (isset($_POST['gui'])) {
    // Lấy và làm sạch dữ liệu từ form
    $tenkh = filter_input(INPUT_POST, 'hoten', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $diachi = filter_input(INPUT_POST, 'diachi', FILTER_SANITIZE_STRING);
    $pass = $_POST['pass']; // Sẽ mã hóa mật khẩu
    $dienthoai = filter_input(INPUT_POST, 'dienthoai', FILTER_SANITIZE_STRING);

    // Kiểm tra dữ liệu đầu vào
    if (empty($tenkh) || empty($email) || empty($pass) || empty($dienthoai) || empty($diachi)) {
        echo '<h3 style="margin-left:5px; color:red;">Vui lòng điền đầy đủ thông tin!</h3>';
        echo '<a href="?quanly=dangkymoi" style="margin:20px; text-decoration:none;">Quay lại</a>';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '<h3 style="margin-left:5px; color:red;">Email không hợp lệ!</h3>';
        echo '<a href="?quanly=dangkymoi" style="margin:20px; text-decoration:none;">Quay lại</a>';
    } else {
        // Mã hóa mật khẩu
        $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

        // Truy vấn đăng ký sử dụng prepared statement
        $sql_dangky = "INSERT INTO dangky (tenkhachhang, email, matkhau, dienthoai, diachinhan) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql_dangky);
        $stmt->bind_param("sssss", $tenkh, $email, $hashed_password, $dienthoai, $diachi); // "sssss" là kiểu string cho tất cả tham số

        // Thực thi truy vấn
        if ($stmt->execute()) {
            echo '<h3 style="margin-left:5px; color:green;">Bạn đã đăng ký thành công</h3>';
            echo '<a href="?quanly=dangnhap" style="margin:20px; text-decoration:none; color:blue;">Quay lại để đăng nhập mua hàng</a>';
        } else {
            echo '<h3 style="margin-left:5px; color:red;">Đăng ký thất bại: ' . htmlspecialchars($stmt->error) . '</h3>';
            echo '<a href="?quanly=dangkymoi" style="margin:20px; text-decoration:none;">Quay lại</a>';
        }

        // Đóng statement
        $stmt->close();
    }
}

// Đóng kết nối
$conn->close();
?>

<div class="tieude">
	HOAN NGHÊNH QUÝ BẠN ĐẶT HÀNG TẠI XƯỞNG PHỤ KIỆN
</div>
<div class="thongbao">
	<p><img src="imgs/chu-y-mua-hang.gif" width="100" height="50"></p>
	<p>- Vui lòng không đặt số lượng 1 sản phẩm</p>
    <p>- Không đặt đơn hàng có tổng giá trị dưới 200.000đ</p>
    <p>- Đơn hàng nhiều sản phẩm. Vui lòng liệt kê danh sách + số lượng qua Email, Zalo</p>
</div>
<div class="dangky">
  <p style="font-size:18px; color:red;margin:5px;">Các mục dấu * là bắt buộc tối thiểu. Vui lòng điền đầy đủ và chính xác (Số nhà, Ngõ, thôn xóm/ấp, Phường/xã, huyện/quận, tỉnh, TP)</p>
  <form action="" method="post" enctype="multipart/form-data">
	<table width="100%" border="1" style="border-collapse:collapse;">
  <tr>
    <td width="40%">Họ tên người mua <strong style="color:red;"> (*)</strong></td>
    <td width="60%"><input type="text" name="hoten" size="50"></td>
  </tr>
  <tr>
    <td>Địa chỉ Email <strong style="color:red;"> (*)</strong></td>
    <td width="60%"><input type="text" name="email" size="50"></td>
  </tr>
  <tr>
    <td>Mật khẩu  <strong style="color:red;"> (*)</strong></td>
    <td width="60%"><input type="password" name="pass" size="50"></td>
  </tr>
  <tr>
    <td>Điện thoại <strong style="color:red;"> (*)</strong></td>
     <td width="60%"><input type="text" name="dienthoai" size="50"></td>
  </tr>
  <tr>
    <td>Địa chỉ nhận hàng <strong style="color:red;"> (*)</strong></td>
   <td width="60%"><input type="text" name="diachi" size="50"></td>
  </tr>
  <tr>
    <td colspan="2">
    	 	
           <p><input type="submit" name="gui" value="Gửi thông tin" /></p>
         
    </td>
    </tr>
</table>
</form>
<div class="ghichu">
	<p>Ghi chú nếu có :</p>
	<textarea name="ghichu">
    
    </textarea>

