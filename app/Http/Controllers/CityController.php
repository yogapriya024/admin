<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Country;
use Illuminate\Http\Request;
use DataTables;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $country = Country::active();
        return view('city.index', compact('country'));
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
            'description' => "required|unique:city,description,{$request->id}",
            'status' => "required",
            'country_id' => "required",
        ]);

        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()]);
        }
        $country = City::updateCreate($request);
        return $country->id;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function show(City $city)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function edit(City $city)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, City $city)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function destroy(City $city)
    {
        //
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getCity(Request $request)
    {

        $data = City::with(['country'])->select('city.*');
        return Datatables::eloquent($data)
            ->addColumn('action', function ($query) {
                return '<a onclick="updateContent(this)"  href="javascript:void(0)" data-id="'.$query->id.'" data-country_id="'.$query->country_id.'"
                            data-description="'.$query->description.'" data-status="'.$query->status.'"><span class="fa fa-edit fa-fw" ></span></a>
                        <a  href="javascript:void(0)" data-url = ""
                    onclick="deleteData(this)" class="d-none"><span class="fa fa-trash fa-fw"></span></a>';
            })->editColumn('status', function ($query) {
                $status = ['' => '', '1' => 'Active', '2' => 'In Active'];
                return $status[$query->status];
            })->rawColumns(['action'])->make(true);
    }
}
