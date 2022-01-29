<?php

namespace App\Http\Controllers;

use App\Models\Vessel;
use Illuminate\Http\Request;

class VesselsAPIController extends Controller
{
    public function store(Vessel $vessel)
    {
        request()->validate([
            'date' => ['required', 'date'],
            'expenses' => ['required' ,'numeric'],
        ]);

        













        $vessel = Vessel::findOrFail(request('vessel_id'));
        $vessel_name = $vessel->name;
        $voyage_code = $vessel_name . '-' . request('start');

        foreach ($vessel->voyages as $voyage){
            if($voyage->code == $voyage_code){
                return [
                    'error' => 'A voyage with the same vessel and start date already exist.'
                ];
                break;
            }
        }

        return Voyage::create([

            'vessel_id' => request('vessel_id'),
            'code' => $voyage_code,
            'start' => request('start'),
            'end' => request('end'),
            // 'status' => 'pending',
            'revenues' => request('revenues'),
            'expenses' => request('expenses'),
            'profit' => request('revenues') - request('expenses'),
        ]);
    }
}
