<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once 'vendor/autoload.php';
session_start();

$config = include('config.php');

$client = new Google_Client();
$client->setClientId($config['client_id']);
$client->setClientSecret($config['client_secret']);
$client->setRedirectUri($config['redirect_uri']);
$client->addScope(Google_Service_Calendar::CALENDAR);

$calendarId = 'primary';
$authUrl = 'Location: ' . filter_var($client->createAuthUrl(), FILTER_SANITIZE_URL);
if (!isset($_SESSION['access_token'])) {
    // Redirect to the OAuth consent page if the access token is not available
    header($authUrl);
    exit;
} else {
    $client->setAccessToken($_SESSION['access_token']);
}
$service = new Google_Service_Calendar($client);
