<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Division;
use App\Models\District;
use App\Models\Setting;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings = Setting::where('id', 1)->get();
        $districts = District::orderBy('name','asc')->get();
        return view('backend.pages.district.manage', compact('districts', 'settings'));
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
        $divisions = Division::orderBy('priority', 'asc')->get();
        return view('backend.pages.district.create', compact('countries', 'divisions', 'settings'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $district = new District();
        $district->name             = $request->name;
        $district->division_id      = $request->division_id;
        $district->country_id       = $request->country_id;
        $district->status           = $request->status;

        $notification = array(
            'alert-type'    => 'success',
            'message'       => 'New District Added!',
        );

        $district->save();
        return redirect()->route('district.manage')->with($notification);
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
        $district = District::find($id);
        if(!is_null($district)){
            $countries = Country::orderBy('priority', 'asc')->get();
            $divisions = Division::orderBy('priority', 'asc')->get();
            return view('backend.pages.district.edit', compact('district', 'divisions', 'countries', 'settings'));
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
        $district = District::find($id);
        if(!is_null($district)){
            $district->name             = $request->name;
            $district->division_id      = $request->division_id;
            $district->country_id       = $request->country_id;
            $district->status           = $request->status;
    
            $notification = array(
                'alert-type'    => 'success',
                'message'       => 'District Updated Successfully!',
            );
            $district->save();
            return redirect()->route('district.manage')->with($notification);
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
        $district = District::find($id);
        if(!is_null($district)){
            $notification = array(
                'alert-type'    => 'error',
                'message'       => 'District Removed Permanently!',
            );
            $district->delete();
            return redirect()->route('district.manage')->with($notification);
        }else{
            //404
        }
    }
}
