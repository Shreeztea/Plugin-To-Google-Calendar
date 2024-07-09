<?php
include "header.php";
// List events
$calendarId = 'primary';
$optParams = array(
  'maxResults' => 10,
  'orderBy' => 'startTime',
  'singleEvents' => true,
  'timeMin' => date('c'),
);

try {
    $results = $service->events->listEvents($calendarId, $optParams);
    $events = $results->getItems();
}catch(Exception $e){
    header($authUrl);
    exit;
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Google Calendar PHP App</title>
</head>
<body>
<h1>Google Calendar Events</h1>
<?php if (empty($events)): ?>
    <p>No upcoming events found.</p>
<?php else: ?>
    <ul>
        <?php foreach ($events as $event): ?>
            <li><?php echo $event->getSummary(); ?> (
                <?php 
                    $startDateTime = new DateTime($event->getStart()->getDateTime());
                    echo $startDateTime->format('l, F j, Y \a\t g:i A');
                ?>
            )
            <form action="delete_event.php" method="post" style="display: inline;">
                    <input type="hidden" name="event_id" value="<?php echo $event->getId(); ?>">
                    <button type="submit">Delete</button>
                </form>
        </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<h2>Create Event</h2>
<form action="create_event.php" method="post">
    <label for="summary">Summary:</label>
    <input type="text" id="summary" name="summary" required>
    <label for="start">Start Date & Time:</label>
    <input type="datetime-local" id="start" name="start" required>
    <label for="end">End Date & Time:</label>
    <input type="datetime-local" id="end" name="end" required>
    <button type="submit">Create Event</button>
</form>

<a href="disconnect.php">Disconnect</a>
</body>
</html>
