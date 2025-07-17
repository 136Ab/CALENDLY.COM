<?php
session_start();
require 'db.php';
if (isset($_SESSION['user_id'])) {
    echo "<script>window.location.href='dashboard.php';</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SchedulePro - Seamless Scheduling</title>
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
            max-width: 1000px;
            margin: 40px auto;
            padding: 20px;
            text-align: center;
        }
        .welcome {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            animation: fadeIn 0.5s ease-in;
        }
        .welcome h2 {
            color: #007bff;
            font-size: 2em;
            margin-bottom: 15px;
        }
        .welcome p {
            font-size: 1.2em;
            color: #555;
            margin-bottom: 20px;
        }
        .btn {
            background: #28a745;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.1em;
            margin: 10px;
            transition: transform 0.2s, background 0.3s;
        }
        .btn:hover {
            background: #218838;
            transform: translateY(-2px);
        }
        .features {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-top: 20px;
        }
        .feature {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }
        .feature:hover {
            transform: translateY(-5px);
        }
        .feature h3 {
            color: #007bff;
            margin-bottom: 10px;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @media (max-width: 768px) {
            header h1 {
                font-size: 2em;
            }
            .welcome h2 {
                font-size: 1.5em;
            }
            .welcome p {
                font-size: 1em;
            }
            .features {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>SchedulePro</h1>
    </header>
    <div class="container">
        <div class="welcome">
            <h2>Plan Meetings with Ease</h2>
            <p>SchedulePro makes it simple to connect with others. Set your availability, share your link, and let your clients or friends book a time that works for you.</p>
            <button class="btn" onclick="window.location.href='signup.php'">Sign Up Now</button>
            <button class="btn" onclick="window.location.href='login.php'">Log In</button>
            <button class="btn" onclick="window.location.href='book.php'">Book a Meeting</button>
        </div>
        <div class="features">
            <div class="feature">
                <h3>Easy Scheduling</h3>
                <p>Choose your available times and let others pick a slot that suits them.</p>
            </div>
            <div class="feature">
                <h3>Manage Bookings</h3>
                <p>View, reschedule, or cancel appointments from your personalized dashboard.</p>
            </div>
            <div class="feature">
                <h3>Responsive Design</h3>
                <p>Access SchedulePro seamlessly on any device, desktop or mobile.</p>
            </div>
        </div>
    </div>
</body>
</html>
