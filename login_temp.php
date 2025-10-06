<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        body {
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', sans-serif;
            background: #111;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='40' height='40' viewBox='0 0 40 40'%3E%3Cg fill='none' stroke='%23333' stroke-width='1'%3E%3Cpath d='M20 0v40M0 20h40'/%3E%3C/g%3E%3C/svg%3E");
            /* 👆 Simple doodle grid pattern */
            background-size: 40px 40px;
            color: #fff;
        }

        .login-container {
            background: rgba(20, 20, 20, 0.9);
            padding: 40px;
            border-radius: 20px;
            animation: glow 2s infinite alternate;
            width: 350px;
            text-align: center;
            backdrop-filter: blur(6px); /* makes doodle look soft behind */
        }

        @keyframes glow {
            0%   { box-shadow: 0 0 8px #ffffff; }
            50%  { box-shadow: 0 0 16px #cccccc; }
            100% { box-shadow: 0 0 8px #ffffff; }
        }

        .login-container h2 {
            margin-bottom: 25px;
            color: #ffffff;
            font-size: 28px;
            letter-spacing: 2px;
        }

        .login-container input[type="text"],
        .login-container input[type="password"],
        .login-container button {
            width: 100%;
            height: 45px;
            padding: 0 12px;
            margin: 10px 0;
            border: none;
            border-radius: 10px;
            box-sizing: border-box;
            font-size: 16px;
        }

        .login-container input[type="text"],
        .login-container input[type="password"] {
            background: #2e2e2e;
            color: #fff;
        }

        .login-container input:focus {
            outline: none;
            box-shadow: 0 0 8px #ffffff;
        }

        .login-container button {
            background: linear-gradient(135deg, #ffffff, #cccccc);
            color: #000;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s ease;
            letter-spacing: 1px;
        }

        .login-container button:hover {
            background: linear-gradient(135deg, #cccccc, #ffffff);
            transform: scale(1.03);
        }

        .login-container a {
            display: block;
            margin-top: 20px;
            color: #aaa;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s;
        }

        .login-container a:hover {
            color: #ffffff;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>LOGIN</h2>
        <form action="proses.php" method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Masuk</button>
        </form>
        <a href="#">Daftar</a>
    </div>
</body>
</html>
