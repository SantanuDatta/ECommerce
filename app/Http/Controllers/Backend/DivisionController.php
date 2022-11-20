<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Division;
use App\Models\Setting;
use Illuminate\Http\Request;

class DivisionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings = Setting::where('id', 1)->get();
        $divisions = Division::orderBy('name','asc')->get();
        return view('backend.pages.division.manage', compact('divisions', 'settings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $settings = Setting::where('id', 1)->get();
        $countries = Country::orderBy('priority', 'asc')->get();
        return view('backend.pages.division.create', compact('countries', 'settings'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $division = new Division();
        $division->name             = $request->name;
        $division->country_id       = $request->country_id;
        $division->priority         = $request->priority;
        $division->status           = $request->status;

        $notification = array(
            'alert-type'    => 'success',
            'message'       => 'New Division Added!',
        );

        $division->save();
        return redirect()->route('division.manage')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $settings = Setting::where('id', 1)->get();
        $division = Division::find($id);
        if(!is_null($division)){
            $countries = Country::orderBy('priority', 'asc')->get();
            return view('backend.pages.division.edit', compact('division', 'countries', 'settings'));
        }else{
            //404
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $division = Division::find($id);
        if(!is_null($division)){
            $division->name             = $request->name;
            $division->country_id       = $request->country_id;
            $division->priority         = $request->priority;
            $division->status           = $request->status;

            $notification = array(
                'alert-type'    => 'success',
                'message'       => 'Division Updated Successfully!',
            );
            $division->save();
            return redirect()->route('division.manage')->with($notification);
        }else{
            //404
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $division = Division::find($id);
        if(!is_null($division)){
            $notification = array(
                'alert-type'    => 'error',
                'message'       => 'Division Removed Permanently!',
            );
            $division->delete();
            return redirect()->route('division.manage')->with($notification);
        }else{
            //404
        }
    }
}
