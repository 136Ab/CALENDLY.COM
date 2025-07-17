<?php
require 'db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];
    $visitor_name = $_POST['visitor_name'];
    $visitor_email = $_POST['visitor_email'];
    $booking_date = $_POST['booking_date'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $stmt = $pdo->prepare("INSERT INTO bookings (user_id, visitor_name, visitor_email, booking_date, start_time, end_time) VALUES (?, ?, ?, ?, ?, ?)");
    try {
        $stmt->execute([$user_id, $visitor_name, $visitor_email, $booking_date, $start_time, $end_time]);
        $message = "Booking confirmed for $visitor_name on $booking_date from $start_time to $end_time.";
        mail($visitor_email, "Booking Confirmation", $message);
        echo "<script>alert('Booking confirmed!'); window.location.href='index.php';</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Error: {$e->getMessage()}'); window.location.href='book.php';</script>";
    }
}
$user_id = $_GET['user_id'] ?? '';
$day = $_GET['day'] ?? '';
$start_time = $_GET['start'] ?? '';
$end_time = $_GET['end'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book a Meeting - SchedulePro</title>
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
        p {
            color: #555;
            margin: 10px 0;
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
        <h2>Book a Meeting</h2>
        <form method="POST">
            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user_id); ?>">
            <input type="text" name="visitor_name" placeholder="Your Name" required>
            <input type="email" name="visitor_email" placeholder="Your Email" required>
            <input type="date" name="booking_date" required>
            <input type="hidden" name="start_time" value="<?php echo htmlspecialchars($start_time); ?>">
            <input type="hidden" name="end_time" value="<?php echo htmlspecialchars($end_time); ?>">
            <p>Selected: <?php echo htmlspecialchars($day . ' ' . $start_time . ' - ' . $end_time); ?></p>
            <button type="submit" class="btn">Confirm Booking</button>
        </form>
    </div>
</body>
</html>
