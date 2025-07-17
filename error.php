<?php
$error_message = $_GET['message'] ?? 'An unexpected error occurred.';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error - SchedulePro</title>
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
        .error-container {
            max-width: 500px;
            margin: 20px;
            padding: 30px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            text-align: center;
            animation: fadeIn 0.5s ease-in;
        }
        h2 {
            color: #dc3545;
            font-size: 1.8em;
            margin-bottom: 15px;
        }
        p {
            color: #555;
            font-size: 1.1em;
            margin-bottom: 20px;
        }
        .btn {
            background: #007bff;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.1em;
            transition: background 0.3s, transform 0.2s;
        }
        .btn:hover {
            background: #0056b3;
            transform: translateY(-2px);
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @media (max-width: 768px) {
            .error-container {
                margin: 10px;
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="error-container">
        <h2>Error</h2>
        <p><?php echo htmlspecialchars($error_message); ?></p>
        <button class="btn" onclick="window.location.href='index.php'">Return to Home</button>
    </div>
</body>
</html>
