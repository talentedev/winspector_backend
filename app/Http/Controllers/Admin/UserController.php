<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class UserController extends Controller
{
    /**
     * Set the guard for the controller.
     *
     */
    protected function guard()
    {
        return Auth::guard('web');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->middleware('auth:web');
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
     * Display a listing of the owner.
     *
     * @return \Illuminate\Http\Response
     */
    public function getOwners()
    {
        $owners = $this->user->role('owner')->get();
        return view('admin.users', [
            'title' => 'Employers',
            'users' => $owners
        ]);
    }

    /**
     * Display a listing of the inspectors.
     *
     * @return \Illuminate\Http\Response
     */
    public function getInspectors()
    {
        $inspectors = $this->user->role('inspector')->get();
        return view('admin.users', [
            'title' => 'Inespectors',
            'users' => $inspectors
        ]);
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
            $user->email = $request->get('email');
            $user->phone = $request->get('phone');
            $user->address = $request->get('address');
            $user->id_number = $request->get('id_number');
            $user->office_name = $request->get('office_name');

            $user->save();

            return response()->json(['status' => true], 200);

        } catch (\Exception $e) {
            return response()->json(['status' => false], 200);
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
        $this->user->destroy($id);
        return response()->json(['status' => true], 200);
    }

    /**
     * Show settings page
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showSettings()
    {
        return view('admin.settings', [
            'title' => 'Inespectors',
            'user' => auth()->user()
        ]);
    }

    /**
     * Change the account info.
     *
     * @return \Illuminate\Http\Response
     */
    public function changeSettings(Request $request)
    {
        $me = $this->user::find(auth()->user()->id);
        $me->name = $request->get('name');
        $me->email = $request->get('email');
        $password = $request->get('password');
        if ($password != '') {
            $me->password = \Illuminate\Support\Facades\Hash::make($request->get('password'));
        }
        $me->save();
        return response()->json(['status' => true], 200);
    }
}
