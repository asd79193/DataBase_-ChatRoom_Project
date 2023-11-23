<?php
// 在需要连接数据库的页面中引入数据库连接文件
include 'DB_connect.php';

// 假设你已经连接到数据库

// 查询在线用户
$query = "SELECT user_name FROM users WHERE state_number = 1"; // 假设 state_number 表示在线状态
$result = mysqli_query($conn, $query);

if ($result) {
    $onlineUsers = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $onlineUsers[] = $row['user_name']; // 注意此处的索引
    }

    // 返回在线用户列表
    header('Content-Type: application/json');
    echo json_encode($onlineUsers);
    
    exit; // 或者 die();
} else {
    // 查询失败时的处理
    http_response_code(500);
    echo json_encode(array('message' => 'Failed to fetch online users.'));
}
?>
