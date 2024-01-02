<?php
session_start();

// Kết nối đến cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "testole";

$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối đến cơ sở dữ liệu thất bại: " . $conn->connect_error);
}

// Lấy thông tin đăng nhập từ form
$tk_nguoidung = $_POST['tk'];
$mk_nguoidung = $_POST['mk'];

// Xử lý truy vấn SQL
$query = "SELECT * FROM nguoidung WHERE tk = '$tk_nguoidung' AND mk = '$mk_nguoidung'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    // Lưu thông tin đăng nhập vào session
    $row = $result->fetch_assoc();
    $_SESSION['tk_nguoidung'] = $row['tk'];
    $_SESSION['role'] = $row['role'];

    // Chuyển hướng đến trang tương ứng
    if ($row['role'] == 1) {
        header("Location: admin.php");
    } elseif ($row['role'] == 2) {
        header("Location: user.php");
    } else {
        echo "Quyền không hợp lệ";
    }
} else {
    echo "Đăng nhập thất bại. Vui lòng kiểm tra lại tên đăng nhập và mật khẩu.";
}

// Đóng kết nối
$conn->close();
?>
