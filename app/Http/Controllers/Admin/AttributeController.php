<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attribute;
use App\Models\AttributeValue;
use Validator;
class AttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['attributes'] = Attribute::all();
        return view('admin.attributes.attributes', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|min:1',
            'slug' => 'required|string|max:255|min:1',
        ]);

        if ($validator->fails()) {
            // return redirect()->back()->withErrors($validator)->withInput();
            return response()->json(['error' => $validator->errors()->first(), 'status' => 400]);
        }
        $Color = Attribute::updateOrCreate(['id' => $request->id],['name' => $request->name, 'slug' => $request->slug]);
        // return redirect()->route('admin.Colors');
        return response()->json(['success' => 'Attribute saved successfully', 'status' => 200]);
    }

    public function destroy(string $id)
    {
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|exists:attributes,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first(), 'status' => 400]);
        }
        $Attribute = Attribute::find($id);
        $Attribute->delete();
        return response()->json(['success' => 'Color deleted successfully', 'status' => 200]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index_value()
    {
        $data['attributesValue'] = AttributeValue::with('attribute')->get();
        $data['attributes'] = Attribute::all();
        return view('admin.attributes.value', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store_value(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'attribute_id' => 'required|exists:attributes,id',
            'value' => 'required|string|max:255|min:1',
        ]);

        if ($validator->fails()) {
            // return redirect()->back()->withErrors($validator)->withInput();
            return response()->json(['error' => $validator->errors()->first(), 'status' => 400]);
        }
        $AttributeValue = AttributeValue::updateOrCreate(['id' => $request->id],['attribute_id' => $request->attribute_id, 'value' => $request->value]);
        // return redirect()->route('admin.Colors');
        return response()->json(['success' => 'Attribute Value saved successfully', 'status' => 200]);
    }

    public function destroy_value(string $id)
    {
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|exists:attribute_values,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first(), 'status' => 400]);
        }
        $Color = AttributeValue::find($id);

        // dd($Color);
        $Color->delete();
        return response()->json(['success' => 'Attribute Value deleted successfully', 'status' => 200]);
    }
}
