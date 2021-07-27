<?php

namespace App\Http\Controllers;

use App\Mail\LeadEmail;
use App\Models\CustomerRequest;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Mail;

class CustomerRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('customerrequest.index');
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
            'service' => 'required',
            'type' => "required",
            'company' => "required",
            'contact_name' => "required",
            'location' => "required",
            'url' => "required"
        ]);

        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()]);
        }

        $crequest = CustomerRequest::updateCreate($request);
        return $crequest;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CustomerRequest  $customerRequest
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id = decrypt($id);
        $customerRequest = CustomerRequest::find($id);
        $customerRequest->delete();
        return redirect()->back()->with('success', 'Request Archived Successfully');
    }

    public function getCustomerRequest(Request $request)
    {
        $data = CustomerRequest::select('*');
        return Datatables::eloquent($data)
            ->addColumn('action', function ($query) {
                $link =  '<a title="Edit" onclick="updateContent(this)"  href="javascript:void(0)" data-id="'.$query->id.'" data-country_id="'.$query->country_id.'"
                            data-service="'.$query->service.'"
                            data-type="'.$query->type.'"
                            data-email="'.$query->email.'"
                            data-company="'.$query->company.'"
                            data-contact_name="'.$query->contact_name.'"
                            data-url="'.$query->url.'"
                            data-location="'.$query->location.'"><span class="fa fa-edit fa-fw" ></span></a>';

                    $link.=' <a title="Delete" href="javascript:void(0)" data-url = "'.route('customerRequest.destroy',encrypt($query->id)).'"
                    onclick="deleteData(this)" class=""><span class="fa fa-trash fa-fw"></span></a>';

                $link.=' <a href="javascript:void(0)" class="btn btn-primary btn-sm" title="Convert">Convert</a>';
                return $link;
            })->editColumn('url', function ($query) {
                return '<a href="'.$query->url.'" target="_blank">'.$query->url.'</a>';
            })->editColumn('last_date', function ($query) {
                if(!is_null( $query->last_date)){
                    return $query->last_date->format('d/m/Y');
                }
            })->addColumn('compare', function ($query) {
                if($query->last_date <= date('Y-m-d')){
                    return 'less';
                }
            })->rawColumns(['action', 'url'])->make(true);
    }
    public function sentEmail(Request $request)
    {
        $customerRequest = CustomerRequest::whereIn('id', $request->id)->get();

        foreach ($customerRequest as $crequest) {
            $input = [
                'view' => 'mail.customer_request',
                'subject' => 'Regards '. $crequest->service.' '.$crequest->type.' From '.  $crequest->company,
                'crequest' => $crequest,
                'to' => [env('email_to', $crequest->email)]
            ];

            $this->sendEmail($input);
            $crequest->status = 2;
            $crequest->save();
        }
        return redirect()->back()->with('success', 'Email Sent Successfully');
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
