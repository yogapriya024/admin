<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use DataTables;
use App\Models\Progress;

class ProgressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::select('id', 'name')->get();
        return view('progress.index', compact('users'));
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
            'text' => "required",
            'status' => "required",
            'next_day' => "required",
            'user_id' => "required",
        ]);

        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()]);
        }
        $progress = Progress::updateCreate($request);
        return $progress->id;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getProgress(Request $request)
    {

        $data = Progress::with(['user'])->select('progress.*');
        return Datatables::eloquent($data)
            ->addColumn('action', function ($query) {
                return '<a onclick="updateContent(this)"  href="javascript:void(0)" data-id="'.$query->id.'" data-user_id="'.$query->user_id.'"
                            data-text="'.$query->text.'" data-next_day="'.$query->next_day.'" data-status="'.$query->status.'"><span class="fa fa-edit fa-fw" ></span></a>
                        <a  href="javascript:void(0)" data-url = ""
                    onclick="deleteData(this)" class="d-none"><span class="fa fa-trash fa-fw"></span></a>';
            })->editColumn('status', function ($query) {
                $status = ['' => '', '1' => 'Active', '2' => 'In Active'];
                return $status[$query->status];
            })->rawColumns(['action'])->make(true);
    }
}
