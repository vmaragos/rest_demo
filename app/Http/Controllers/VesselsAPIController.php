<?php

namespace App\Http\Controllers;

use App\Models\Vessel;
use Carbon\Carbon;
use ErrorException;
use Exception;
use Illuminate\Http\Request;

class VesselsAPIController extends Controller
{
    public function show(Vessel $vessel)
    {
        $voyages = $vessel->voyages;
        
        try{
            $voyage_total_days = null;
            $voyage_total_profits = null;
            foreach ($voyages as $voyage){
                
                $start = Carbon::parse($voyage->start);
                $end = Carbon::parse($voyage->end);
                $voyage_total_days += $start->diffInDays($end);
                $voyage_total_profits += $voyage->profit;
            }
            $voyage_avg_daily_profit = $voyage_total_profits / $voyage_total_days;
            return [
                'daily_profit_avg' => $voyage_avg_daily_profit
            ];
        }
        catch(Exception $e)
        {
            return [
                'error' => 'This vessel has no voyages yet'
            ];
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
