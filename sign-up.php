<?php


ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

require_once 'vendor/autoload.php';
$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

define('MC_API_KEY', getenv('MC_API_KEY'));
define('MC_API_NUMBER', 18);
define('MC_LIST_ID_NEWSLETTER', getenv('MC_LIST_ID_NEWSLETTER'));
define('MC_LIST_ID_TESTERS', getenv('MC_LIST_ID_TESTERS'));
define('MC_LIST_ID_MAKERS', getenv('MC_LIST_ID_MAKERS'));

$list_id = MC_LIST_ID_NEWSLETTER;
switch ($_POST['register-option']) {
    case 1:
        $list_id = MC_LIST_ID_TESTERS;
        break;
    case 2:
        $list_id = MC_LIST_ID_MAKERS;
        break;
    case 3:
        $list_id = MC_LIST_ID_NEWSLETTER;
        break;
}
$url = "https://us" . MC_API_NUMBER . ".api.mailchimp.com/3.0/lists/$list_id/members";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_HTTPHEADER, array
    (
    'Content-Type: application/json',
));
curl_setopt($ch, CURLOPT_USERPWD, "anystring:" . MC_API_KEY);
curl_setopt($ch, CURLOPT_TIMEOUT, 5);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$data = [
    'email_address' => $_POST['email'],
    'status' => 'subscribed'
];
if ($data)
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

$response = curl_exec($ch);

if (curl_error($ch)) {
    print_r($response);
    exit();
}
curl_close($ch);

//print_r($response);
header("Location:index.php");
