<?php

namespace App\Http\Controllers;

use App\Models\Vessel;
use App\Models\Voyage;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class VoyagesAPIController extends Controller
{
    public function store()
    {
        request()->validate([
            'vessel_id' => ['required'],
            // 'code' => ['string', 'unique:voyages,code'],
            'start' => ['required', 'date'],
            'end' => ['date', 'after:start'],
            // 'status' => [
            //     'required', 
            //     'string',
            //     Rule::in(['pending', 'ongoing', 'submitted'])
            // ],
            'revenues' => ['numeric'],
            'expenses' => ['numeric'],
        ]);

        $vessel = Vessel::findOrFail(request('vessel_id'));
        $vessel_name = $vessel->name;

        return Voyage::create([

            'vessel_id' => request('vessel_id'),
            'code' => $vessel_name . '-' . request('start'),
            'start' => request('start'),
            'end' => request('end'),
            // 'status' => 'pending',
            'revenues' => request('revenues'),
            'expenses' => request('expenses'),
            'profit' => request('revenues') - request('expenses'),
        ]);
    }

    public function update(Voyage $voyage)
    {

        request()->validate([
            'start' => ['required', 'date'],
            'end' => ['date', 'after:start'],
            'status' => [
                'required', 
                'string',
                Rule::in(['pending', 'ongoing', 'submitted'])
            ],
            'revenues' => ['numeric'],
            'expenses' => ['numeric'],
        ]);
        
        if ($voyage->status == 'submitted'){
            return [
                'error' => 'This voyage has been submitted and can no longer be updated.'
            ];
        }
        
        $vessel = $voyage->vessel;
        $voyages = $vessel->voyages;
        
        if (request('status') == 'ongoing'){
            foreach ($voyages as $voyage)
            {
                if ($voyage->status == 'ongoing')
                {
                    return [
                        'error' => 'This vessel is already on an ongoing voyage.'
                    ];
                    break;
                }
            }
        }
        
        $vessel_name = $vessel->name;

        // ddd($vessel_name);
        
        $voyage->update([
            'start'  => request('start'),
            'end'  => request('end'),
            'code' => $vessel_name . '-' . request('start'), // start & end change, so the code should change too
            'status' => request('status'),
            'revenues' => request('revenues'),
            'expenses' => request('expenses'),
            'profit' => request('revenues') - request('expenses'),
        ]);
    }
}
