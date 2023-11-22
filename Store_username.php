<?php

session_start();

// 在需要连接数据库的页面中引入数据库连接文件
include 'DB_connect.php';

// 假设你已经建立了数据库连接

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username']) && isset($_POST['userpassword'])) {
    $username = $_POST['username'];
    $password = $_POST['userpassword']; // 获取密码

    /// 检查数据库中是否存在相同的用户名
    $check_sql = "SELECT * FROM users WHERE user_name = '$username'";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows > 0) {
        // 如果已经存在相同的用户名，则使用已存在的用户信息
        $row = $check_result->fetch_assoc();
        $_SESSION['username'] = $row['user_name']; // 使用已存在的用户名
        $_SESSION['user_id'] = $row['user_id']; // 使用已存在的用户 ID
        // 如果需要其他信息也可以从 $row 中获取

        echo "User already exists. Logged in!";
        header('Location: chat.php');
        exit();
    } else {
        // 如果用户不存在，则创建新用户
        $insert_sql = "INSERT INTO users (user_name, user_password) VALUES ('$username', '$password')";
        if ($conn->query($insert_sql) === TRUE) {
            $new_user_id = $conn->insert_id; // 获取新插入的记录的自增 ID
            $_SESSION['username'] = $username; // 使用新创建的用户名
            $_SESSION['user_id'] = $new_user_id; // 使用新创建的用户 ID
            // 如果需要其他信息也可以从表单获取或者进行其他操作

            echo "New user created successfully. User ID is: " . $new_user_id;
            header('Location: chat.php');
            exit();
        } else {
            echo "Error: " . $insert_sql . "<br>" . $conn->error;
            // 可以进行其他的错误处理或者重新定向
        }
    }
}


?>