<?php

namespace App\Http\Controllers;
use App\Models\StoreOpeningHours;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StoreOpeningHoursController extends Controller
{
 
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // form validation
        $validator = Validator::make($request->all(), [
            'day_of_week' => 'required|in:MONDAY,TUESDAY,WEDNESDAY,THURSDAY,FRIDAY,SATURDAY,SUNDAY',
            'opening_time' => 'required|date_format:H:i',
            'closing_time' => 'required|date_format:H:i',
        ]);

        // if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // opening_time cannot be greater than closing_time
        if($request->input('opening_time') > $request->input('closing_time')){
            return redirect()->back()->with('error', 'Horário inícial não pode ser maior que horário final');
        }
        
        // create store opening hour
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