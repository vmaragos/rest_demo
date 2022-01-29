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
        $vessel = $vessel->name;

        return Voyage::create([

            'vessel_id' => request('vessel_id'),
            'code' => $vessel . '-' . request('start'),
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

    }
}
