<?php

namespace App\Http\Controllers;

use App\Models\Tel;
use Illuminate\Http\Request;

class TelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $req)
    {

        $search = $req->search;
        if ($search != '') {


            return Tel::where('name', 'LIKE', "%$search%")->orWhere('phone', 'LIKE', "%$search%")->get();;
        } else {

           return Tel::orderBy('id', 'DESC')->get();
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $tel = $request->validate([
            'name' => 'required',
            'phone' => 'required',
        ]);
        Tel::create($tel);
        return response("status", 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Tel $tel)
    {
        return $tel;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tel $tel)
    {
        $data = $request->validate([
            'name' => 'required',
            'phone' => 'required',
        ]);
        $tel->update($data);
        return response("status", 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tel $tel)
    {
        $tel->delete();
        return response("status", 204);
    }
}
