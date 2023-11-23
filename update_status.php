<?php
session_start();

include 'DB_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id']) && isset($_POST['state_number'])) {
    // 获取通过 POST 请求发送的用户 ID 和状态值
    $user_id = $_POST['user_id'];
    $state_number = $_POST['state_number'];

    $conn = new mysqli($servername, $username, $password, $dbname);

    // 检查连接
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // 更新用户状态
    $sql = "UPDATE users SET state_number = $state_number WHERE user_id = $user_id";

    if ($conn->query($sql) === TRUE) {
        // 更新成功
        echo "User status updated successfully";
    } else {
        // 更新失败
        echo "Error updating user status: " . $conn->error;
    }

    $conn->close();
} else {
    // 请求不是 POST 或缺少必要参数的情况
    echo "Invalid request";
}
?>
