<?php
$client_id = 'YOUR_GOOGLE_CLIENT_ID';
$client_secret = 'YOUR_GOOGLE_CLIENT_SECRET';
$redirect_uri = 'http://localhost/sign-up-sign-in-form/google-callback.php';

if (isset($_GET['code'])) {
    $code = $_GET['code'];
    // Exchange code for access token
    $token_url = 'https://oauth2.googleapis.com/token';
    $data = [
        'code' => $code,
        'client_id' => $client_id,
        'client_secret' => $client_secret,
        'redirect_uri' => $redirect_uri,
        'grant_type' => 'authorization_code'
    ];
    $options = [
        'http' => [
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data),
        ],
    ];
    $context  = stream_context_create($options);
    $result = file_get_contents($token_url, false, $context);
    $response = json_decode($result, true);
    $access_token = $response['access_token'];

    // Get user info
    $info_url = 'https://www.googleapis.com/oauth2/v2/userinfo?access_token=' . $access_token;
    $user_info = json_decode(file_get_contents($info_url), true);

    // Authenticate user in your app (e.g., create session, check if user exists, etc.)
    session_start();
    $_SESSION['user'] = [
        'email' => $user_info['email'],
        'name' => $user_info['name'],
        'picture' => $user_info['picture']
    ];
    header('Location: home.php');
    exit();
} else {
    echo "Google authentication failed.";
}
?>