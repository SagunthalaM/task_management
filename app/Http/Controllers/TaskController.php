<?php

namespace App\Http\Controllers;

use App\Jobs\SendTaskCreatedEmail;
use App\Models\Task;
use App\Models\User;
use App\Notifications\TaskDeletionNotification;
use App\Notifications\taskUpdationNotification;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
         if($request->ajax()){
            $tasks = Task::with('users')->get();
            return DataTables::of($tasks)
            ->addIndexColumn()
            ->addColumn('user_names', function ($task) {
                return $task->users->pluck('name')->implode(', ');
            })
            ->addColumn('actions',function($task){
                return '
                <a href="'.route('tasks.show', $task->id).'"
                class="text-decoration-none me-1" style="color:black;" >
               <i class="fa-solid fa-eye fs-5"></i> 
               </a>
                <a href="'.route('tasks.edit', $task->id).'"
                 class="text-decoration-none me-1" style="color:black;" >
                <i class="fa-solid fa-pen-to-square fs-5"></i> 
                </a>
                
                <form action="'.route('tasks.delete', $task->id).'" method="POST" style="display: inline">
                '.csrf_field().'
                '.method_field('DELETE').'
                <button type="submit" class="btn  py-0 px-0"
                 onclick="return confirm(\'Are you sure to delete tasks?\')">
                 <i class="fa-solid fa-trash fs-5"></i> 
                 </button>
           
                ';

            })->rawColumns(['actions'])
            ->make(true);
            
        }
        return view('tasks.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
       return  view('tasks.create',compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'users' => 'required|array',
            'task' => 'required',
            'description' => 'required',
            'position' => 'required',
            'progress' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',

        ]);    
         try {
            $task = Task::create(
                    [
                        'task' => $request->input('task'),
                        'description' => $request->input('description'),
                        'position' => $request->input('position'),
                        'progress' => $request->input('progress'),
                        'start_date' => $request->input('start_date'),
                        'end_date' => $request->input('end_date'),
                    ]
                    );
                    $task->users()->sync($request->input('users'));
                    SendTaskCreatedEmail::dispatch($task);
                   // return response()->json($task,200);
                    return redirect('/tasks')->with('success','Task Created Successfully');
            } catch (\Exception $e) {
                return 'Something went wrong: ' . $e->getMessage();
            }
    }

    /**
     * Display the specified resource.
     */
    public function show( $id)
    {
        try {
            
            $show_task = Task::with('users')->find($id);
            return view('tasks.show',compact('show_task'));
        } catch (ModelNotFoundException $exception) {
            return response()->view('errors.user_not_found', [], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id){
        try {
            
            $users = User::all();
            $edit = Task::findOrFail($id);
            $id = $edit->id;
            return view('tasks.edit',compact('edit','users'));
        } catch (ModelNotFoundException $exception) {
            return response()->view('errors.user_not_found', [], 404);
        }
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'users' => 'required|array',
            'task' => 'required',
            'description' => 'required',
            'position' => 'required',
            'progress' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',

        ]);
        try {

            $edit = Task::find($id);
            $edit->task = $request->input('task');
            $edit->description = $request->input('description');
            $edit->position = $request->input('position');
            $edit->progress = $request->input('progress');
            $edit->start_date = $request->input('start_date');
            $edit->end_date = $request->input('end_date');   
            $edit->save();
            $edit->users()->sync($request->input('users'));
              $emailAddresses = $edit->getEmailAddresses();

                // Send notification to each user separately
                foreach ($emailAddresses as $email) {
                    Notification::route('mail', $email)->notify(new TaskUpdationNotification($edit));
                }

            return redirect('tasks')->with('success','Task Updated Successfully');
        } catch (\Exception $e) {
            return 'Something went wrong: ' . $e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
  
    public function deleteTask($id)
    {
        try {
            // Get the task and its associated users before deletion
            $task = Task::with('users')->findOrFail($id);
            $users = $task->users;

            // Delete the task
            $deleted = $task->delete();

            if ($deleted) {
                // Send notification to each user associated with the deleted task
                foreach ($users as $user) {
                    $user->notify(new TaskDeletionNotification($task));
                }

                return redirect('tasks')->with('success', 'Task Deleted Successfully');
            } else {
                return redirect('tasks')->with('error', 'Failed to delete the task.');
            }
        } catch (\Exception $e) {
            return 'Something went wrong: ' . $e->getMessage();
        }
    }

    
    public function UserView(Request $request,$id){
        
        $user = Auth::user();
         $task = Task::with('users')->find($id);
        //dd($user);
        return view('users_view.index',compact('task'));
    }
    
    public function updateProgress(Request $request, $taskId)
    {
        // Find the task by ID
        $task = Task::find($taskId);
        if (!Auth::check()) {
            abort(401, 'Unauthorized action');
        }
        // Check if the task exists
        if (!$task) {
            abort(404, 'Task not found');
        }
        if (!$task->users->contains(Auth::user())) {
            abort(403, 'Unauthorized action');
        }

        // Validate the progress input (you can add more validation rules as needed)
        $request->validate([
            'progress' => 'required|',
        ]);

        // Update the progress
        $task->progress = $request->input('progress');
        $task->save();

        // Redirect back or return a JSON response as needed
        return back()->with('success', 'Progress updated successfully');
    }

    public function showIndividualUsersTask(Request $request)
    {
        // try {
        //     $user = Auth::user();
        
        //     $tasks = $user->tasks()->get();
        //     //dd($user);
        //     return view('users_view.show',compact('tasks')); 
           
        // } catch (ModelNotFoundException $exception) {
        //     return response()->view('errors.user_not_found', [], 404);
        // }
        if($request->ajax()){
            $user = Auth::user();
             $tasks = $user->tasks()->get();
            return DataTables::of($tasks)
            ->addIndexColumn()
            ->addColumn('actions',function($task){
                return '
                <a href="'.route('users_view.index', $task->id).'"
                class="text-decoration-none me-1" style="color:black;" >
               <i class="fa-solid fa-eye fs-5"></i> 
               </a>';
            })->rawColumns(['actions'])
            ->make(true);
            
        }
        return view('users_view.show');

    }
    static function totalTask(){
        
      //  $userId = Auth::id();
      //  return Task::with('user_id',$userId)->count();
        
        $user = Auth::user();
        
        $tasks = $user->tasks()->get()->count();
       
         return  $tasks;
        
    }
}
