<?php
include 'header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $eventId = $_POST['event_id'];
    $calendarId = 'primary';
    try{
        $service->events->delete($calendarId, $eventId);
    }catch(Exception $e) {
        header($authUrl);
    }
    header('Location: index.php');
}
?>
