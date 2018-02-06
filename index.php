<?php
require 'vendor/autoload.php';

$ticket = new App\Controllers\Ticket();

if(isset($_GET['action']) && isset($_GET['id']) && $_GET['action'] === 'search'){
    $ticket->ajaxUpdate($_GET['id']);
} else {
    $ticket->index();
}
?>