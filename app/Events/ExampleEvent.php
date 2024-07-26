<?php

namespace App\Events;


use Workerman\Worker;
use PHPSocketIO\SocketIO;

class ExampleEvent extends Event
{
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        // $result = socket_connect($socket, '127.0.0.1', 3000);
        // if(!$result) {
        //     die('cannot connect '.socket_strerror(socket_last_error()).PHP_EOL);
        // }
        // $bytes = socket_write($socket, json_encode(Array("msg" =>"chat message", "data" => "test")));
        // sleep(2);   
        // socket_close($socket);
        // dd($socket);
        \Log::info('Event fired');
        
    }



  
}
