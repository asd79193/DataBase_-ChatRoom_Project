<!-- <?php session_start(); 

?> -->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome Chat Room</title>
  <style>
    body {
      background: url('https://cdn.pixabay.com/photo/2018/08/14/13/23/ocean-3605547_1280.jpg') no-repeat;
      background-size: 100% 130%;
    }

    #register_box {
      width: 20%;
      height: 400px;
      background-color: #00000060;
      margin: auto;
      margin-top: 10%;
      text-align: center;
      border-radius: 10px;
      padding: 50px 50px;
    }

    h1 {
      color: #ffffff90;
      margin-top: 5%;
    }

    #input_box {
      margin-top: 5%;
    }

    span {
      color: #fff;
    }

    input {
      border: 0;
      width: 60%;
      font-size: 15px;
      color: #fff;
      background: transparent;
      border-bottom: 2px solid #fff;
      padding: 5px 10px;
      outline: none;
      margin-top: 10px;
    }

    button {
      margin-top: 50px;
      width: 60%;
      height: 30px;
      border-radius: 10px;
      border: 0;
      color: #fff;
      text-align: center;
      line-height: 30px;
      font-size: 15px;
      background-image: linear-gradient(to right, #30cfd0, #330867);
    }

    #sign_up {
      margin-top: 45%;
      margin-left: 60%;
    }

    a {
      color: #b94648;
    }

    input[type="password"] {
      -webkit-text-security: disc; /* 這將將文字改為黑點，隱藏密碼 */
    }

    .return-button {
    width: 50px;
    height: 40px;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    transition: transform 0.3s;
    margin-top: 70px;
    margin-right: -270px;
  
}
    .return-button:active {
    transform: scale(0.95);
  /* 
  可以根據需要調整按鈕點擊時的縮放比例 */
  }
  .register-button:active {
    transform: scale(0.95);
  /* 
  可以根據需要調整按鈕點擊時的縮放比例 */
  }
    
  </style>
  <script>
    // 在页面加载时检查错误参数并显示警告框
    window.onload = function() {
      var error = "<?php echo isset($_GET['error']) ? $_GET['error'] : ''; ?>";
      if (error === "password_mismatch") {
        alert("Password incorrect for the given username. Please try again.");
      }
    };
  </script>
</head>

<body>
  <div id="register_box">
    <h1>Register</h1>
    <form action="create_user.php" method="post" >
      <div id="input_box">
        <input type="text" id="usernameInput" name="username" placeholder="UserName" value="<?php echo isset($_GET['username']) ? htmlspecialchars($_GET['username']) : ''; ?>">
        <input type="password" id="passwordInput" name="userpassword" placeholder="Password">
        <input type="password" id="doublecheckpasswordInput" name="doublecheckpassword" placeholder="VerifyPassword">
        <div id="passwordMismatch" style="display: none; color: red;">Passwords do not match. Please try again.</div>
      </div>
      <button type="submit" class="register-button">Welcome</button><br>
    </form>
    <button class="return-button" id="return-button">Back</button><br>
  </div>

  <script>
      // 找到返回按鈕
    const returnButton = document.getElementById('return-button');

    // 添加點擊事件監聽器
    returnButton.addEventListener('click', function() {
    // 返回到 index.html
      window.location.href = 'index.html';
});



  </script>
  
</body>
</html>