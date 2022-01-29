<?php

namespace App\Http\Controllers;

use App\Models\Vessel;
use App\Models\VesselOpex;
use App\Models\Voyage;
use Illuminate\Http\Request;

class VesselOpexesAPIController extends Controller
{
    public function store(Vessel $vessel)
    {
        request()->validate([
            'date' => ['required', 'date'],
            'expenses' => ['required' ,'numeric'],
        ]);

        $opexes = $vessel->opexes;

        // check if this vessel has another opex with the same day
        foreach ($opexes as $opex){
            if($opex->date == request('date')){
                return [
                    'error' => 'Another opex with the same date already exists for this vessel.'
                ];
                break;
            }
        }
        
        return VesselOpex::create([

            'vessel_id' => $vessel->id,
            'date' => request('date'),
            'expenses' => request('expenses'),
        ]);
    }
}
