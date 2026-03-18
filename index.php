<?php
$client_ip = $_SERVER['REMOTE_ADDR'];

if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $client_ip = trim(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0]);
}

$api_url = "http://ip-api.com/json/" . $client_ip;
$response = file_get_contents($api_url);
$geo_data = json_decode($response, true);

$log_entry = date('Y-m-d H:i:s') . " | IP: " . $client_ip;

if ($geo_data && $geo_data['status'] === 'success') {
    $log_entry .= " | Country: " . $geo_data['country'] . " | City: " . $geo_data['city'] . " | ISP: " . $geo_data['isp'];
} else {
    $log_entry .= " | Location data unavailable";
}

$log_entry .= "\n";

file_put_contents('visitor_log.txt', $log_entry, FILE_APPEND);
?>
<!DOCTYPE html>
<html>
<head>
<title>SMP Status</title>
</head>
<body>
<h1>Server is currently: ONLINE</h1>
<p>Welcome to the SMP. Make sure to read the rules in the Discord server before joining.</p>
</body>
</html>
