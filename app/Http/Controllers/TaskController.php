<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

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
    
    

    /**
     * Update the specified resource in storage.
     */
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
            return redirect('tasks')->with('success','Task Updated Successfully');
        } catch (\Exception $e) {
            return 'Something went wrong: ' . $e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        $delete = DB::table('tasks')->where('id',$id)->delete();
        if($delete)
        {
            Session::flash('danger', 'User deleted successfully!');
            return back();
        }
        else{
            echo "Something is wrong";
        }
    }
    
    public function UserView(){
        
        $user = Auth::user();
        
        $tasks = $user->tasks()->get();
        //dd($user);
        return view('users_view.index',compact('tasks'));
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

        // // Check if the authenticated user is the owner of the task
        // if ($task->user_id !== Auth::id()) {
        //     abort(403, 'Unauthorized action');
        // }
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
        return redirect('user-view')->with('success', 'Progress updated successfully');
    }

    static function totalTask(){
        
      //  $userId = Auth::id();
      //  return Task::with('user_id',$userId)->count();
        
        $user = Auth::user();
        
        $tasks = $user->tasks()->get()->count();
       
         return  $tasks;
        
    }
}
