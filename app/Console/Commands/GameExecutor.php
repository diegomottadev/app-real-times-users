<?php

namespace App\Console\Commands;

use App\Events\RemainTimeChange;
use App\Events\WinnerNumberGeneral;
use Illuminate\Console\Command;

class GameExecutor extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'game:execute';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start executing the game';

    /**
     * Create a new command instance.
     *
     * @return void
     */

    public $time = 15;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        while(true){
            broadcast(new RemainTimeChange($this->time . ' s'));

            $this->time--;

            sleep(1);

            if($this->time === 0) {
                $this->time = 'Waiting to start';
                broadcast(new RemainTimeChange($this->time));
                broadcast(new WinnerNumberGeneral(mt_rand(1,12)));
                sleep(5);
                $this->time = 15;
            }

        }
    }
}
