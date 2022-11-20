<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use File;
use Image;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $settings = Setting::where('id', 1)->get();
        return view('backend.pages.setting.manage', compact('settings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        $setting = Setting::find($id);
        $setting->site_title = $request->site_title;
        $setting->email = $request->email;
        $setting->phone_no = $request->phone_no;
        $setting->support_phone = $request->support_phone;
        $setting->address = $request->address;
        $setting->business_hours = $request->business_hours;
        if($request->logo){
            if(File::exists('backend/img/settings/logo/' . $setting->logo)){
                File::delete('backend/img/settings/logo/' . $setting->logo);
            }
            $logo = $request->file('logo');
            $logoName = $setting->site_title.'-logo';
            $logoImg = $logoName. '-' .rand() . '.' . $logo->getClientOriginalExtension();
            $location = public_path('backend/img/settings/logo/' . $logoImg);
            $imageResize = Image::make($logo);
            $imageResize->fit(215, 66)->save($location);
            $setting->logo = $logoImg;
        }
        if($request->favicon){
            if(File::exists('backend/img/settings/favicon/' . $setting->favicon)){
                File::delete('backend/img/settings/favicon/' . $setting->favicon);
            }
            $favicon = $request->file('favicon');
            $faviconName = $setting->site_title.'-favicon';
            $faviconImg = $faviconName. '-' .rand() . '.' . $favicon->getClientOriginalExtension();
            $location = public_path('backend/img/settings/favicon/' . $faviconImg);
            $imageResize = Image::make($favicon);
            $imageResize->fit(75, 60)->save($location);
            $setting->favicon = $faviconImg;
        }

        $notification = array(
            'alert-type'    => 'success',
            'message'       => 'Settings Have Been Updated!',
        );
        $setting->save();
        return redirect()->back()->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
