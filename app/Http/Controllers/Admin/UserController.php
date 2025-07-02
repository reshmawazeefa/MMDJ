<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Crypt;

use DB;

class UserController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:manage-user', ['only' => ['index','create','store','edit','update']]);
    }

    public function index(Request $request)
    {
        $users = User::where('id','!=',1)->get();
        return view('admin.users', compact('users'));
    }
    
    public function create()
    {
        $roles = Role::where('id','!=',1)->pluck('name','name')->all();
        return view('admin.add_user',compact('roles'));
    }

    public function store(Request $request)
    {
        //dd($request);
        $validator = $request->validate( ['name' => 'required', 
            'email' => 'required|unique:users,email',
            'phone' => 'required|digits:10|unique:users,phone',
           'password' => 'required|string|min:8|confirmed']);
            $roles = $request->input('roles')? $request->input('roles') : 'Manager';
            $user = User::create([
                'name' => $request->name, 
                'email' => $request->email,
                'phone' => $request->phone,
                'role' => $roles,
                'password' => bcrypt($request->password),
                'plain_password' => Crypt::encryptString($request->password)  // For admin access
            ]);

      
        // if(empty($roles))
        // {
        //     $roles = 'Salesman';
        //     $user->role = $roles;
        //     $user->approver1 = $request->approver1;
        //     $user->approver2 = $request->approver2;
        //     $user->save();
        // }

        $user->assignRole($roles);
        
        return redirect('admin/users')->with('success','User added successfully');
    }
    
    public function edit(User $user)
    {
        $user = User::with(array('approver_1','approver_2'))->where('id',$user->id)->first();
        //dd($user);
        $decryptedPassword = Crypt::decryptString($user->plain_password);
        $roles = Role::where('id','!=',1)->pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->first();
        return view('admin.edit_user', compact('user','roles','userRole','decryptedPassword'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {

        //dd($request);
        $validator = $request->validate( ['name' => 'required',
            'passwordInput' => 'required|string|min:8',
            'email' => 'unique:users,email,' . $user->id,
            'phone' => 'digits:10|unique:users,phone,' . $user->id,            

        ]);

        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->role = $request->roles ? $request->roles : 'Manager';

        if($request->passwordInput)
            $user->password = bcrypt($request->passwordInput);
            $user->plain_password = Crypt::encryptString($request->passwordInput);

        $roles = $request->input('roles');

        if(empty($roles))
        {
            $roles = 'Manager';
            $user->approver1 = $request->approver1;
            $user->approver2 = $request->approver2;
        }
        elseif($roles == 'Admin')
        {            
            $user->approver1 = null;
            $user->approver2 = null;
        }
        
        $user->save();

        if($user->userRole != $roles)
        {            
            DB::table('model_has_roles')->where('model_id',$user->id)->delete();

            $user->assignRole($roles);
        }

        return redirect('admin/users')->with('success','User updated successfully');
    }

    public function destroy($id)
{
    $user = User::find($id);

    if (!$user) {
        return redirect()->route('users.index')->with('error', 'User not found.');
    }

    $user->delete();
    return redirect()->route('users.index')->with('success', 'User deleted successfully.');
}

    function get_users(Request $request)
    {
        $data = [];
        $page = $request->page;
        $resultCount = 25;
        $offset = ($page - 1) * $resultCount;
        /** search the users by name,phone and email**/
        
        if ($request->has('q') && $request->q!= '') {
            $search = $request->q;
            // ->where('id',auth()->user()->id)
            $data = User::select("*")
            ->where(function ($query) use ($search) {
                $query->where('name','LIKE',"%$search%")
                      ->orWhere('phone','LIKE',"%$search%");
            })->skip($offset)->take($resultCount)->get();
        // ->where('id',auth()->user()->id)
            $count = User::select("id","phone","name")
            ->where(function ($query) use ($search) {
                $query->where('name','LIKE',"%$search%")
                      ->orWhere('phone','LIKE',"%$search%");
            })->count();
        
        }
        else{
        /** get the users**/
        // $data = User::select("*")->where('id',auth()->user()->id)->skip($offset)->take($resultCount)->get();
        $data = User::select("*")->skip($offset)->take($resultCount)->get();
        
        $count =User::select("id","phone","name")->count();
        }
        /**set pagination**/
        $endCount = $offset + $resultCount;
        if($endCount >= $count)
            $morePages = false;
        else
            $morePages = true;
            
        $result = array(
        "data" => $data,
        "pagination" => array(
        "more" => $morePages
        )
        );
        return response()->json($result);
    }
}
