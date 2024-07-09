<?php
include 'header.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $start = date('c', strtotime($_POST['start']));
    $end = date('c', strtotime($_POST['end']));
    $timezone = 'Asia/Kathmandu';
    $event = new Google_Service_Calendar_Event(array(
        'summary' => $_POST['summary'],
        'start' => array(
            'dateTime' => $start,
            'timeZone' => $timezone,
        ),
        'end' => array(
            'dateTime' => $end,
            'timeZone' => $timezone,
        ),
    ));
    
    try{
        $event = $service->events->insert($calendarId, $event);
    }catch(Exception $e) {
        header($authUrl);
    }
    header('Location: index.php');
    exit;
}
?>
