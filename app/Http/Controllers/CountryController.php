<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use DataTables;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('country.index');
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
        $validator = \Validator::make($request->all(), [
            'description' => "required|unique:country,description,{$request->id}",
            'status' => "required",
        ]);

        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()]);
        }
        $country = Country::updateCreate($request);
        return $country->id;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function show(Country $country)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function edit(Country $country)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Country $country)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function destroy(Country $country)
    {
        //
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getCountry(Request $request)
    {

        $data = Country::select('country.*');
        return Datatables::eloquent($data)
            ->addColumn('action', function ($query) {
                return '<a onclick="updateContent(this)"  href="javascript:void(0)" data-id="'.$query->id.'"
                            data-description="'.$query->description.'" data-status="'.$query->status.'"><span class="fa fa-edit fa-fw" ></span></a>
                        <a  href="javascript:void(0)" data-url = ""
                    onclick="deleteData(this)" class="d-none"><span class="fa fa-trash fa-fw"></span></a>';
            })->editColumn('status', function ($query) {
                $status = ['' => '', '1' => 'Active', '2' => 'In Active'];
                return $status[$query->status];
            })->rawColumns(['action'])->make(true);
    }
}
