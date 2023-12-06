<?php
session_start();

// 引入数据库连接文件
include 'DB_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username']) && isset($_POST['userpassword']) && isset($_POST['doublecheckpassword'])) {
    $username = $_POST['username'];
    $password = $_POST['userpassword']; // 获取密码
    $confirm_password = $_POST['doublecheckpassword']; // 获取确认密码

    if ($password === $confirm_password) { // 简单密码匹配
        // 插入数据到数据库
        $insert_sql = "INSERT INTO users (user_name, user_password, state_number) VALUES ('$username', '$password', 1)";

        if ($conn->query($insert_sql) === TRUE) {
            $new_user_id = $conn->insert_id; // 获取新插入的记录的自增 ID
            $_SESSION['username'] = $username; // 使用新创建的用户名
            $_SESSION['user_id'] = $new_user_id; // 使用新创建的用户 ID

            echo "New user created successfully. User ID is: " . $new_user_id;
            header('Location: chat.php');
            exit();
        } else {
            echo "Error: " . $insert_sql . "<br>" . $conn->error;
            // 可以进行其他的错误处理或者重新定向
        }
    } else {
        // 密码不匹配，重定向到注册页面并传递错误参数和用户名
        header('Location: register.php?error=password_mismatch&username=' . urlencode($username));
        exit();

    }
}
?>
