<?php

// 在需要连接数据库的页面中引入数据库连接文件
include 'DB_connect.php';
// 假设你已经建立了数据库连接

// 查询数据库获取用户名
$sql = "SELECT username FROM users"; // 这是一个简单的查询示例，你需要根据实际情况修改查询语句
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // 输出数据
    while($row = $result->fetch_assoc()) {
        echo "<div>" . $row["username"]. "</div>";
    }
} else {
    echo "0 results";
}
?>
