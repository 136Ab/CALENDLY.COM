<?php
session_start();
if (isset($_SESSION['user_id'])) {
    echo "<script>window.location.href='dashboard.php';</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SchedulePro - Easy Meeting Scheduling</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #e6f0fa, #f4f7fa);
            color: #333;
            scroll-behavior: smooth;
        }
        header {
            background: linear-gradient(135deg, #007bff, #00d4ff);
            color: white;
            padding: 30px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        header h1 {
            margin: 0;
            font-size: 2.8em;
            font-weight: 600;
        }
        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 20px;
            text-align: center;
        }
        .hero {
            background: white;
            padding: 50px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            animation: fadeIn 0.5s ease-in;
        }
        .hero h2 {
            font-size: 2.2em;
            color: #007bff;
            margin-bottom: 15px;
        }
        .hero p {
            font-size: 1.2em;
            color: #555;
            margin-bottom: 30px;
        }
        .btn {
            background: #28a745;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.1em;
            text-decoration: none;
            display: inline-block;
            margin: 10px;
            transition: transform 0.2s, background 0.3s;
        }
        .btn:hover {
            background: #218838;
            transform: translateY(-2px);
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @media (max-width: 768px) {
            header h1 {
                font-size: 2em;
            }
            .hero h2 {
                font-size: 1.8em;
            }
            .hero p {
                font-size: 1em;
            }
            .btn {
                padding: 10px 20px;
                font-size: 1em;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>SchedulePro</h1>
    </header>
    <div class="container">
        <div class="hero">
            <h2>Effortless Meeting Scheduling</h2>
            <p>Connect with others seamlessly. Set your availability, share your link, and let them book a time that works for you.</p>
            <button class="btn" onclick="window.location.href='signup.php'">Get Started</button>
            <button class="btn" onclick="window.location.href='login.php'">Log In</button>
            <button class="btn" onclick="window.location.href='book.php'">Book a Meeting</button>
        </div>
    </div>
</body>
</html>
