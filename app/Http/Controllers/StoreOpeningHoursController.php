<?php

namespace App\Http\Controllers;
use App\Models\StoreOpeningHours;
use Illuminate\Http\Request;

class StoreOpeningHoursController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        StoreOpeningHours::create([
            'day_of_week' => $request->input('day_of_week'),
            'opening_time' => $request->input('opening_time'),
            'closing_time' => $request->input('closing_time'),
            'store_id' => $request->input('store_id'),
        ]);

        return redirect()->back()->with('success', 'Horário cadastrado com sucesso');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $store = StoreOpeningHours::find($id);
        
        if ($store) {
            $store->delete();
            return response()->json(['success' => true]); // ✅ Retorna JSON válido
        }
    
        return response()->json(['success' => false, 'message' => 'Registro não encontrado'], 404);

    }
}
