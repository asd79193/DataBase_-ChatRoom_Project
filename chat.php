
<?php session_start(); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"maximum-scale=1.0, user-scalable=no">

    <title>Real Time Chat Room</title>

    <style>
       body {
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: url('https://cdn.pixabay.com/photo/2018/08/14/13/23/ocean-3605547_1280.jpg') no-repeat;
            background-size: cover;
            background-position: center -40px;
            position: relative;
        }
        /* 對話內容顯示區塊 */
        .chat_overlay {
            position: absolute;
            top: 0;
            right: 0;
            width: 65%;
            height: 90%;
            background-color: rgba(0, 0, 0, 0.2); /* 这里的 rgba 值设置了半透明的黑色背景 */
            overflow-y: scroll; /* 添加滚动条 */
            padding: 10px; /* 添加内边距 */
            box-sizing: border-box; /* 让内边距和边框不撑大元素 */
        }
        .username-container {
            position: absolute;
            top: -30px; /* 调整用戶名在 Y 軸方向的位置 */
            color: #fff;
            padding: 5px;
            font-size: 18px;
            margin-bottom: 70px; /* 調整用戶名與對話框之間的間距 */
        }


        .message {
            display: flex;
            top: 30px; /* 调整用戶名在 Y 軸方向的位置 */
            flex-direction: row-reverse;
            align-items: flex-end;
            position: relative; /* 确保消息框是相对定位的 */
            margin-bottom: 50px; /* 调整对话框之间的间距 */
        }

        /* 左側消息样式 */
        .message.received {
            justify-content: flex-end;
        }

        .message.received .bubble {
            background-color:#c2e0ff ;
            border-radius: 10px;
            padding: 8px 12px;
            max-width: 70%;
            word-wrap: break-word;
        }

        /* 右侧消息样式 */
        .message.sent {
            justify-content: flex-start;
        }

        .message.sent .bubble {
            background-color: #DCF8C6;
            border-radius: 10px;
            padding: 8px 12px;
            max-width: 70%;
            word-wrap: break-word;
        }

        /* 在線顯示區塊 */
        .online_overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 35%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* 这里的 rgba 值设置了半透明的黑色背景 */
        }

        /* 輸入對話顯示區塊 */
        .input_overlay {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 65%;
            height: 10%;
            background-color: rgba(0, 0, 0, 0.25);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        h2{
            color: #fff;
            position: absolute;
            top: 0;
            left: 0;
            margin: 20px; /* 可以根据需要调整间距 */
        }

        /* 對話框 */
        input[type="text"] {
            width: 80%;
            padding: 8px;
            margin: 5px;
            border-radius: 5px;
            border: none;
            outline: none;
        }

        /* 送出按鈕 */
        .send-button {
            width: 50px; /* 设置按钮宽度 */
            height: 40px;
            background-color: rgb(225, 205, 91); /* 按钮背景颜色 */
            color: #644040; /* 按钮文字颜色 */
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        .send-button:hover {
            background-color: rgb(178, 151, 0); /* 鼠标悬停时的按钮背景颜色 */
        }
        .logout-button{
            width: 50px; /* 设置按钮宽度 */
            height: 40px;
            background-color: RGB(75, 85, 99); /* 按钮背景颜色 */
            color: #fff; /* 按钮文字颜色 */
            border: none;
            cursor: pointer;
            border-radius: 5px;
            position: absolute;
            bottom: 10px; /* 控制按钮距离底部的距离 */
            left: 10px; /* 控制按钮距离左侧的距离 */
            
        }
        .logout-button:hover{
            background-color: RGB(33, 47, 61); /* 鼠标悬停时的按钮背景颜色 */
        }

        #onlineUsersList {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        padding-left: 0; /* 如果需要，可以移除左边距 */
        margin-top: 70px; /* 调整元素距离顶部的距离 */
        margin-left:20px
        }

        #onlineUsersList p {
        color: white; /* 文字顏色 */
        font-size: 22px; /* 文字大小 */
        font-family: Arial, sans-serif; /* 字體 */
        top: 40px; /* 調整垂直位置 */
        left: 22px; /* 調整水平位置 */
        margin: 0px; /* 调整每个 p 元素之间的水平间距 */
        font-weight: bold; /* 可選：使用粗體以增加可讀性 */
        
        }

        #onlineCount{
           color: white; 
           position: absolute; 
           top: 2px; /* 調整垂直位置 */
           left: 120px;
           font-size: 22px; /* 文字大小 */
           font-family: Arial, sans-serif; /* 字體 */
        }




    </style>
</head>
<body>
    <script>
        // 通过在 PHP 文件中直接渲染用户名到 JavaScript 中
        const username = "<?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'Unknown'; ?>";
        // 在这里使用 username 变量进行需要的操作
        console.log(username); // 作为示例，将用户名输出到控制台
    </script>
  

    <!-- 聊天框(顯示) -->
    <div class="chat_overlay" id="chatMessages"></div>


    <!--聊天框(輸入)  -->
    <div class="input_overlay">
        <input type="text" id="messageInput" placeholder="Enter your message..." style="width: 100%;" onkeydown="handleKeyDown(event)">
        <button onclick="sendMessage()" class="send-button">Send</button>
    </div>


    <!-- 在線顯示 -->
    <div class="online_overlay" id="user_show">
    <div id="onlineUsersList"></div>
    </div>
    
     <!-- 登出按钮 -->  
     <button onclick="logout()" class="logout-button">登出</button>
        <h2>在線列表</h2>
        <p id="onlineCount"></p>
        

    <script>

        window.onload = function() {
        document.getElementById('messageInput').focus();
        displayOnlineUsers(); // Call the function to display online users when the page loads
        };        

	    function sendMessage() {
            const user_id = "<?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : ''; ?>";
            const messageInput = document.getElementById('messageInput');
            const message = messageInput.value.trim();

        if (message !== '') {
            const currentTime = new Date().toISOString(); // 獲取當前時間
            const data = {
                user_id: user_id,
                message: message,
                timestamp: currentTime
            };

        fetch('save_message.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => {
            if (response.ok) {
                // 在這裡可以處理成功的情況
                console.log('Message sent successfully!');
                // 清空輸入框
                messageInput.value = '';
            } else {
                // 處理錯誤情況
                throw new Error('Failed to send message.');
            }
        })
        .catch(error => {
            console.error('Error sending message:', error);
        });
    }
           
        //     const messageInput = document.getElementById('messageInput');
        //    const message = messageInput.value.trim();

        //     if (message !== '') {
        //         const chatMessages = document.getElementById('chatMessages');
        //         const newMessageContainer = document.createElement('div');
        //         newMessageContainer.classList.add('message', 'sent');

        //         // 创建包含用户名的元素
        //         const usernameElement = document.createElement('div');
        //         usernameElement.classList.add('username-container'); // 新添加的类名
        //         usernameElement.textContent = username; // 直接使用之前定义的 username 变量
        //         // 将用户名元素添加到消息容器中
        //         chatMessages.appendChild(usernameElement); // 將用户名元素添加到聊天框的上方

        //         // 将用户名元素添加到消息容器中
        //         newMessageContainer.appendChild(usernameElement); // 将用户名元素添加到消息容器中

        //         const newMessage = document.createElement('div');
        //         newMessage.classList.add('bubble');
        //         newMessage.textContent = message;
        //         newMessageContainer.appendChild(newMessage);
        //         chatMessages.appendChild(newMessageContainer);
        //         messageInput.value = ''; // 清空输入框
        //         chatMessages.scrollTop = chatMessages.scrollHeight; // 滚动到底部显示最新消息

        //         // 發送消息內容到後端保存到資料庫
        //         fetch('save_message.php', {
        //         method: 'POST',
        //         headers: {
        //         'Content-Type': 'application/x-www-form-urlencoded',
        //         },
        //         body: `message=${encodeURIComponent(message)}`,
        //         })
        //         .then(response => response.text())
        //         .then(contentId => {
        //         // 在這裡可以使用返回的 contentId，做進一步的操作或存儲到需要的地方
        //         console.log('Content ID:', contentId);
        //         })
        //         .catch(error => {
        //         console.error('Error saving message:', error);
        //         });

                

        //         // 模拟接收到的消息
        //         /*
        //         setTimeout(function() {
        //             const receivedMessageContainer = document.createElement('div');
        //             receivedMessageContainer.classList.add('message', 'received');
        //             const receivedMessage = document.createElement('div');
        //             receivedMessage.classList.add('bubble');
        //             receivedMessage.textContent = "这是接收到的消息";
        //             receivedMessageContainer.appendChild(receivedMessage);
        //             chatMessages.appendChild(receivedMessageContainer);
        //             chatMessages.scrollTop = chatMessages.scrollHeight; // 滚动到底部显示最新消息
        //         }, 500); // 模拟延迟接收消息，以便测试 */
        //     }

        }

        function handleKeyDown(event) {
            if (event.key === 'Enter' && !event.shiftKey) {
                event.preventDefault(); // 防止换行
                sendMessage(); // 调用发送消息的函数
            }
        }
        
        //let currentScrollPosition = 0;
        // Function to fetch and update chat messages
        function fetchAndUpdateChat() {
            fetch('save_message.php') // 確保這個路徑是正確的
            .then(response => {
                if (response.ok) {
                    return response.json(); // 解析 JSON 回應
                }
                throw new Error('Network response was not ok.');
            })
            .then(data => {
                //console.log('Fetched data:', data); // 输出获取的数据
                data.sort((a, b) => {
                    return new Date(a.time) - new Date(b.time);
                });

            const chatMessages = document.getElementById('chatMessages');
            const isUserAtBottom = chatMessages.scrollHeight - chatMessages.scrollTop === chatMessages.clientHeight;
            currentScrollPosition = chatMessages.scrollTop;

            // Clear previous content
            chatMessages.innerHTML = '';

            // Loop through the fetched data and create message elements
            data.forEach(message => {
                const messageContainer = document.createElement('div');
                messageContainer.classList.add('message');

                const messageBubble = document.createElement('div');
                messageBubble.classList.add('bubble');

                const usernameElement = document.createElement('div');
                usernameElement.classList.add('username-container'); // 新添加的类名
                usernameElement.textContent = message.user_name; // Use the username from each message

                messageBubble.textContent = message.message; // Assuming 'message' field contains the actual message

                const user_id = "<?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : ''; ?>";
                // 检查消息的发送者是否是当前用户
                const isCurrentUser = message.user_id === user_id
                // Apply appropriate style based on message sender
                if (isCurrentUser) {
                    messageContainer.classList.add('message', 'sent');

                } else {
                    messageContainer.classList.add('message','received');
                }

                messageContainer.appendChild(usernameElement);
                messageContainer.appendChild(messageBubble);
                chatMessages.appendChild(messageContainer);
            });

            // Optionally, scroll to the bottom to show the latest messages
            chatMessages.scrollTop = chatMessages.scrollHeight;

            const username = data.length > 0 ? data[0].username : ''; // Get username from the first message if available
            //console.log('Extracted username:', username); // 输出提取的用户名
            // Add username to the chat box
            addUsernameToChat(username);
           
                   
        })
        .catch(error => {
            console.error('Error fetching or updating messages:', error);
        });
}

        // Function to add username element to chat box
        function addUsernameToChat(username) {
        // 创建包含用户名的元素
    
        const usernameElement = document.createElement('div');
        usernameElement.classList.add('username-container'); // 新添加的类名
        usernameElement.textContent = username; // 直接使用传入的用户名变量

        // 将用户名元素添加到消息容器中
        const chatMessages = document.getElementById('chatMessages');
        chatMessages.insertBefore(usernameElement, chatMessages.firstChild); // 将用户名元素添加到聊天框的上方
        }

        // Function to continuously update chat every 5 seconds
        function startChatUpdates() {
        fetchAndUpdateChat(); // Fetch initial messages

        // Update chat messages every 5 seconds (adjust the interval as needed)
        setInterval(fetchAndUpdateChat, 1000);
        }

        // When the page loads, start updating the chat
        window.onload = startChatUpdates;


       // 顯示在線用戶列表
        function displayOnlineUsers() {
        fetch('Show_username.php')
            .then(response => response.json())
            .then(data => {
            const onlineUsersContainer = document.getElementById('onlineUsersList');
            onlineUsersContainer.innerHTML = ''; // 清空在線用戶列表區域
            data.forEach(username => {
                const usernameElement = document.createElement('p');
                usernameElement.textContent = `${username} 在線中`;
                onlineUsersContainer.appendChild(usernameElement);

            });
        })
        .catch(error => {
            console.error('Error fetching online users:', error);
        });
    }

    // 調用顯示在線用戶列表的函數
    displayOnlineUsers();

    function fetchOnlineUserCount() {
    fetch('getOnlineCount.php')
        .then(response => response.json())
        .then(data => {
            // 在页面中显示在线用户数量
            const onlineCountElement = document.getElementById('onlineCount');
            onlineCountElement.textContent = `(${data.onlineCount})`;
        })
        .catch(error => {
            console.error('Error fetching online user count:', error);
        });
    }

    // 调用这个函数来获取在线用户数量
    fetchOnlineUserCount();
    //刷新在線列表
    setInterval(fetchOnlineUserCount, 100);
    setInterval(displayOnlineUsers, 100);

        function logout() {
           // 发送 AJAX 请求
        const xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                // 如果请求成功，可以进行一些处理，例如跳转到登录页
                window.location.href = 'login.php'; // 跳转到登录页
            } else {
                // 处理请求失败的情况
                console.error('Logout request failed.');
            }
        }
        };
        // 发送 POST 请求到后端 PHP 文件，将用户状态标记为 0
        xhr.open('POST', 'update_status.php'); // update_status.php 是你要处理登出逻辑的后端 PHP 文件
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send('user_id=<?php echo $_SESSION['user_id']; ?>&state_number=0'); // 发送用户 ID 和状态值
    }

//     window.addEventListener('unload', function(event) {
//     // 發送 AJAX 請求以登出用戶
//     const xhr = new XMLHttpRequest();
//     xhr.open('POST', 'update_status.php');
//     xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
//     xhr.send('user_id=<?php echo $_SESSION['user_id']; ?>&state_number=0');
// });

//     window.addEventListener('beforeunload', function(event) {
//     // 在刷新時將狀態設為 1
//     const xhr = new XMLHttpRequest();
//     xhr.open('POST', 'update_status.php');
//     xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
//     xhr.send('user_id=<?php echo $_SESSION['user_id']; ?>&state_number=1');
// });

        
    </script>
</body>

</html>