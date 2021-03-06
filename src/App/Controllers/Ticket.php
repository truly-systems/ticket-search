<?php
/*
 -------------------------------------------------------------------------
 Ticket-Search  for GLPI
 Copyright (C) 2018 by the Truly Systems Development Team.
 https://github.com/truly-systems/ticket-search
 -------------------------------------------------------------------------
 LICENSE
 This file is part of Ticket-Search.
 Ticket-Search is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.
 Ticket-Search is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.
 You should have received a copy of the GNU General Public License
 along with Ticket-Search. If not, see <http://www.gnu.org/licenses/>.
 --------------------------------------------------------------------------
 */
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