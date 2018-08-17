<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Task;

class TaskController extends Controller
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
    public function __construct(Task $task)
    {
        $this->middleware('auth:web');
        $this->task = $task;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = $this->task->get();
        return view('admin.tasks', [
            'tasks' => $tasks
        ]);
    }

    /**
     * Display a listing of the pending task.
     *
     * @return \Illuminate\Http\Response
     */
    public function getPendingTasks()
    {
        $tasks = $this->task->where('status', '!=', 3)->get();
        return view('admin.tasks', [
            'title' => 'Pending Jobs',
            'tasks' => $tasks
        ]);
    }

    /**
     * Display a listing of the finished task.
     *
     * @return \Illuminate\Http\Response
     */
    public function getFinishedTasks()
    {
        $tasks = $this->task->where('status', 3)->get();
        return view('admin.tasks', [
            'title' => 'Finished Jobs',
            'tasks' => $tasks
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
        //
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
