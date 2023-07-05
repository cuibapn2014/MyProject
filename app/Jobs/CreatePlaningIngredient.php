<?php

namespace App\Jobs;

use App\Models\PlanIngredient;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class CreatePlaningIngredient implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    private $id_production;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $id_production)
    {
        //
        $this->id_production = $id_production;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        try{
            PlanIngredient::createData($this->id_production);
        }catch(\Exception $ex){
            Log::error('Failed create planing ingredient');
        }
    }
}
