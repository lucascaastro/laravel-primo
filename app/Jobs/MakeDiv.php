<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use App\Notifications\DivMade;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class MakeDiv implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $num1;
    public $num2;
    public $id;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($num1, $num2, $id)
    {
        $this->num1 = $num1;
        $this->num2 = $num2;
        $this->id = $id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = User::find($this->id);

        if ($this->num2 === 0) {
            $user->notify(new DivMade(
                'Erro',
                'Divisão por zero'
            ));
            return;
        }
        $div = $this->num1 / $this->num2;
        $user->notify(new DivMade(
            'Sucesso',
            'Div = ' . $div
        ));
    }
}