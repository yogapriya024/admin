<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Country;
use App\Models\Lead;
use App\Models\LeadCommunication;
use App\Models\Partner;
use App\Models\Project;
use App\Models\Tag;
use Illuminate\Http\Request;
use DataTables;

class LeadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $country = Country::active();
        $tags = Tag::where('status', 1)->get();
        return view('lead.index', compact('tags', 'country'));
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
        $regex = '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';
        $validator = \Validator::make($request->all(), [
            'name' => 'required',
            'email' => "required|unique:leads,email,{$request->id}",
            'country_id' => "required",
            'tag_id' => "required",
            'requirements' => "required|max:200",
            'initial_requirements' => "required",
           // 'url' => 'regex:' . $regex,
        ]);

        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()]);
        }
        $lead = Lead::updateCreate($request);
        $lead->tag()->sync($request->tag_id);
        return $lead->id;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Lead  $lead
     * @return \Illuminate\Http\Response
     */
    public function show(Lead $lead)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Lead  $lead
     * @return \Illuminate\Http\Response
     */
    public function edit(Lead $lead)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Lead  $lead
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lead $lead)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Lead  $lead
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id = decrypt($id);
        LeadCommunication::where('lead_id', $id)->delete();
        $lead = Lead::find($id);
        $lead->tag()->detach();
        $lead->delete();
        return redirect()->back()->with('success', 'Lead Deleted Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Lead  $lead
     * @return \Illuminate\Http\Response
     */
    public function archive($id)
    {
        $id = decrypt($id);
        LeadCommunication::where('lead_id', $id)->update(['status' => 8]);
        Project::where('lead_id', $id)->update(['status' => 8]);
        $lead = Lead::find($id);
        $lead->status = 8;
        $lead->save();
        return redirect()->back()->with('success', 'Lead Archived Successfully');
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getLead(Request $request)
    {

        $data = Lead::with(['country', 'tag', 'city'])
            ->where('status', '!=', 8)->select('leads.*');
        return Datatables::eloquent($data)
            ->addColumn('action', function ($query) {
                $link =  '<a title="Edit" onclick="updateContent(this)"  href="javascript:void(0)" data-id="'.$query->id.'" data-country_id="'.$query->country_id.'"
                            data-description="'.htmlspecialchars($query->description).'"
                            data-name="'.$query->name.'"
                            data-url="'.$query->url.'"
                            data-email="'.$query->email.'"
                            data-date="'.date('Y-m-d', strtotime($query->date)).'"
                            data-contact="'.$query->contact.'"
                            data-initial_requirements="'.htmlspecialchars($query->initial_requirements).'"
                            data-requirements="'.htmlspecialchars($query->requirements).'"
                            data-tag_id="'.$query->tag->pluck('id').'"
                            data-rfp_email_text="'.htmlspecialchars($query->rfp_email_text).'"
                            data-isrfp="'.$query->isrfp.'"
                            data-world_wide="'.$query->world_wide.'"
                            data-city_id="'.$query->city_id.'"><span class="fa fa-edit fa-fw" ></span></a>';
                if(in_array($query->status, [2,3])){
                    $link.=' <a title="Archive" href="javascript:void(0)" data-url = "'.route('lead.archive',encrypt($query->id)).'"
                    onclick="archiveData(this)" class=""><span class="fa fa fa-archive"></span></a>';
                }else{
                    $link.=' <a title="Delete" href="javascript:void(0)" data-url = "'.route('lead.destroy',encrypt($query->id)).'"
                    onclick="deleteData(this)" class=""><span class="fa fa-trash fa-fw"></span></a>';
                }
                $link.=' <a href="'.route('saveContact', encrypt($query->id)).'" title="Contact"><i class="fa fa-address-book" aria-hidden="true"></i></a>';
                return $link;
            })->editColumn('status', function ($query) {
                $status = ['' => '', '1' => 'Created', '2' => 'Processed', '3' => 'Converted'];
                return $status[$query->status];
            })->editColumn('url', function ($query) {
                return '<a href="'.$query->url.'" target="_blank">'.$query->url.'</a>';
            })->addColumn('tag', function ($query) {
               $tag = $query->tag->pluck('description');
               return implode(',', $tag->toArray());
            })->rawColumns(['action', 'url'])->make(true);
    }

    public function saveContact($id)
    {
        $id = decrypt($id);
        $lead = Lead::find($id);
        $tags = $lead->tag->pluck('id');
        $partners = Partner::whereHas('tag', function($query) use ($tags){
                $query->whereIn('id', $tags);
            })->where(function($query){
                $query->whereNull('block')->orWhere('block', '!=', 1);
        });
        if(is_null($lead->world_wide)){
            $partners = $partners->where('country_id', $lead->country_id);
        }
        if(is_null($lead->world_wide) && !is_null($lead->city_id)){
            $partners = $partners->where('city_id', $lead->city_id);
        }
        $partners = $partners->get();
        if($partners->count()){
            foreach($partners as $partner)
            {
                $data = ['lead_id' => $lead->id, 'partner_id' => $partner->id];
                LeadCommunication::updateCreate($data);
            }
            return redirect(route('communication.index'))->with('success', 'Lead contact added successfully');
        }else{
            return redirect()->back()->with('error', 'No Records Match');
        }


    }
}
