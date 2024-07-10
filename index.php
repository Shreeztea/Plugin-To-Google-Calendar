<!DOCTYPE html>
<html>

<head>
    <title>Google Calendar PHP App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container-lg p-3">
        <div>
            <form action="controllers/event_controller.php" method="post">
                <input type="hidden" name="method" value="disconnect">
                <button class="btn btn-danger float-end">Disconnect</button>
            </form>
        </div>
        <div class="row p-2 m-1">
            <div class="col border border-dark-subtle m-2 p-2">
                <?php include_once('event_list.php'); ?>

            </div>
            <div class="col-3 border border-white m-2 p-2">

                <div>
                    <h3 class="text-center">Create Event</h3>
                    <form action="controllers/event_controller.php" method="post">
                        <input type="hidden" name="method" value="createEvent">
                        <div class="mb-3">
                            <label for="summary" class="form-label">Title</label>
                            <input type="text" class="form-control" id="summary" name="summary" required>
                        </div>
                        <div class="mb-3">
                            <label for="start" class="form-label">Start Date & Time</label>
                            <input type="datetime-local" class="form-control" id="start" name="start" required>
                        </div>
                        <div class="mb-3">
                            <label for="end" class="form-label">End Date & Time</label>
                            <input type="datetime-local" class="form-control" id="end" name="end" required>
                        </div>
                        <button type="submit" class="btn btn-success">Create Event</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>