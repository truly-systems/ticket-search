<?php
/*
 -------------------------------------------------------------------------
 Ticket-Search  for GLPI
 Copyright (C) 2018 by the Truly Systems Development Team.
 https://github.com/truly-systems/ticket-search
 -------------------------------------------------------------------------
 LICENSE
 This file is part of TelegramBot.
 TelegramBot is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.
 TelegramBot is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.
 You should have received a copy of the GNU General Public License
 along with Ticket-Search. If not, see <http://www.gnu.org/licenses/>.
 --------------------------------------------------------------------------
 */
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