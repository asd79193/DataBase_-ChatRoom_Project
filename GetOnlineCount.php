<?php
include 'DB_connect.php';

$query = "SELECT COUNT(*) AS onlineCount FROM users WHERE state_number = 1";
$result = mysqli_query($conn, $query);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $onlineCount = $row['onlineCount'];

    // 返回 JSON 格式的在线用户数量
    header('Content-Type: application/json');
    echo json_encode(array('onlineCount' => $onlineCount));
} else {
    http_response_code(500);
    echo json_encode(array('message' => 'Failed to fetch online user count.'));
}
?>
