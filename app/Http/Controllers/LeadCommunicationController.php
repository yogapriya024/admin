<?php

namespace App\Http\Controllers;

use App\Models\LeadCommunication;
use Illuminate\Http\Request;
use DataTables;
use App\Mail\LeadEmail;
use Illuminate\Support\Facades\Mail;

class LeadCommunicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('communication.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function introduce()
    {
        return view('introduce.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function emailSent()
    {
        return view('emailSent.index');
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
     * @param  \App\Models\LeadCommunication  $leadCommunication
     * @return \Illuminate\Http\Response
     */
    public function show(LeadCommunication $leadCommunication)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LeadCommunication  $leadCommunication
     * @return \Illuminate\Http\Response
     */
    public function edit(LeadCommunication $leadCommunication)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LeadCommunication  $leadCommunication
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LeadCommunication $leadCommunication)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LeadCommunication  $leadCommunication
     * @return \Illuminate\Http\Response
     */
    public function destroy(LeadCommunication $leadCommunication)
    {
        //
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getCommunication(Request $request, $status = null)
    {

        $data = LeadCommunication::with(['lead', 'partner']);
        if(is_null($status)){
            $data = $data->where(function($query){
                $query->where('lead_partners.status', '')->orWhereNull('lead_partners.status');
            });
        }else{
            $stus = ['introduce' => 3, 'emailSent' => 2];
            $data =$data->where('lead_partners.status', $stus[$status]);
        }

        $data = $data->select('lead_partners.*');
        return Datatables::eloquent($data)
            ->editColumn('status', function ($query) {
                $status = ['' => 'Created', '1' => 'Created', '2' => 'Email Sent', 3 => 'Introduced'];
                return $status[$query->status];
            })->editColumn('lead.country_id', function ($query) {
                if(isset($query->lead->city->description)){
                    return $query->lead->country->description. '/'. $query->lead->city->description;
                }else{
                    return $query->lead->country->description;
                }
            })->editColumn('partner.country_id', function ($query) {
                return $query->partner->country->description. '/'. $query->partner->city->description;
            })->editColumn('lead.url', function ($query) {
                if(!is_null($query->lead->url)){
                    return '<a href="'.$query->lead->url.'" target="_blank">'.$query->lead->url.'</a>';
                }
            })->editColumn('partner.url', function ($query) {
                if(!is_null($query->partner->url)){
                    return '<a href="'.$query->partner->url.'" target="_blank">'.$query->partner->url.'</a>';
                }
            })->addColumn('introduce', function ($query) {
                return '<a class="btn btn-primary btn-sm" href="'.route('introduce.email', encrypt($query->id)).'">Introduce</a>';
            })->addColumn('link', function ($query) {
                return '<a class="btn btn-primary btn-sm" href="'.route('convert', encrypt($query->id)).'">Convert</a>';
            })->rawColumns(['introduce', 'link', 'lead.url', 'partner.url'])->make(true);
    }

    public function sentEmail(Request $request)
    {
        $leadCommunication = LeadCommunication::whereIn('id', $request->id)->get();

        foreach ($leadCommunication as $communication) {
            if(is_null($communication->partner->is_regular) && (is_null($communication->partner->block) ||
                    $communication->partner->block == '')){
                $inputs = [
                    'view' => 'mail.regular',
                    'subject' => 'MALHAR INFOWAY: New requirements – MI'.$communication->lead->id,
                    'partner' => $communication->partner,
                    'lead' => $communication->lead,
                    'to' => env('To', $communication->partner->email)
                ];
                $this->sendEmail($inputs);
                $communication->status = 2;
            }else{
                $this->sendRegular($communication);
                $communication->status = 3;
            }
            $communication->lead->status = 2;
            $communication->lead->save();
            $communication->save();
        }
        return redirect()->back()->with('success', 'Email Sent Successfully');
    }

    /**
     * @param $communication
     */
    public function sendRegular($communication)
    {
        $lead = [
            'view' => 'mail.lead',
            'subject' => 'Introducing '. $communication->partner->country->description.' based '.  $communication->lead->requirements.'-MI'.$communication->lead->id,
            'partner' => $communication->partner,
            'lead' => $communication->lead,
            'to' => [env('email_to', $communication->lead->email), env('email_to', $communication->partner->email)]
        ];

        $this->sendEmail($lead);
    }

    public function introduceEmail($id)
    {
        $id = decrypt($id);
        $communication = LeadCommunication::where('id', $id)->where('status', 2)->first();
        if($communication){
            $this->sendRegular($communication);
            $communication->status = 3;
            $communication->save();
            return redirect()->back()->with('success', 'Email Sent Successfully');
        }
        abort(404);

    }


    /**
     * @param $inputs
     */
    public function sendEmail($inputs)
    {
        Mail::to($inputs['to'])
            ->cc(env('email_cc'))
            ->send(new LeadEmail($inputs));
    }
}
