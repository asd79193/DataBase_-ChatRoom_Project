<?php
// 在此之前需要先连接数据库
include 'DB_connect.php';

// 开始会话
session_start();

// 获取用户ID（这里假设你有用户ID存储在session中）
$user_id = $_SESSION['user_id'];

// 更新用户状态为0（假设你的用户状态字段为 `status`）
$sql = "UPDATE users SET state_number = 0 WHERE user_id = $user_id";

// 执行SQL查询
if ($conn->query($sql) === TRUE) {
    // 清除会话数据
    session_unset(); // 清除会话中的所有变量
    session_destroy(); // 销毁会话

    // 处理完登出逻辑后，可以根据需要重定向到其他页面或返回相应信息
    // 比如，重定向到登录页面
    header('Location: index.html');
    exit();
} else {
    // 如果更新失败，可以做一些错误处理
    echo "Error updating record: " . $conn->error;
}

// 关闭数据库连接
$conn->close();
?>
