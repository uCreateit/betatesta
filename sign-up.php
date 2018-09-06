<?php

/*
  curl --request POST \
  --url 'https://usX.api.mailchimp.com/3.0/lists/57afe96172/members' \
  --user 'anystring:apikey' \
  --header 'content-type: application/json' \
  --data '{"email_address":"urist.mcvankab+3@freddiesjokes.com", "status":"subscribed"}' \
  --include
 */

/*
  curl --request POST \
  --url 'https://us18.api.mailchimp.com/3.0/lists/083828f4c7/members' \
  --user 'anystring:3989592313899d151cf558c111964b83-us18' \
  --header 'content-type: application/json' \
  --data '{"email_address":"jagdeepsingh+betatesta_local_test_7@ucreate.co.in", "status":"subscribed"}' \
  --include
 */

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
