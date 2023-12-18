<?php
session_start();

include 'DB_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id']) && isset($_POST['state_number'])) {
    // POST->獲取 用戶ID & 狀態值
    $user_id = $_POST['user_id'];
    $state_number = $_POST['state_number'];

    $conn = new mysqli($servername, $username, $password, $dbname);

    // 連線檢查
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // 資料庫更新用戶狀態
    $sql = "UPDATE users SET state_number = $state_number WHERE user_id = $user_id";

    if ($conn->query($sql) === TRUE) {
        // 更新成功
        echo "User status updated successfully";
    } else {
        // 更新失敗
        echo "Error updating user status: " . $conn->error;
    }

    $conn->close();
} else {
    // 請求不是 POST 回傳
    echo "Invalid request";
}
?>
