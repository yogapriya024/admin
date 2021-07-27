<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use App\Models\Partner;
use App\Models\Tag;
use Illuminate\Http\Request;
use DataTables;

class PartnerController extends Controller
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
        $categories = Category::where('status', 1)->get();
        return view('partner.index', compact('tags', 'country', 'categories'));
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
            //'speciality' => 'required',
            'email' => "required|unique:partners,email,{$request->id}",
            'city_id' => "required",
            'country_id' => "required",
            'tag_id' => "required",
            'category_id' => "required",
            'percentage' => "required",
        ]);

        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()]);
        }
        $partner = Partner::updateCreate($request);
        $partner->tag()->sync($request->tag_id);
        return $partner->id;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function show(Partner $partner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function edit(Partner $partner)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Partner $partner)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id = decrypt($id);
        $lead = Partner::find($id);
        $lead->delete();
        return redirect()->back()->with('success', 'Partner Deleted Successfully');
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getPartner(Request $request)
    {

        $data = Partner::with(['country', 'tag', 'city', 'category'])->select('partners.*');
        return Datatables::eloquent($data)
            ->addColumn('action', function ($query) {
                return '<a onclick="updateContent(this)"  href="javascript:void(0)" data-id="'.$query->id.'" data-country_id="'.$query->country_id.'"
                            data-description="'.htmlspecialchars($query->description).'"
                            data-name="'.$query->name.'"
                            data-category_id="'.$query->category_id.'"
                            data-block="'.$query->block.'"
                            data-email="'.$query->email.'"
                            data-url="'.$query->url.'"
                            data-contact="'.$query->contact.'"
                            data-percentage="'.$query->percentage.'"
                            data-tag_id="'.$query->tag->pluck('id').'"
                            data-speciality="'.$query->speciality.'"
                            data-is_regular="'.$query->is_regular.'"
                            data-city_id="'.$query->city_id.'"><span class="fa fa-edit fa-fw" ></span></a>
                        <a  href="javascript:void(0)" data-url = "'.route('partner.destroy',encrypt($query->id)).'"
                    onclick="deleteData(this)" class=""><span class="fa fa-trash fa-fw"></span></a>';
            })->editColumn('status', function ($query) {
                $status = ['' => '', '1' => 'Active', '2' => 'In Active'];
                return $status[$query->status];
            })->addColumn('tag', function ($query) {
                $tag = $query->tag->pluck('description');
                return implode(',', $tag->toArray());
            })->editColumn('url', function ($query) {
                return '<a href="'.$query->url.'" target="_blank">'.$query->url.'</a>';
            })->rawColumns(['action', 'url'])->make(true);
    }

    public function updateBlock($id)
    {
        $id = decrypt($id);
        $partner = Partner::where('id', $id)->first();
        if($partner){
            $partner->block = 1;
            $partner->save();
        }
        return view('mail.unsubscribe');
    }
}
