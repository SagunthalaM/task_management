<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index(Request $request)
    // {
        
        
    // }
    public function index(Request $request){
        if($request->ajax()){
           // $data = User::all();
           $data = User::latest()->get();
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('actions',function($user){
                return '
                <a href="'.route('admin.user.get_user', $user->id).'"
                class="text-decoration-none me-3" style="color:black;" >
               <i class="fa-solid fa-eye fs-5"></i> 
               </a>
                <a href="'.route('admin.user.edit', $user->id).'"
                 class="text-decoration-none me-3" style="color:black;" >
                <i class="fa-solid fa-pen-to-square fs-5"></i> 
                </a>
                
                <form action="'.route('admin.user.delete', $user->id).'" method="POST" style="display: inline">
                '.csrf_field().'
                '.method_field('DELETE').'
                <button type="submit" class="btn  py-0 px-0"
                 onclick="return confirm(\'Are you sure to delete user?\')">
                 <i class="fa-solid fa-trash fs-5"></i> 
                 </button>
           
                ';

            })->rawColumns(['actions'])
            ->make(true);
        }
        return view('users.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function AddUserIndex(){
        //$all = DB::table('users')->get();
        return view('users.create');
    }  
    public function InsertUser(Request $request){
        $request->validate([
                'name'=>'required|regex:/^[^\d]+$/|string',
                'email'=>'required|regex:/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/|unique:users',
                'password'=>'required|min:8|confirmed|',
                'role'=>'required'     
        ]);
        $data=[];
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['role'] = $request->role;
        $data['password'] = Hash::make($request->password);

        $insert = DB::table('users')->insert($data);
        if($insert){
          Session::flash('success', 'User Created successfully!');
          return back();
           //return redirect('admin/users');
        }
        else{
            echo "something is wrong";
        }
    }
    public function EditUser($id)
    {
       // $edit = DB::table('users')->where('id',$id)->first();
    
        try {
            $edit = User::findOrFail($id);
            $id = $edit->id;
            return view('users.edit',compact('edit'));
        } catch (ModelNotFoundException $exception) {
            return response()->view('errors.user_not_found', [], 404);
        }
    }
    public function UpdateUser(Request $request,$id)
    {
            $data=[];
            $data['name'] = $request->name;
            $data['email'] = $request->email;
            $data['role'] = $request->role;
            $data['password'] = Hash::make($request->password);
            $update = DB::table('users')->where('id',$id)->update($data);
            if($update){
                Session::flash('success','User Updated Successfully!');
                
                
                return back();
            // return redirect('admin/users')->with('success','user updated successfully');
            }
            else{
                echo "something is wrong";
            }
    }
   

        public function getUser($id)
        {
            try {
                $show_user = User::findOrFail($id);
                $id = $show_user->id;
                return view('users.show',compact('show_user'));
            } catch (ModelNotFoundException $exception) {
                return response()->view('errors.user_not_found', [], 404);
            }

             $show_user = User::findOrFail($id);
            return view('users.show',compact('show_user'));
        }
        public function DeleteUser($id){
            $delete = DB::table('users')->where('id',$id)->delete();
            if($delete)
            {
                Session::flash('danger', 'User deleted successfully!');
                return back();
            
               // return redirect('admin/users')->with('success','user deleted successfully');;
            // echo 'User Successfully Deleted';
            }
            else{
                echo "Something is wrong";
            }

        }

    
}
