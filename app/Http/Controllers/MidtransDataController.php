<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMidtransDataRequest;
use App\Http\Requests\UpdateMidtransDataRequest;
use App\Models\MidtransData;

class MidtransDataController extends Controller
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
     * @param  \App\Http\Requests\StoreMidtransDataRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMidtransDataRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MidtransData  $midtransData
     * @return \Illuminate\Http\Response
     */
    public function show(MidtransData $midtransData)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MidtransData  $midtransData
     * @return \Illuminate\Http\Response
     */
    public function edit(MidtransData $midtransData)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMidtransDataRequest  $request
     * @param  \App\Models\MidtransData  $midtransData
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMidtransDataRequest $request, MidtransData $midtransData)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MidtransData  $midtransData
     * @return \Illuminate\Http\Response
     */
    public function destroy(MidtransData $midtransData)
    {
        //
    }
}
