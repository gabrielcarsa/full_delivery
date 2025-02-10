<?php

namespace App\Http\Controllers;
use App\Models\StoreOpeningHours;
use Illuminate\Http\Request;

class StoreOpeningHoursController extends Controller
{
 
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if($request->input('opening_time') > $request->input('closing_time')){
            return redirect()->back()->with('error', 'Horário inícial não pode ser maior que horário final');
        }
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