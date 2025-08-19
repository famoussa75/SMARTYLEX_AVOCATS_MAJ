<?php

namespace App\Http\Controllers;

use App\Models\CourierDepart;
use App\Models\CourierFiles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class CourierFilesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    /**
     * Afficher the form for creating a new resource.
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CourierFiles  $courierFiles
     * @return \Illuminate\Http\Response
     */
    public function show(CourierFiles $courierFiles)
    {
        //
    }

    /**
     * Afficher the form for editing the specified resource.
     *
     * @param  \App\Models\CourierFiles  $courierFiles
     * @return \Illuminate\Http\Response
     */
    public function edit(CourierFiles $courierFiles)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CourierFiles  $courierFiles
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CourierFiles $courierFiles)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CourierFiles  $courierFiles
     * @return \Illuminate\Http\Response
     */
    public function destroy(CourierFiles $courierFiles)
    {
        //
    }
}
