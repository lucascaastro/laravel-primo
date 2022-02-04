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
        $this->user = auth()->$id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $div = $this->num1 / $this->num2;
        if ($this->num2 == 0) {
            $this->user->notify(new DivMade(
                'Erro',
                'Divisão por zero'
            ));
        }

        $this->user->notify(new DivMade(
            'Sucesso',
            'Div = ' . $div
        ));
    }
}