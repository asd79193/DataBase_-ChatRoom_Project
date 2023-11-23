<?php session_start(); 

?>
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

    #login_box {
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
    
  </style>
</head>

<body>
  <div id="login_box">
    <h1>Welcome</h1>
    <form action="Store_username.php" method="post" onsubmit="return redirectToAnotherPage()">
      <div id="input_box">
        <input type="text" id="usernameInput" name="username" placeholder="UserName">
        <input type="password" id="passwordInput" name="userpassword" placeholder="Password">
      </div>
      <button type="submit">Login</button><br>
    </form>
  </div>

  <script>
    window.onload = function() {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const errorMessage = urlParams.get('error_message');
    if (errorMessage === 'password') {
      alert("Password incorrect for the given username. Please try again.");
      // 清除 URL 中的 error_message 參數
      const url = new URL(window.location.href);
      url.searchParams.delete('error_message');
      window.history.replaceState({}, document.title, url);
    }
  };

   function redirectToAnotherPage() {
      const usernameInput = document.getElementById('usernameInput');
      const username = usernameInput.value.trim();
      const userpassword = document.getElementById('passwordInput').value.trim();

      if (username === '' || userpassword === '') {
        alert('Please Enter UserName and UserPassword');
        return false;
      } else {
        return true;
      }
    }
   
  </script>
  
</body>
</html>