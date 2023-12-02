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
        $stored_password = $row['user_password']; // 获取数据库中存储的密码
        if ($password === $stored_password) {
            // 密码匹配，重定向到 chat.php 页面
            $_SESSION['username'] = $row['user_name'];
            $_SESSION['user_id'] = $row['user_id'];

             // 更新 state_number 為 1
             $update_sql = "UPDATE users SET state_number = 1 WHERE user_name = '$username'";

             $conn->query($update_sql);
            header('Location: chat.php');
            exit();
        } else {
            // 密码不匹配，输出错误消息并停留在登录页面
            ob_start(); // 开始输出缓冲
            header("Location: login.php?error_message=password" . urlencode(ob_get_clean())); // 重定向并传递错误消息
            exit();
        }
    } else {
          // 新增新用戶並將 state_number 設置為 1
        $insert_sql = "INSERT INTO users (user_name, user_password, state_number) VALUES ('$username', '$password', 1)";
        
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