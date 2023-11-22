<?php session_start(); ?>
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
    <div class="online_overlay">
        <!-- 登出按钮 -->
        <button onclick="logout()" class="logout-button">登出</button>
    </div>
    <h2>在線列表</h2>

    <script>

        window.onload = function() {
        document.getElementById('messageInput').focus();
        };

        function sendMessage() {

           const messageInput = document.getElementById('messageInput');
           const message = messageInput.value.trim();

            if (message !== '') {
                const chatMessages = document.getElementById('chatMessages');
                const newMessageContainer = document.createElement('div');
                newMessageContainer.classList.add('message', 'sent');

                // 创建包含用户名的元素
                const usernameElement = document.createElement('div');
                usernameElement.classList.add('username-container'); // 新添加的类名
                usernameElement.textContent = username; // 直接使用之前定义的 username 变量
                // 将用户名元素添加到消息容器中
                chatMessages.appendChild(usernameElement); // 將用户名元素添加到聊天框的上方

                // 将用户名元素添加到消息容器中
                newMessageContainer.appendChild(usernameElement); // 将用户名元素添加到消息容器中



                const newMessage = document.createElement('div');
                newMessage.classList.add('bubble');
                newMessage.textContent = message;
                newMessageContainer.appendChild(newMessage);
                chatMessages.appendChild(newMessageContainer);
                messageInput.value = ''; // 清空输入框
                chatMessages.scrollTop = chatMessages.scrollHeight; // 滚动到底部显示最新消息

                // 模拟接收到的消息
                /*
                setTimeout(function() {
                    const receivedMessageContainer = document.createElement('div');
                    receivedMessageContainer.classList.add('message', 'received');
                    const receivedMessage = document.createElement('div');
                    receivedMessage.classList.add('bubble');
                    receivedMessage.textContent = "这是接收到的消息";
                    receivedMessageContainer.appendChild(receivedMessage);
                    chatMessages.appendChild(receivedMessageContainer);
                    chatMessages.scrollTop = chatMessages.scrollHeight; // 滚动到底部显示最新消息
                }, 500); // 模拟延迟接收消息，以便测试 */
            }
        }
        function handleKeyDown(event) {
            if (event.key === 'Enter' && !event.shiftKey) {
                event.preventDefault(); // 防止换行
                sendMessage(); // 调用发送消息的函数
            }
        }

        function logout() {
            // 在此处执行登出操作，例如清除会话
            // 重定向到登出页面或执行其他必要的操作
            window.location.href = 'login.html'; // 跳转到登出页面
        }

        
    </script>
</body>

</html>