<?php

namespace App\Jobs;
use Workerman\Worker;
use PHPSocketIO\SocketIO;
class ExampleJob extends Job
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

          $this->sio_message('test', ['test' => 'test']);
    }

    function sio_message($message, $data) {
        $io = new SocketIO(2021);
        $io->on('connection', function ($socket) use ($io) {
            $socket->on('chat message', function ($message) use ($io) {
                $io->emit('chat message', $message);
            });
        });
        
        // Worker::runAll();
    }
    
}
