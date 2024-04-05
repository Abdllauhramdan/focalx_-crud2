<?php

namespace App\Http\Controllers;

use App\Http\Requests\CarRequest;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
        $cars=Car::all();
        return response()->json([
            'status' =>'success',
            'car'  => $cars ]);
    }catch (\Throwable $th) {
        Log::error($th);
        return response()->json([
            'status' => 'failed',
            'error' => $th
        ]);
    } ;
            }

    

    /**
     * Store a newly created resource in storage.
     */
    public function store(CarRequest $request)
    {
        try{
            DB::beginTransaction();

            $car = Car::create([
                'name' => $request->name,
                'type' => $request->type,
                'color' => $request->color,
        
            ]);

            DB::commit();
            return response()->json([
                'statuse' => 'Store Success',
                'car' => $car
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th);
            return response()->json([
                'statuse' => 'Store Failed',
                'error' => $th
            ]);
        }
    }



        
    

    /**
     * Display the specified resource.
     */
    public function show(Car $car)
    {
        return response()->json([
        'statuse' => 'Show success',
        'car' => $car
    ]);}

    /**
     * Update the specified resource in storage.
     */
    public function update(CarRequest $request, Car $car)
    {
        try{
            DB::beginTransaction();

            $car->update([
                'name' => $request->name,
                'type' => $request->type,
                'color' => $request->color,
        
            ]);

            DB::commit();
            return response()->json([
                'statuse' => 'Update Success',
                'car' => $car
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th);
            return response()->json([
                'statuse' => 'Update Failed',
                'error' => $th
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Car $car)
    {
     try{
        DB::beginTransaction();

        $car->delete();

        DB::commit();
        return response()->json([
           'status' => 'Delete Success',
            'car' => $car
        ]);
    } catch (\Throwable $th) {
        Log::error($th);
        return response()->json([
            'status' => 'Delete Failed',

        ]);
}
    }
}
