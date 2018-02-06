<?php
namespace App\Views;

class Ticket {
    public $twig = "";

    function __construct(){
       
        $loader = new \Twig_Loader_Filesystem(__DIR__.'/templates');
        $this->twig = new \Twig_Environment($loader);
    }

    function render(){
        
        echo $this->twig->render('form.ticket.html');
    }

    function ajaxUpdate($data){
        $body = "";
        $body = array('ticket' => (array) $data);
        $template = $this->twig->load('form.ticket.html');
        
        echo $template->renderBlock('ticket_information', $body);
    }
}
?>