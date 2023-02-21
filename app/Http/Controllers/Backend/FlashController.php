<?php

namespace App\Http\Controllers\Backend;

use App\Models\Flash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FlashController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $flashes = Flash::orderBy('id', 'desc')->get();
        return view('backend.pages.flash.manage', compact('flashes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.pages.flash.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $flash = new Flash();
        $flash->name    = $request->name;
        $flash->status  = $request->status;

        $notification = array(
            'alert-type'    => 'success',
            'message'       => 'Flash Message Has Been Added!',
        );

        $flash->save();
        return redirect()->route('flash.manage')->with($notification);
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
        $flash = Flash::find($id);
        if (!is_null($flash)) {
            return view('backend.pages.flash.edit', compact('flash'));
        } else {
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
        $flash = Flash::find($id);
        $flash->name    = $request->name;
        $flash->status  = $request->status;

        $notification = array(
            'alert-type'    => 'success',
            'message'       => 'Flash Message Has Been Updated!',
        );

        $flash->save();
        return redirect()->route('flash.manage')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $flash = Flash::find($id);
        $notification = array(
            'alert-type'    => 'error',
            'message'       => 'Flash Message Has Been Deleted Permanently!',
        );

        $flash->delete();
        return redirect()->route('flash.manage')->with($notification);
    }
}
