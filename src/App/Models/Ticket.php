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
namespace App\Models;
use Glpi\Api\Rest\Client as Client;
use \Glpi\Api\Rest\ItemHandler as ItemHandler;


class Ticket {
    private $config = "";

    function __construct(){
        $this->config = parse_ini_file('Config/config.ini');
    }

    function getTicket($number){
        $client = new Client($this->config['url_api'], new \GuzzleHttp\Client());

        // Authenticate
        try {
           $client->initSessionByCredentials($this->config['user_api'], $this->config['pass_api']);
        } catch (Exception $e) {
           echo $e->getMessage();
           die();
        }

        // get ticket
        $itemHandler = new ItemHandler($client);
        $response = $itemHandler->getItem('Ticket',
                                          $number, 
                                          array('expand_dropdowns' => True, 
                                                'with_tickets' => True)
                                         );

        $ticket = json_decode($response['body']);
        
        if (isset($ticket->id)){
            // get category name
            $response = $itemHandler->getSubItems('Ticket',
                                                  $ticket->id,
                                                  'Group_Ticket',
                                                  array('expand_dropdowns' => True)
                                                );

            $group = json_decode($response['body']);
            if (isset($group[0]->groups_id)){
                $ticket->group = $group[0]->groups_id;
            }                                            
            // get user name 
            $response = $itemHandler->getSubItems('Ticket',
                                            $ticket->id,
                                            'Ticket_User'//,
                                            //array('expand_dropdowns' => True)
                                            );
            $user = json_decode($response['body']);

            foreach ($user as $value) {

                if( $value->type == 1 ){
                    $response = $itemHandler->getItem('User', $value->users_id);
                    $request = json_decode($response['body']);
                    $ticket->requester = "$request->firstname $request->realname";
                } elseif ( $value->type == 2 ) {
                    $response = $itemHandler->getItem('User', $value->users_id);
                    $assigned = json_decode($response['body']);
                    $ticket->assigned = $assigned->firstname . " " . $assigned->realname;;
                } else {
                    continue;
                }
            }

            // get state name

            switch ($ticket->status) {
                case 1:
                    $ticket->status = "Novo";
                    break;
                case 2:
                    $ticket->status = "Processando(atribuído)";
                    break;
                case 3:
                    $ticket->status = "Processando(planejado)";
                    break;
                case 4:
                    $ticket->status = "Pendente";
                    break;
                case 5:
                    $ticket->status = "Solucionado";
                    break;
                case 6:
                    $ticket->status = "Fechado";
                    break;
                default:
                    # code...
                    break;
            }
            //Item_Ticket Notification
            // get notes
            $response = $itemHandler->getSubItems('Ticket',
                                                  $ticket->id,
                                                  'TicketFollowup',
                                                  array('expand_dropdowns' => True)
                                                  );
            
            $notes = json_decode($response['body']);
            
            $ticket->notes = $notes;
            $ticket->teste = true;
        } else {
            $ticket = new \stdClass;
            $ticket->teste = false;
        }
    
        return $ticket;
    }

    function getState($id){

    }
}

?>