
<?php 

session_start(); 

// 检查是否存在有效的会话
if (!isset($_SESSION['user_id'])) {
    // 重定向到登录页面
    header('Location: index.html');
    exit();
}
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

        /* 一鍵到底*/
        .scroll-button {
        width: 40px;
        height: 40px;
        background-image: url('image/down-arrow.png');
        background-size: cover;
        text-indent: -9999px;
        border: none;
        border-radius: 10px;
        position: fixed; /* 以视口为基准进行定位 */
        bottom: 60px; /* 距离底部的距离 */
        right: 20px; /* 距离右侧的距离 */
        z-index: 999; /* 可以调整按钮的层级 */
        background-color: #D5DBDB; /* Background color */
        cursor: pointer; /* Ensure pointer cursor */
        transition: background-color 0.3s ease; /* Smooth transition */
    }
        .scroll-button:hover {
        background-color: #737B7D; /* Change background color on hover */
    }

    /* 對話傳送時間*/
    .message-time {
    color: white; /* 設定時間文字顏色為白色 */
    font-size: 12px; /* 調整時間文字大小 */
    margin-bottom: 4px; /* 調整時間與訊息氣泡間距 */
    margin-left: 10px;
    margin-right: 10px;
    display: block; /* 讓時間元素從上至下顯示 */
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

    <!-- 一鍵到底 -->
    <button id="scrollToBottomBtn" class="scroll-button" style="display: none;"></button>


    <!--聊天框(輸入)  -->
    <div class="input_overlay">
        <input type="text" id="messageInput" placeholder="Enter your message..." style="width: 100%;" onkeydown="handleKeyDown(event)">
        <button onclick="sendMessage()" class="send-button">Send</button>
    </div>


    <!-- 在線顯示 -->
    <div class="online_overlay" id="user_show">
    <div id="onlineUsersList" style="max-height: 450px; overflow-y: auto;"></div>
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
        
        let currentScrollPosition = null;
        let wasScrolledToBottom = true;
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

            // Store the current content height
            const currentContentHeight = chatMessages.scrollHeight;

            // Clear previous content
            chatMessages.innerHTML = '';

            // Loop through the fetched data and create message elements
            data.forEach(message => {
                const messageContainer = document.createElement('div');
                messageContainer.classList.add('message');

                const messageBubble = document.createElement('div');
                messageBubble.classList.add('bubble');

                const timeElement = document.createElement('span');
                timeElement.classList.add('message-time'); // Add a class for styling time
                const messageTime = new Date(message.time).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                timeElement.textContent = messageTime;

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
                    messageContainer.appendChild(usernameElement);
                    messageContainer.appendChild(messageBubble);
                    messageContainer.appendChild(timeElement); // Move the time to the other side
                    
                } else {
                    messageContainer.classList.add('message','received');
                    messageContainer.appendChild(timeElement); // For received messages, time is on the original side
                    messageContainer.appendChild(usernameElement);
                    messageContainer.appendChild(messageBubble);
                }

                chatMessages.appendChild(messageContainer);
            });
            
            const username = data.length > 0 ? data[0].username : ''; // Get username from the first message if available
            //console.log('Extracted username:', username); // 输出提取的用户名
            // Add username to the chat box
            addUsernameToChat(username);

             // Calculate the new content height after appending messages
             const newContentHeight = chatMessages.scrollHeight - currentContentHeight;

            // Update the scroll position to retain the current view if not at the bottom
            if (!wasScrolledToBottom) {
                chatMessages.scrollTop += newContentHeight;
            }

            // Update wasScrolledToBottom based on the user's current position
            wasScrolledToBottom = isUserAtBottom;

            if (wasScrolledToBottom) {
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }

                   
        })
        .catch(error => {
            console.error('Error fetching or updating messages:', error);
        });
}

    //     // Function to scroll to the bottom of the chat
    //     function scrollToBottom() {
    //     const chatMessages = document.getElementById('chatMessages');
    //     chatMessages.scrollTop = chatMessages.scrollHeight;
    // }

    //     // Event listener for the scroll-to-bottom button
    //     const scrollToBottomBtn = document.getElementById('scrollToBottomBtn');
    //     scrollToBottomBtn.addEventListener('click', scrollToBottom);


 // Function to check scroll position and toggle button visibility
function checkScrollPosition() {
    const chatMessages = document.getElementById('chatMessages');
    const scrollToBottomBtn = document.getElementById('scrollToBottomBtn');

    if (chatMessages.scrollTop<1100) { // Adjust this value as needed
        scrollToBottomBtn.style.display = 'block';
    } else {
        scrollToBottomBtn.style.display = 'none';
    }
}

    // Event listener for chat messages scrolling
    const chatMessages = document.getElementById('chatMessages');
    chatMessages.addEventListener('scroll', checkScrollPosition);

    // Function to scroll to the bottom of the chat
    function scrollToBottom() {
        const chatMessages = document.getElementById('chatMessages');
        chatMessages.scrollTop = chatMessages.scrollHeight;
        document.getElementById('scrollToBottomBtn').style.display = 'none'; // Hide the button when scrolling to bottom
}

    // Event listener for the scroll-to-bottom button
    const scrollToBottomBtn = document.getElementById('scrollToBottomBtn');
    scrollToBottomBtn.addEventListener('click', scrollToBottom);


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
        setInterval(fetchAndUpdateChat, 100);
        }

        // When the page loads, start updating the chat
        window.onload = startChatUpdates;


    //    // 顯示在線用戶列表
    //     function displayOnlineUsers() {
    //     fetch('Show_username.php')
    //         .then(response => response.json())
    //         .then(data => {
    //         const onlineUsersContainer = document.getElementById('onlineUsersList');
    //         onlineUsersContainer.innerHTML = ''; // 清空在線用戶列表區域
    //         data.forEach(username => {
    //             const usernameElement = document.createElement('p');
    //             usernameElement.textContent = `${username} 在線中`;
    //             onlineUsersContainer.appendChild(usernameElement);

    //         });
    //     })
    //     .catch(error => {
    //         console.error('Error fetching online users:', error);
    //     });
    // }


    // Function to display online users with a limited height and scrollbar
    function displayOnlineUsers() {
    fetch('Show_username.php')
        .then(response => response.json())
        .then(data => {
            const onlineUsersContainer = document.getElementById('onlineUsersList');
            onlineUsersContainer.innerHTML = ''; // Clear the online users list area

            const maxUsersToShow = 100; // Maximum number of users to display
            const usersToShow = data.slice(0, maxUsersToShow); // Get a limited number of users

            usersToShow.forEach(username => {
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
    fetch('logout.php', {
        method: 'POST', // 使用 POST 请求来触发登出操作
        credentials: 'same-origin' // 确保发送请求时携带当前页面的认证信息
    })
    .then(response => {
        if (response.ok) {
            // 如果请求成功，重定向到登录页或者进行其他处理
            window.location.href = 'login.php';
        } else {
            // 处理请求失败的情况
            console.error('Logout request failed.');
        }
    })
    .catch(error => {
        console.error('Error during logout:', error);
    });
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