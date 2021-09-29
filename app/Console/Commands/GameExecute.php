<?php

namespace App\Console\Commands;

use App\Events\RemainingTimechange;
use App\Events\WinnerNumberGenerate;
use Illuminate\Console\Command;

class GameExecute extends Command
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

   private $time = 5;

   /**
    * Create a new command instance.
    *
    * @return void
    */
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
      while (true) {
         broadcast(new RemainingTimechange($this->time . 's'));

         $this->time--;
         sleep(1);

         if ($this->time === 0) {
            $this->time = 'Waiting to start';

            broadcast(new RemainingTimechange($this->time));
            broadcast(new WinnerNumberGenerate(mt_rand(1, 5)));
            sleep(5);
            $this->time = 5;
         }
      }
   }
}
