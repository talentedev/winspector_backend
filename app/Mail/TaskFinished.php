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
        $attachPath1 = str_replace(url('/'), public_path(), $this->task->taken_img1);
        $attachPath2 = str_replace(url('/'), public_path(), $this->task->taken_img2);
        $attachPath3 = str_replace(url('/'), public_path(), $this->task->taken_img3);
        $attachPath4 = str_replace(url('/'), public_path(), $this->task->taken_img4);
        return $this->view('emails.task-finished')
                    ->attach($attachPath1)
                    ->attach($attachPath2)
                    ->attach($attachPath3)
                    ->attach($attachPath4);
    }
}
