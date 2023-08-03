<?php

namespace App\Console\Commands;

use App\Mail\TaskCreatedMail as MailTaskCreatedMail;
use App\Models\Task;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class TaskCreatedMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send mail to users when task created or updated';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $newTasks = Task::whereDate('created_at',now())->get();
       // $users = User::all();
       
        foreach ($newTasks as $task) {
            $users = $task->users;
            foreach($users as $user){
                Mail::to($user->email)->send(new MailTaskCreatedMail($task) );
    
            }
        }
        $this->info('Created task sent email successfully');
    }
}
