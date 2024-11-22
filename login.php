<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Bebas Tanggungan</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-image: url('image/BGPBL.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .logo {
            width: 100px;
            height: 100px;
            margin-bottom: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .logo img {
            width: 100%;
            height: auto;
            max-width: 100px;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.55);
            backdrop-filter: blur(10px);
            padding: 30px;
            border-radius: 10px;
            width: 100%;
            max-width: 400px;
            text-align: center;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            position: relative;
        }

        h2 {
            color: #333;
            margin-bottom: 10px;
        }

        p {
            color: #666;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .input-group {
            position: relative;
            margin-bottom: 15px;
        }

        .input-group input {
            width: 100%;
            padding: 12px 40px;
            border: 1px solid #AEF359;
            border-radius: 5px;
            background: rgba(95, 199, 38, 0.1);
            color: #333;
            outline: none;
        }

        .input-group input:focus {
            border-color: #AEF359;
            box-shadow: 0 0 5px rgba(95, 199, 38, 0.5);
        }

        .input-group i {
            position: absolute;
            top: 50%;
            left: 10px;
            transform: translateY(-50%);
            color: #AEF359;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #AEF359;
            border: none;
            border-radius: 5px;
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        button:hover {
            background: #4da31f;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        button:active {
            transform: translateY(0);
            box-shadow: none;
        }

        .forgot-password {
            position: absolute;
            left: 0;
            right: 0;
            bottom: -40px;
            text-align: center;
            font-size: 14px;
        }

        .forgot-password a {
            color: #333;
            text-decoration: none;
            transition: color 0.3s;
        }

        .forgot-password a:hover {
            color: #5fc726;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="logo">
        <img src="image/logoPolinema.png">
    </div>
    <div class="login-container">
        <h2>Welcome Back!</h2>
        <p>Enter to access your account</p>
        <form>
            <div class="input-group">
                <i class="fas fa-envelope"></i>
                <input type="text" placeholder="Enter your code" required>
            </div>
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" placeholder="Enter your password" required>
            </div>
            <button type="submit">Sign In</button>
        </form>
        <div class="forgot-password">
            Forgot your password? <a href="#">Reset Password</a>
        </div>
    </div>
</body>
</html>