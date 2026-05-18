<?php

namespace App\Http\Controllers\Api\Main;

use App\Http\Controllers\Controller;
use App\Models\Api\Main\Children;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ChildrenController extends Controller
{
    public function index()
    {
        return response()->json(
            Children::with(['gurdian', 'braclet' => ['location','dangers' => ['location'], 'circle.location'], 'baladya.wilaya'])->paginate(20)
        );
    }

    public function store(Request $request)
    {
        
        $validate = $request->validate([
            'name' => 'required|string|max:255',
            'last' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'description' => 'nullable|string|max:1000',
            'baladya_id' => 'required|exists:baladyas,id',
        ]);

        $validate['gurdian_id'] = Auth::user()->key->keyable_id;
        $username = Str::slug($request->input('name') . '.' . $request->input('last')) . rand(10000, 99999);
        $validate['username'] = $username;

        $child = Children::create($validate);
        return response()->json([
            'message' => 'Children created successfully',
            'data' => $child->load(['gurdian', 'braclet' => ['location','dangers' => ['location'], 'circle.location'], 'baladya.wilaya'])
        ]);
    }

    public function show(Children $children)
    {
        return response()->json(
            $children->load(['braclet' => ['location','dangers' => ['location'], 'circle.location'], 'baladya.wilaya'])
        );
    }

    public function update(Request $request, Children $children)
    {
        $validate = $request->validate([
            'name' => 'required|string|max:255',
            'last' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'description' => 'nullable|string|max:1000',
            'baladya_id' => 'required|exists:baladyas,id',
        ]);
        $validate['gurdian_id'] = Auth::user()->key->keyable_id;
        $username = Str::slug($request->input('name') . '.' . $request->input('last')) . rand(10000, 99999);
        $validate['username'] = $username;
        $children->update($validate);
        return response()->json([
            'message' => 'Children updated successfully'
        ]);
    }

    public function destroy(Children $children)
    {
        $children->delete();
        return response()->json([
            'message' => 'Children deleted successfully'
        ]);
    }
}
