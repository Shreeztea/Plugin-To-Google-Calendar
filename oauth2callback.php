<?php
require_once 'vendor/autoload.php';
session_start();
$config = include('config.php');

$client = new Google_Client();
$client->setClientId($config['client_id']);
$client->setClientSecret($config['client_secret']);
$client->setRedirectUri($config['redirect_uri']);
$client->addScope(Google_Service_Calendar::CALENDAR);

if (!isset($_GET['code'])) {
    // If there is no code, redirect to the OAuth consent page
    $authUrl = $client->createAuthUrl();
    header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));
    exit;
} else {
    // Exchange the authorization code for an access token
    $client->authenticate($_GET['code']);
    $_SESSION['access_token'] = $client->getAccessToken();
    header('Location: index.php');
}
?>