<?php
require 'db.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "<script>window.location.href='login.php';</script>";
}
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM availability WHERE user_id = ?");
$stmt->execute([$user_id]);
$availability = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule a Meeting - SchedulePro</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #e6f0fa, #f4f7fa);
            color: #333;
            scroll-behavior: smooth;
        }
        .container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            animation: fadeIn 0.5s ease-in;
        }
        h2 {
            color: #007bff;
            text-align: center;
            font-size: 2em;
            margin-bottom: 20px;
        }
        .calendar {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 10px;
            margin-top: 20px;
        }
        .day {
            background: #e9ecef;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            transition: transform 0.3s;
        }
        .day:hover {
            transform: translateY(-5px);
        }
        .slot {
            background: #007bff;
            color: white;
            padding: 10px;
            margin: 5px 0;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }
        .slot:hover {
            background: #0056b3;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @media (max-width: 768px) {
            .calendar {
                grid-template-columns: repeat(2, 1fr);
            }
            .container {
                margin: 20px;
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Schedule a Meeting</h2>
        <div class="calendar">
            <?php
            $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
            foreach ($days as $day) {
                echo "<div class='day'><strong>$day</strong>";
                foreach ($availability as $slot) {
                    if ($slot['day_of_week'] == $day) {
                        echo "<div class='slot' onclick=\"window.location.href='book.php?user_id=$user_id&day=$day&start={$slot['start_time']}&end={$slot['end_time']}'\">";
                        echo "{$slot['start_time']} - {$slot['end_time']}</div>";
                    }
                }
                echo "</div>";
            }
            ?>
        </div>
    </div>
</body>
</html>
