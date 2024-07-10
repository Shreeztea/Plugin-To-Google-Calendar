<?php
require_once 'controllers/event_controller.php';

// Instantiate EventController
$controller = new EventController();

// Get the list of events
$events = $controller->listEvents();

?>
<h3 class="text-center">Google Calendar Events</h3>
<?php if (empty($events)): ?>
    <p>No upcoming events found.</p>
<?php else: ?>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">From Date</th>
                <th scope="col">To Date</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($events as $index => $event): ?>
                <tr>
                    <th scope="row"><?php echo $index + 1; ?></th>
                    <td><?php echo $event->getSummary(); ?></td>
                    <td>
                        <?php
                        if ($event->getStart()->getDateTime()) {
                            $startDateTime = new DateTime($event->getStart()->getDateTime());
                            echo $startDateTime->format('l, F j, Y \a\t g:i A');
                        } else if ($event->getStart()->getDate()) {
                            $startDateTime = new DateTime($event->getStart()->getDate());
                            echo $startDateTime->format('l, F j, Y');
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        if ($event->getEnd()->getDateTime()) {
                            $endDateTime = new DateTime($event->getEnd()->getDateTime());
                            echo $endDateTime->format('l, F j, Y \a\t g:i A');
                        } else if ($event->getEnd()->getDate()) {
                            $endDateTime = new DateTime($event->getEnd()->getDate());
                            echo $endDateTime->format('l, F j, Y');
                        }
                        ?>
                    </td>
                    <td>
                        <form action="controllers/event_controller.php" method="post">
                            <input type="hidden" name="method" value="deleteEvent">
                            <input type="hidden" name="event_id" value="<?php echo $event->getId(); ?>">
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
