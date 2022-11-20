<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Setting;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings = Setting::where('id', 1)->get();
        $countries = Country::orderBy('name','asc')->get();
        return view('backend.pages.country.manage', compact('countries', 'settings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $settings = Setting::where('id', 1)->get();
        return view('backend.pages.country.create', compact('settings'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $country = new Country();
        $country->name      = $request->name;
        $country->priority  = $request->priority;
        $country->status    = $request->status;

        $notification = array(
            'alert-type'    => 'success',
            'message'       => 'New Country Added!',
        );

        $country->save();
        return redirect()->route('country.manage')->with($notification);
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
        $country = Country::find($id);
        if(!is_null($country)){
            return view('backend.pages.country.edit', compact('country', 'settings'));
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
        $country = Country::find($id);
        if(!is_null($country)){
            $country->name      = $request->name;
            $country->priority  = $request->priority;
            $country->status    = $request->status;

            $notification = array(
                'alert-type'    => 'success',
                'message'       => 'Country Updated Successfully!',
            );
            $country->save();
            return redirect()->route('country.manage')->with($notification);
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
        $country = Country::find($id);
        if(!is_null($country)){
            $notification = array(
                'alert-type'    => 'error',
                'message'       => 'Country Removed Permanently!',
            );
            $country->delete();
            return redirect()->route('country.manage')->with($notification);
        }else{
            //404
        }
    }
}
