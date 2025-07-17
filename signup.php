<?php
require 'db.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    try {
        $stmt->execute([$username, $email, $password]);
        $_SESSION['user_id'] = $pdo->lastInsertId();
        echo "<script>window.location.href='dashboard.php';</script>";
    } catch (PDOException $e) {
        $error = "Error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - SchedulePro</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #e6f0fa, #f4f7fa);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .container {
            max-width: 400px;
            margin: 20px;
            padding: 30px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            animation: fadeIn 0.5s ease-in;
        }
        h2 {
            text-align: center;
            color: #007bff;
            font-size: 1.8em;
            margin-bottom: 20px;
        }
        input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1em;
            transition: border-color 0.3s;
        }
        input:focus {
            border-color: #007bff;
            outline: none;
        }
        .btn {
            background: #007bff;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.1em;
            width: 100%;
            transition: background 0.3s, transform 0.2s;
        }
        .btn:hover {
            background: #0056b3;
            transform: translateY(-2px);
        }
        .error {
            color: #dc3545;
            text-align: center;
            margin-bottom: 15px;
            font-size: 0.9em;
        }
        a {
            color: #007bff;
            text-decoration: none;
            font-size: 0.9em;
        }
        a:hover {
            text-decoration: underline;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @media (max-width: 768px) {
            .container {
                margin: 10px;
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Sign Up</h2>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="POST" onsubmit="return validateForm()">
            <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" id="password" placeholder="Password" required>
            <button type="submit" class="btn">Sign Up</button>
        </form>
        <p>Already have an account? <a href="javascript:void(0)" onclick="window.location.href='login.php'">Log In</a></p>
    </div>
    <script>
        function validateForm() {
            let password = document.getElementById('password').value;
            if (password.length < 8) {
                alert('Password must be at least 8 characters long.');
                return false;
            }
            return true;
        }
    </script>
</body>
</html>
