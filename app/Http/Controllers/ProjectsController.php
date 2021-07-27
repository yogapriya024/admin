<?php

namespace App\Http\Controllers;

use App\Models\LeadCommunication;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DataTables;

class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('projects.index');
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
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'description' => 'required'
        ]);

        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()]);
        }
        $project = Project::find($request->id);
        $project->description = $request->description;
        $project->save();
        return $project->id;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        //
    }

    public function convert($id)
    {
        $id = decrypt($id);
        $communication = LeadCommunication::where('id', $id)->where('status', 3)->first();
        if($communication){
            $data = [
                'lead_id' => $communication->lead_id,
                'partner_id' => $communication->partner_id,
                'status' => 1
            ];
            Project::create($data);
            $communication->lead->status = 3;
            $communication->lead->date = Carbon::parse($communication->lead->date)->addMonths(1)->format('Y-m-d');
            $communication->lead->save();
            $communication->status = 4;
            $communication->save();
            return redirect(route('projects'))->with('success', 'Project created successfully');
        }
        abort(404);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getProjects(Request $request, $status = null)
    {

        $data = Project::with(['lead', 'partner'])->where('projects.status', '!=', 8)->select('projects.*');
        return Datatables::eloquent($data)
            ->editColumn('lead.url', function ($query) {
                if(!is_null($query->lead->url)){
                    return '<a href="'.$query->lead->url.'" target="_blank">'.$query->lead->url.'</a>';
                }
            })->editColumn('partner.url', function ($query) {
                if(!is_null($query->partner->url)){
                    return '<a href="'.$query->partner->url.'" target="_blank">'.$query->partner->url.'</a>';
                }
            })->editColumn('action', function ($query) {
                return  '<a title="Edit" onclick="updateContent(this)"  href="javascript:void(0)" data-id="'.$query->id.'"
                            data-description="'.htmlspecialchars($query->description).'"><span class="fa fa-edit fa-fw" ></span></a>';
            })->rawColumns(['lead.url', 'partner.url', 'action'])->make(true);
    }
}
