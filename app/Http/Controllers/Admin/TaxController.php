<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tax;
use Validator;
class TaxController extends Controller
{
    public function index()
    {
        $data = Tax::all();
        return view('admin.tax.tax', get_defined_vars());
    }

    public function store(request $request) 
    {
        $validator = Validator::make($request->all(), [
            'tax' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first(), 'status' => 400]);
        }
        Tax::updateOrCreate(['id' => $request->id],['tax' => $request->tax]);
        return response()->json(['success' => 'Tax saved successfully', 'status' => 200]);
    }

    public function destroy($id)
    {
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|exists:taxes,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first(), 'status' => 400]);
        }
        Tax::find($id)->delete();
        return response()->json(['success' => 'Tax deleted successfully', 'status' => 200]);
    }
}
