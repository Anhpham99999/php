<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông Tin Sinh Viên</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 10px;
            text-align: center;
        }

        h2 {
            color: #007BFF;
        }

        input[type='checkbox'] {
            width: 20px;
            height: 20px;
        }
    </style>
</head>
<body>
<body>

<?php
// Kết nối đến cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hoso";

$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Truy vấn SQL
$sql = "SELECT * FROM hoso";
$result = $conn->query($sql);

// Kiểm tra và hiển thị dữ liệu
if ($result->num_rows > 0) {
    echo "<h2>Thông Tin Cơ Bản</h2>";
    echo "<table>
            <tr>
                <th>Mã SV</th>
                <th>Tên SV</th>
                <th>Năm Sinh</th>
                <th>Giới Tính</th>
                <th>Số Điện Thoại</th>
                <th>Quốc Tịch</th>
                <th>Lớp</th>
            </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['masv']}</td>
                <td>{$row['tensv']}</td>
                <td>{$row['namsinh']}</td>
                <td>{$row['gioitinh']}</td>
                <td>{$row['sdt']}</td>
                <td>{$row['quoctich']}</td>
                <td>{$row['malop']}</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "Không có dữ liệu.";
}

// Truy vấn SQL cho Thông Tin Liên Quan
$sql = "SELECT * FROM luutru
        JOIN nguoithan ON luutru.masv = nguoithan.masv";
$result = $conn->query($sql);

// Kiểm tra và hiển thị dữ liệu
if ($result->num_rows > 0) {
    echo "<h2>Thông Tin Liên Quan</h2>";
    echo "<table>
            <tr>
                <th>Mã SV</th>
                <th>Nơi Lưu Trữ</th>
                <th>Ngày Bắt Đầu Lưu Trữ</th>
                <th>Ngày Kết Thúc Lưu Trữ</th>
                <th>Tên Cha</th>
                <th>SĐT Cha</th>
                <th>Tên Mẹ</th>
                <th>SĐT Mẹ</th>
            </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['masv']}</td>
                <td>{$row['noiluutru']}</td>
                <td>{$row['ngaybatdau']}</td>
                <td>{$row['ngayketthuc']}</td>
                <td>{$row['tencha']}</td>
                <td>{$row['sdtcha']}</td>
                <td>{$row['tenme']}</td>
                <td>{$row['sdtme']}</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "Không có dữ liệu.";
}

// Truy vấn SQL cho Thông Tin Bảo Hiểm
$sql = "SELECT * FROM bhyt
        JOIN chungchi ON bhyt.masv = chungchi.masv
        JOIN nguoidung ON bhyt.masv = nguoidung.masv";
$result = $conn->query($sql);

// Kiểm tra và hiển thị dữ liệu
if ($result->num_rows > 0) {
    echo "<h2>Thông Tin Bảo Hiểm và Chung Chỉ</h2>";
    echo "<table>
            <tr>
                <th>Mã SV</th>
                <th>Mã BHYT</th>
                <th>Ngày Tham Gia BHYT</th>
                <th>Ngày Kết Thúc BHYT</th>
                <th>CCTA</th>
                <th>CCQP</th>
                <th>CCTT</th>
                <th>Mật Khẩu</th>
                <th>Role</th>
            </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['masv']}</td>
                <td>{$row['mabhyt']}</td>
                <td>{$row['ngaythamgia']}</td>
                <td>{$row['ngayketthuc']}</td>
                <td><input type='checkbox' " . ($row['ccta'] ? 'checked' : '') . " disabled></td>
                <td><input type='checkbox' " . ($row['ccqp'] ? 'checked' : '') . " disabled></td>
                <td><input type='checkbox' " . ($row['cctt'] ? 'checked' : '') . " disabled></td>
                <td>{$row['matkhau']}</td>
                <td>{$row['role']}</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "Không có dữ liệu.";
}

// Đóng kết nối
$conn->close();
?>

</body>
</body>
</html>
