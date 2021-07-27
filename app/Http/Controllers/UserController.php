<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.index');
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
            'name' => 'required',
            'email' => "required|unique:users,email,{$request->id}",
            'password' => Rule::requiredIf($request->set_password).'|confirmed',
            'status' => "required",
        ]);

        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()]);
        }
        $user = User::updateCreate($request);
        if($request->has('set_password')){
            $user->password = bcrypt($request->password);
            $user->save();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id = decrypt($id);
        $user = user::find($id);
        $user->delete();
        return redirect()->back()->with('success', 'User Deleted Successfully');
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getUser(Request $request)
    {

        $data = User::select('users.*');
        return Datatables::eloquent($data)
            ->addColumn('action', function ($query) {
                return '<a onclick="updateContent(this)"  href="javascript:void(0)" data-id="'.$query->id.'"
                            data-name="'.$query->name.'" data-email="'.$query->email.'" data-status="'.$query->status.'"><span class="fa fa-edit fa-fw" ></span></a>
                        <a  href="javascript:void(0)" data-url = "'.route('user.destroy', encrypt($query->id)).'"
                    onclick="deleteData(this)" class="hide"><span class="fa fa-trash fa-fw"></span></a>';
            })->rawColumns(['action'])->make(true);
    }
}
