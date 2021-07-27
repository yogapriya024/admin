<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use DataTables;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('tag.index');
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
            'description' => "required|unique:tags,description,{$request->id}",
            'status' => "required",
        ]);

        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()]);
        }
        $tag = Tag::updateCreate($request);
        return $tag->id;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $tag)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tag $tag)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        //
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getTag(Request $request)
    {

        $data = Tag::select('tags.*');
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
