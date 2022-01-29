<?php

namespace App\Http\Controllers;

use App\Models\Vessel;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VesselsAPIController extends Controller
{
    public function show(Vessel $vessel)
    {
        $voyages = $vessel->voyages;
        foreach ($voyages as $voyage){
            $start = $voyage->created_at;
            $end = $voyage->updated_at;
            ddd($start, $end);
            $voyage_duration = $end->diffInDays(Carbon::parse($start));
            ddd($voyage_duration);
            $daily_average = $voyage->profit / $voyage_duration;
        }
    }

    public function store()
    {
        // ddd(request()->all());
        request()->validate([
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'imo_number' => ['required', 'unique:vessels', 'min:7', 'max:7'],
        ]);


        return Vessel::create([
            'name' => request('name'),
            'imo_number' => request('imo_number'),
        ]);
    }

    public function index()
    {
        return Vessel::all();
    }
}
