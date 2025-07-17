<?php
require 'db.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "<script>window.location.href='login.php';</script>";
}
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();
$stmt = $pdo->prepare("SELECT * FROM bookings WHERE user_id = ? AND booking_date >= CURDATE() AND status = 'confirmed'");
$stmt->execute([$user_id]);
$bookings = $stmt->fetchAll();
$stmt = $pdo->prepare("SELECT * FROM availability WHERE user_id = ?");
$stmt->execute([$user_id]);
$availability = $stmt->fetchAll();
$notification = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['set_availability'])) {
        $day_of_week = $_POST['day_of_week'];
        $start_time = $_POST['start_time'];
        $end_time = $_POST['end_time'];
        if (strtotime($end_time) <= strtotime($start_time)) {
            $notification = "<div class='notification error'>End time must be after start time.</div>";
        } else {
            $stmt = $pdo->prepare("INSERT INTO availability (user_id, day_of_week, start_time, end_time) VALUES (?, ?, ?, ?)");
            try {
                $stmt->execute([$user_id, $day_of_week, $start_time, $end_time]);
                $notification = "<div class='notification success'>Availability added successfully!</div>";
            } catch (PDOException $e) {
                $notification = "<div class='notification error'>Error: {$e->getMessage()}</div>";
            }
        }
    } elseif (isset($_POST['cancel'])) {
        $booking_id = $_POST['booking_id'];
        $stmt = $pdo->prepare("UPDATE bookings SET status = 'cancelled' WHERE id = ? AND user_id = ?");
        try {
            $stmt->execute([$booking_id, $user_id]);
            $notification = "<div class='notification success'>Booking cancelled successfully!</div>";
            echo "<script>setTimeout(() => window.location.href='dashboard.php', 2000);</script>";
        } catch (PDOException $e) {
            $notification = "<div class='notification error'>Error: {$e->getMessage()}</div>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - SchedulePro</title>
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
            max-width: 1200px;
            margin: 40px auto;
            padding: 20px;
        }
        header {
            background: #007bff;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 10px 10px 0 0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        header h2 {
            margin: 0;
            font-size: 2em;
        }
        .tabs {
            display: flex;
            justify-content: center;
            background: #ffffff;
            padding: 10px;
            border-radius: 5px;
            margin: 20px 0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .tab {
            padding: 12px 25px;
            cursor: pointer;
            background: #e9ecef;
            margin: 0 5px;
            border-radius: 5px;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        .tab:hover, .tab.active {
            background: #007bff;
            color: white;
        }
        .section {
            display: none;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            animation: fadeIn 0.5s ease-in;
        }
        .section.active {
            display: block;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
        }
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #e9ecef;
        }
        th {
            background: #007bff;
            color: white;
            font-weight: 600;
        }
        .btn {
            background: #28a745;
            color: white;
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        .btn:hover {
            background: #218838;
        }
        .btn.cancel {
            background: #dc3545;
        }
        .btn.cancel:hover {
            background: #c82333;
        }
        form {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 20px;
        }
        input, select {
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1em;
            flex: 1;
            min-width: 150px;
        }
        .notification {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            text-align: center;
            font-size: 1em;
        }
        .notification.success {
            background: #d4edda;
            color: #155724;
        }
        .notification.error {
            background: #f8d7da;
            color: #721c24;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform:Surfing translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @media (max-width: 768px) {
            .container {
                margin: 20px;
                padding: 10px;
            }
            form {
                flex-direction: column;
            }
            .tabs {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
</head>
<body>
    <header>
        <h2>Welcome, <?php echo htmlspecialchars($user['username']); ?></h2>
    </header>
    <div class="container">
        <?php echo $notification; ?>
        <button class="btn" onclick="window.location.href='logout.php'">Log Out</button>
        <div class="tabs">
            <div class="tab active" onclick="showSection('bookings')">My Bookings</div>
            <div class="tab" onclick="showSection('availability')">Set Availability</div>
        </div>
        <div id="bookings" class="section active">
            <h3>Upcoming Bookings</h3>
            <table>
                <tr>
                    <th>Visitor</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Action</th>
                </tr>
                <?php foreach ($bookings as $booking): ?>
                <tr>
                    <td><?php echo htmlspecialchars($booking['visitor_name']); ?></td>
                    <td><?php echo htmlspecialchars($booking['booking_date']); ?></td>
                    <td><?php echo htmlspecialchars($booking['start_time']) . ' - ' . htmlspecialchars($booking['end_time']); ?></td>
                    <td>
                        <form method="POST">
                            <input type="hidden" name="booking_id" value="<?php echo $booking['id']; ?>">
                            <button type="submit" name="cancel" class="btn cancel">Cancel</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <div id="availability" class="section">
            <h3>Set Your Availability</h3>
            <form method="POST">
                <select name="day_of_week" required>
                    <option value="">Select Day</option>
                    <option value="Monday">Monday</option>
                    <option value="Tuesday">Tuesday</option>
                    <option value="Wednesday">Wednesday</option>
                    <option value="Thursday">Thursday</option>
                    <option value="Friday">Friday</option>
                    <option value="Saturday">Saturday</option>
                    <option value="Sunday">Sunday</option>
                </select>
                <input type="time" name="start_time" required>
                <input type="time" name="end_time" required>
                <button type="submit" name="set_availability" class="btn">Add Availability</button>
            </form>
            <h4>Your Availability</h4>
            <table>
                <tr>
                    <th>Day</th>
                    <th>Time</th>
                </tr>
                <?php foreach ($availability as $slot): ?>
                <tr>
                    <td><?php echo htmlspecialchars($slot['day_of_week']); ?></td>
                    <td><?php echo htmlspecialchars($slot['start_time']) . ' - ' . htmlspecialchars($slot['end_time']); ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
    <script>
        function showSection(sectionId) {
            document.querySelectorAll('.section').forEach(section => section.classList.remove('active'));
            document.querySelectorAll('.tab').forEach(tab => tab.classList.remove('active'));
            document.getElementById(sectionId).classList.add('active');
            document.querySelector(`[onclick="showSection('${sectionId}')"]`).classList.add('active');
        }
    </script>
</body>
</html>
