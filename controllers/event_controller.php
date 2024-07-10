<?php
require_once '../vendor/autoload.php';
session_start();
class EventController {
    private $service;
    private $calendarId;
    private $authUrl;

    public function __construct() {
        
        if(!isset($_POST['method']))
        {
            $config = include('config.php');
        }else {
            $config = include('../config.php');
        }
        $client = new Google_Client();
        $client->setClientId($config['client_id']);
        $client->setClientSecret($config['client_secret']);
        $client->setRedirectUri($config['redirect_uri']);
        $client->addScope(Google_Service_Calendar::CALENDAR);

        $this->service = new Google_Service_Calendar($client);
        $this->calendarId = 'primary';
        $this->authUrl = 'Location: ' . filter_var($client->createAuthUrl(), FILTER_SANITIZE_URL);
        
        if(isset($_POST['method']) && $_POST['method'] == 'login')
        {
            header($this->authUrl);  
        }else{
            if (!isset($_SESSION['access_token'])) {
                // Redirect to the OAuth consent page if the access token is not available
                header('Location: ../login.php');
                exit;
            } else {
                $client->setAccessToken($_SESSION['access_token']);
            }
        }
        // Handle request upon instantiation
        if(isset($_POST['method']))
         {
        $this->handleRequest();
         }
    }

    private function handleRequest() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $method = $_POST['method'] ?? '';

            switch ($method) {
                case 'listEvents':
                    $this->listEvents();
                    break;
                case 'createEvent':
                    $this->createEvent();
                    break;
                case 'disconnect':
                    $this->disconnect();
                    break;
                case 'deleteEvent':
                    $this->deleteEvent();
                    break;
                default:
                    // Handle invalid or unsupported method
                    break;
            }
        }
    }
    public function listEvents() {
        $optParams = array(
            'maxResults' => 10,
            'orderBy' => 'startTime',
            'singleEvents' => true,
            'timeMin' => date('c'),
        );
    
        try {
            $results = $this->service->events->listEvents($this->calendarId, $optParams);
            return $results->getItems();
        } catch (Exception $e) {
            header($this->authUrl);
            exit;
        }
    }
    
    private function createEvent() {
        $summary = $_POST['summary'];
        $startDateTime = $_POST['start'];
        $endDateTime = $_POST['end'];

        $start = date('c', strtotime($_POST['start']));
        $end = date('c', strtotime($_POST['end']));
        $timezone = 'Asia/Kathmandu';
        $eventData = array(
            'summary' => $_POST['summary'],
            'start' => array(
                'dateTime' => $start,
                'timeZone' => $timezone,
            ),
            'end' => array(
                'dateTime' => $end,
                'timeZone' => $timezone,
            ),
        );
        try {
            // Implement your event creation logic here
            $event = new Google_Service_Calendar_Event($eventData);
            $createdEvent = $this->service->events->insert($this->calendarId, $event);
            header('Location: ../index.php'); // Redirect on success
            exit;
        } catch (Exception $e) {
            echo "Error creating event: " . $e->getMessage();
            header('Location: ../login.php'); 
            exit;
        }
    }
    private function deleteEvent()
    {
        $eventId = $_POST['event_id'];
        try{
            $this->service->events->delete($this->calendarId, $eventId);
        }catch(Exception $e) {
            header($this->authUrl);
        }
        header('Location: ../index.php');
    }
    private function disconnect()
    {
        unset($_SESSION['access_token']);
        header('Location: ../login.php');
    }
}
new EventController();
?>
