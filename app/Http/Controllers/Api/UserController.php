<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class UserController extends ApiController
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {

            $user = $this->user::find($id);

            $user->name = $request->get('name');
            $user->surname = $request->get('surname');
            $user->email = $request->get('email');
            $user->phone = $request->get('phone');
            $user->no = $request->get('no');
            $user->soi = $request->get('soi');
            $user->mu = $request->get('mu');
            $user->village = $request->get('village');
            $user->street = $request->get('street');
            $user->district = $request->get('district');
            $user->city = $request->get('city');
            $user->province = $request->get('province');
            $user->postcode = $request->get('postcode');
            $user->promtpay = $request->get('promtpay');
            $user->id_number = $request->get('id_number');
            $user->office_name = $request->get('office_name');
            $user->password = \Illuminate\Support\Facades\Hash::make($request->get('password'));

            $user->save();

            return $this->respond([
                    'status' => true,
                    'data' => $user
                ]);

        } catch (\Exception $e) {
            return $this->respond([
                    'status' => false,
                    'message' => $e->getMessage()
                ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
