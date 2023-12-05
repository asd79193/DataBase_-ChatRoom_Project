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
    
  </style>
</head>

<body>
  <div id="register_box">
    <h1>Register</h1>
      <div id="input_box">
        <input type="text" id="usernameInput" name="username" placeholder="UserName">
        <input type="password" id="passwordInput" name="userpassword" placeholder="Password">
        <input type="password" id="doublecheckpasswordInput" name="doublecheckpassword" placeholder="VerifyPassword">
      </div>
      <button type="submit">Welcome</button><br>
    </form>
  </div>
  
</body>
</html>