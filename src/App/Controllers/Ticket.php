<?php
namespace App\Controllers;
use App\Models\Ticket as TicketModel;
use App\Views\Ticket as View;

class Ticket {
    
    function __construct(){
    }

    function index(){
        $view = new View();
        $view->render();
    }

    function ajaxUpdate($id){
        if( $id != '' ){
            $ticket = new TicketModel();
            $data = $ticket->getTicket($id);

            $view = new View();
            $view->ajaxUpdate($data);
        }
        
    }
}
?>