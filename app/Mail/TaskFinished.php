<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Task;

class TaskFinished extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The task instance.
     *
     * @var Order
     */
    public $task;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email = $this->view('emails.task-finished');

        $attachments = array();

        if (!empty($this->task->taken_img1)) {
            $attachPath1 = str_replace(url('/'), public_path(), $this->task->taken_img1);
            array_push($attachments, $attachPath1);
        }

        if (!empty($this->task->taken_img2)) {
            $attachPath2 = str_replace(url('/'), public_path(), $this->task->taken_img2);
            array_push($attachments, $attachPath2);
        }

        if (!empty($this->task->taken_img3)) {
            $attachPath3 = str_replace(url('/'), public_path(), $this->task->taken_img3);
            array_push($attachments, $attachPath3);
        }

        if (!empty($this->task->taken_img4)) {
            $attachPath4 = str_replace(url('/'), public_path(), $this->task->taken_img4);
            array_push($attachments, $attachPath4);
        }

        foreach($attachments as $filePath){
            $email->attach($filePath);
        }

        return $email;
    }
}
