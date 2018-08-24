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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAvailableTasks()
    {
        $tasks = $this->task->where('status', 0)->get();
        return $this->respond($tasks);
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
            if (Auth::user()->hasRole('owner')) {
                $this->task->number = rand(10000000, 99999999);
                $this->task->item = $request->get('item');
                $this->task->location = $request->get('location');
                $this->task->shop = $request->get('shop');
                $this->task->due_date = $request->get('due_date');

                // Convert base64 to image object and save
                $image1 = $request->get('img_url1');
                if ($image1 != '') {
                    $imgName = $this->storeImage($image1, 'photo1');
                    $this->task->img_url1 = url('/'). '/photos/' . $imgName;
                }

                $image2 = $request->get('img_url2');
                if ($image2 != '') {
                    $imgName = $this->storeImage($image2, 'photo2');
                    $this->task->img_url2 = url('/'). '/photos/' . $imgName;
                }

                $image3 = $request->get('img_url3');
                if ($image3 != '') {
                    $imgName = $this->storeImage($image3, 'photo3');
                    $this->task->img_url3 = url('/'). '/photos/' . $imgName;
                }

                $image4 = $request->get('img_url4');
                if ($image4 != '') {
                    $imgName = $this->storeImage($image4, 'photo4');
                    $this->task->img_url4 = url('/'). '/photos/' . $imgName;
                }

                $this->task->save();

                auth()->user()->tasks()->attach($this->task->orderBy('created_at', 'desc')->first()->id);

                return $this->respond([
                            'status' => true,
                            'data' => $this->task->orderBy('created_at', 'desc')->first()
                        ]);
            } else {
                return $this->respond([
                            'status' => false,
                            'message' => 'The user has no permission to create job.'
                        ]);
            }

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
            $task->due_date = $request->get('due_date');

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
     * Save image file to public directory
     *
     * @param  string  $base64Image
     * @param  string  $prefixImgName
     * @return string $imgName
     */
    protected function storeImage($base64Image, $prefixImgName) {
        $base64Image = str_replace('data:image/png;base64,', '', $base64Image);
        $imgName = $prefixImgName . '_' . time() . '.png';
        \File::put(public_path(). '/photos/' . $imgName, base64_decode($base64Image));
        return $imgName;
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
        if (Auth::user()->hasRole('inspector')) {
            $task = $this->task->find($task_id);
            $task->status = 1;

            $task->save();

            auth()->user()->tasks()->attach($task_id);

            return $this->respond([
                'status' => true,
                'data' => $task
            ]);
        } else {
            return $this->respond([
                        'status' => false,
                        'message' => 'The user has no permission to accept job.'
                    ]);
        }
    }

    /**
     * Send photos to employer
     *
     * @param  string $task_id
     * @return Boolean
     */
    public function sendPhotos(Request $request)
    {
        try {
            if (Auth::user()->hasRole('inspector')) {
                $task_id = $request->get('id');
                $task = $this->task->find($task_id);

                $taken_img1 = $request->get('taken_img1');
                if ($taken_img1 != '') {
                    $imgName = $this->storeImage($taken_img1, 'taken1');
                    $task->taken_img1 = url('/'). '/photos/' . $imgName;
                }

                $taken_img2 = $request->get('taken_img2');
                if ($taken_img2 != '') {
                    $imgName = $this->storeImage($taken_img2, 'taken2');
                    $task->taken_img2 = url('/'). '/photos/' . $imgName;
                }

                $taken_img3 = $request->get('taken_img3');
                if ($taken_img3 != '') {
                    $imgName = $this->storeImage($taken_img3, 'taken3');
                    $task->taken_img3 = url('/'). '/photos/' . $imgName;
                }

                $taken_img4 = $request->get('taken_img4');
                if ($taken_img4 != '') {
                    $imgName = $this->storeImage($taken_img4, 'taken4');
                    $task->taken_img4 = url('/'). '/photos/' . $imgName;
                }

                $task->lat_long = $request->get('lat_long');
                $task->status = 2;

                $task->save();

                return $this->respond([
                            'status' => true,
                            'data' => $task
                        ]);
            } else {
                return $this->respond([
                            'status' => false,
                            'message' => 'The user has no permission to send photos.'
                        ]);
            }

        } catch(\Exception $e) {
            return $this->respond([
                        'status' => false,
                        'message' => $e->getMessage()
                    ]);
        }
    }

    /**
     * Retake photos
     *
     * @param  string $task_id
     * @return Boolean
     */
    public function retakePhotos($task_id)
    {
        try {
            if (Auth::user()->hasRole('owner')) {
                $task = $this->task->find($task_id);

                $task->status = 3;

                $task->save();

                return $this->respond([
                            'status' => true,
                            'data' => $task
                        ]);
            } else {
                return $this->respond([
                            'status' => false,
                            'message' => 'The user has no permission to reject the photos.'
                        ]);
            }

        } catch(\Exception $e) {
            return $this->respond([
                        'status' => false,
                        'message' => $e->getMessage()
                    ]);
        }
    }

    /**
     * Finish Task
     *
     * @param  string $task_id
     * @return Boolean
     */
    public function finishTask($task_id)
    {
        try {
            if (Auth::user()->hasRole('owner')) {
                $task = $this->task->find($task_id);

                $task->status = 4;

                $task->save();

                return $this->respond([
                            'status' => true,
                            'data' => $task
                        ]);
            } else {
                return $this->respond([
                            'status' => false,
                            'message' => 'The user has no permission to finish job.'
                        ]);
            }

        } catch(\Exception $e) {
            return $this->respond([
                        'status' => false,
                        'message' => $e->getMessage()
                    ]);
        }
    }
}
