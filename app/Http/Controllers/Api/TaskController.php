<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Task;

class TaskController extends ApiController
{
    /**
     * @var Task
     */
    private $task;

    /**
     * TaskController constructor.
     *
     * @param Task $task
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = auth()->user()->tasks;
        return $this->respond(['tasks' => $tasks]);
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
        try {

            $this->task->number = rand(10000000, 99999999);
            $this->task->item = $request->get('item');
            $this->task->location = $request->get('location');
            $this->task->shop = $request->get('shop');
            $this->task->due_date = $request->get('due_date');

            $this->task->save();

            auth()->user()->tasks()->attach($this->task->orderBy('created_at', 'desc')->first()->id);

            return $this->respond([
                        'status' => true,
                        'data' => $this->task->orderBy('created_at', 'desc')->first()
                    ]);

        } catch(\Exception $e) {
            return $this->respond([
                        'status' => false,
                        'message' => $e->getMessage()
                    ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $task = $this->task->find($id);
            return $this->respond([
                        'status' => true,
                        'task' => $task
                    ]);
        } catch(\Exception $e) {
            return $this->respond([
                        'status' => false,
                        'message' => $e->getMessage()
                    ]);
        }
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

            $task = $this->task->find($id);
            $task->item = $request->get('item');
            $task->location = $request->get('location');
            $task->shop = $request->get('shop');

            // Convert base64 to image object and save
            $image1 = $request->get('img_url1');
            if ($image1 != '') {
                $image1 = str_replace('data:image/png;base64,', '', $image1);
                $imgName = 'photo1-' . time() . '.png';
                \File::put(public_path(). '/photos/' . $imgName, base64_decode($image1));
                $task->img_url1 = url('/'). '/photos/' . $imgName;
            }

            $image2 = $request->get('img_url2');
            if ($image2 != '') {
                $image2 = str_replace('data:image/png;base64,', '', $image2);
                $imgName = 'photo2-' . time() . '.png';
                \File::put(public_path(). '/photos/' . $imgName, base64_decode($image2));
                $task->img_url2 = url('/'). '/photos/' . $imgName;
            }

            $image3 = $request->get('img_url3');
            if ($image3 != '') {
                $image3 = str_replace('data:image/png;base64,', '', $image3);
                $imgName = 'photo3-' . time() . '.png';
                \File::put(public_path(). '/photos/' . $imgName, base64_decode($image3));
                $task->img_url3 = url('/'). '/photos/' . $imgName;
            }

            $image4 = $request->get('img_url4');
            if ($image4 != '') {
                $image4 = str_replace('data:image/png;base64,', '', $image4);
                $imgName = 'photo4-' . time() . '.png';
                \File::put(public_path(). '/photos/' . $imgName, base64_decode($image4));
                $task->img_url4 = url('/'). '/photos/' . $imgName;
            }

            $task->save();

            return $this->respond([
                        'status' => true,
                        'data' => $this->task->orderBy('updated_at', 'desc')->first()
                    ]);

        } catch(\Exception $e) {
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

    /**
     * Accept the task
     *
     * @param  string $task_name
     * @return Boolean
     */
    public function acceptTask($task_id)
    {
        $task = $this->task->find($task_id);
        $task->status = 1;

        $task->save();

        auth()->user()->tasks()->attach($task_id);

        return $this->respond([
            'status' => true,
            'data' => $task
        ]);
    }
}
