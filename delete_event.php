<?php
include 'header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $eventId = $_POST['event_id'];
    $calendarId = 'primary';
    $service->events->delete($calendarId, $eventId);
    header('Location: index.php');
}
?>
