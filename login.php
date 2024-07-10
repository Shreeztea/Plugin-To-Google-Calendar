<?php
    require_once 'vendor/autoload.php';
    $config = include('config.php');

    $client = new Google_Client();
    $client->setClientId($config['client_id']);
    $client->setClientSecret($config['client_secret']);
    $client->setRedirectUri($config['redirect_uri']);
    $client->addScope(Google_Service_Calendar::CALENDAR);
    
    $calendarId = 'primary';
    $authUrl = 'Location: ' . filter_var($client->createAuthUrl(), FILTER_SANITIZE_URL);
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if(isset($_POST['login']) && $_POST['login'] === 'google') {
            header($authUrl);
        }
    }
?>
<html>
<head>
    <title>Google Calendar PHP App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .center-page {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>
    <body>

    <div class="container center-page">
        <form action="login.php" method="POST">
            <input type="hidden" name="login" value="google"/>
            <button class="btn btn-success btn-lg" type="submit">Login With Google</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    </body>
</html>