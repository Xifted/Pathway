<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pathway - Login</title>
  <style>
    body {
      margin: 0;
      font-family: sans-serif;
      background: url('gambarlogin.jpg') no-repeat center center;
      background-size: cover;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px; /* agar tidak terlalu nempel di layar kecil */
      box-sizing: border-box;
    }

    .container {
      background-color: #fff;
      width: 100%;
      max-width: 400px;
      padding: 30px;
      border-radius: 20px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
      text-align: center;
    }

    h2 {
      margin: 0 0 10px;
      font-size: 24px;
    }

    p {
      margin: 0 0 20px;
      font-size: 14px;
      color: #666;
    }

    input {
      width: 100%;
      padding: 12px;
      margin-bottom: 15px;
      border-radius: 30px;
      border: 1px solid #ccc;
      font-size: 14px;
      outline: none;
      box-sizing: border-box;
    }

    .btn {
      background-color: #222;
      color: #fff;
      border: none;
      padding: 12px;
      width: 100%;
      border-radius: 30px;
      font-weight: bold;
      font-size: 16px;
      margin-bottom: 10px;
      cursor: pointer;
      transition: background-color 0.3s;
      box-sizing: border-box;
    }

    .btn:hover {
      background-color: #000;
    }

    .small {
      font-size: 12px;
      color: #007bff;
      text-decoration: none;
      display: block;
      margin-bottom: 16px;
    }

    .separator {
      margin: 20px 0;
      font-size: 13px;
      color: #777;
    }

    .social-icons {
      display: flex;
      justify-content: center;
      gap: 15px;
    }

    .social-icons img {
      width: 32px;
      cursor: pointer;
    }

   .social-icons a img:hover {
      transform: scale(1.1);
    }
  </style>
</head>
<body>

  <div class="container">
    <h2>Login ke Pathway</h2>
    <p>Masuk untuk mulai merencanakan karirmu</p>
    <form action="login.php" method="POST">
      <input type="text" name="username" placeholder="Username" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="button" class="btn" onclick="window.location.href='beranda.php'">Login</button>

    </form>
    

    <div class="separator">—Untuk info lebih lanjut —</div>
    <div class="social-icons">
      <a href="https://www.facebook.com/universitas.pembangunan.jaya" target="_blank">
        <img src="logofacebook.png" alt="Login dengan Facebook">
      </a>
      <a href="https://www.instagram.com/carereers_upj/" target="_blank">
        <img src="logo-instagram.png" alt="Login dengan Instagram">
      </a>
    </div>
  </div>

</body>
</html>
