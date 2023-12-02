<?php
date_default_timezone_set('Asia/Taipei');
session_start();
include 'DB_connect.php';

// Function to fetch data from the database
function fetchDataFromDatabase() {
    global $conn; // Make the database connection available inside the function

    // Query to fetch data from the dialogue table
    $fetchSql = "SELECT * FROM dialogue ORDER BY time DESC "; // Change the query as per your requirement

    // Execute the query
    $result = $conn->query($fetchSql);

    if ($result && $result->num_rows > 0) {
        $data = $result->fetch_all(MYSQLI_ASSOC);

        // Loop through each dialogue entry and fetch username by user_id
        foreach ($data as &$dialogue) {
            $user_id = $dialogue['user_id'];
            $username = getUsernameById($user_id);

            // Add username to dialogue data
            $dialogue['user_name'] = $username;
        }

        return $data; // Return the fetched data with usernames
    }
}


// Function to get username by user_id
function getUsernameById($user_id) {
    global $conn; // Make the database connection available inside the function

    // Query to fetch username based on user_id
    $usernameSql = "SELECT user_name FROM users WHERE user_id = ?";

    // Prepare and execute the query
    $stmt = $conn->prepare($usernameSql);
    if ($stmt) {
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->bind_result($username);
        $stmt->fetch();
        $stmt->close();
        return $username; // Return the username
    } else {
        return null;
    }
}


// 確認是否收到 POST 請求
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 解析來自前端的 JSON 資料
    $data = json_decode(file_get_contents("php://input"));

    // 獲取資料
    $user_id = $data->user_id;
    $message = $data->message;
    $timestamp = $data->timestamp;

    // 驗證資料是否存在並且不是空值
    if ($user_id && $message && $timestamp) {
         // 將 ISO 8601 格式的時間轉換為台灣時間
         $date = new DateTime($timestamp);
         $date->setTimezone(new DateTimeZone('Asia/Taipei'));
         $taiwanTimestamp = $date->format('Y-m-d H:i:s');

        // 處理資料庫插入操作
        $insertSql = "INSERT INTO dialogue (user_id, message, time) VALUES (?, ?, ?)";

        // 使用預處理語句準備 SQL 語句
        $stmt = $conn->prepare($insertSql);
        if ($stmt) {
            // 綁定參數並執行語句
            $stmt->bind_param("iss", $user_id, $message, $taiwanTimestamp);
            if ($stmt->execute()) {
                // 插入成功
                echo "Message inserted successfully!";
            } else {
                // 插入失敗
                echo "Error: " . $insertSql . "<br>" . $conn->error;
            }
            // 關閉預處理語句
            $stmt->close();
        } else {
            echo "Error preparing statement!";
        }
    } else {
        echo "Invalid data received!";
    }
} else {

    // 如果不是 POST 請求，僅回傳最新的資料到前端
    $fetchedData = fetchDataFromDatabase(); // Fetch the latest data
    
    // Add usernames to the fetched data
    foreach ($fetchedData as &$dialogue) {
        $user_id = $dialogue['user_id'];
        $username = getUsernameById($user_id);
        $dialogue['user_name'] = $username;
    }
    echo json_encode($fetchedData); // Send the fetched data as a JSON response
}
?>
