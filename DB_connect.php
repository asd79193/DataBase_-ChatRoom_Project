<?php
// 資料庫連線
$servername = "localhost"; // 主機名(不用變)
$username = "root"; // 資料庫用户名
$password = ""; // 資料庫密码
$dbname = "chatroom"; // 資料庫名称

// 創建資料庫连接
$conn = new mysqli($servername, $username, $password, $dbname);

// 檢查連接是否成功
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    //echo "Connected successfully"; // 連接成功时的提示
    echo " ";
}
?>
