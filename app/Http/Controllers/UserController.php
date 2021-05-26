<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\Roles;
use Illuminate\Support\Facades\Validator;
use Hash;
use App\Notifications\LoginCredentials;
use App\Notifications\UpdateUserNotification;
use Notification;
use Response;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /*
        This funtion will return all users with roles list
    */
    public function index(){
        $users = User::where('role', '<>', 1)->orderby('updated_at', 'DESC')->paginate(5);
        $roles = Roles::all()->keyBy('id');
        return view('users.index', compact('users', 'roles'));
    }

    /*
        This funtion will return to roles list
    */
    public function create(){
        $roles = Roles::all()->where('id', '<>', 1)->pluck('title', 'id');
        return view('users.create', compact('roles'));
    }

    /*
        This funtion will recive request in parmeter
        and will redirect to user list
    */
    public function store(Request $request){
        $user_data = $request->all();
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|unique:users|max:255|email',
            'password' => 'required',
            'confirm_password' => 'required|password',
            'role' => 'required|integer',
        ]);

         if ($validator->fails()) {
            return redirect('/add_user')
                        ->withErrors($validator)
                        ->withInput();
        }
        $credentialsData['email'] = $user_data['email'];
        $credentialsData['password'] = $user_data['password'];

        unset($user_data['confirm_password']);
        $user_data['password'] = Hash::make($user_data['password']);
        $user = User::create($user_data);

        $user->notify(new LoginCredentials($credentialsData));

        return redirect('/list_user');

    }

    /*
        This funtion will recive user ID in parmeter
        and will return all user detalis of that ID with role list
    */
    public function edit($id){

        $user = User::all()->where('id', $id)->first();
        $roles = Roles::all()->where('id', '<>', 1)->pluck('title', 'id');
        return view('users.edit', compact('user', 'roles'));
    }

    /*
        This funtion will recive request in parmeter
        and will redirect to user list
    */
    public function update(Request $request){
        $user_data = $request->all();
        $id = $user_data['id'];
        unset($user_data['id']);
        unset($user_data['_token']);
        
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|max:255|unique:users,email,'.$id,
            'password' => 'required',
            'confirm_password' => 'required|password',
            'role' => 'required|integer',
        ]);
        
        if ($validator->fails()) {
            return redirect('/edit_user/'.$id)
                        ->withErrors($validator)
                        ->withInput();
        }

        unset($user_data['confirm_password']);
        $detalis = $user_data;
        $userRole = Roles::select('title')->where('id', $detalis['role'])->first();
        $detalis['role'] = $userRole->title;
        $user_data['password'] = Hash::make($user_data['password']);

        User::where('id',$id)->update($user_data);
        $user = User::find($id);
        $user->notify(new UpdateUserNotification($detalis));
        return redirect('/list_user');

    }

    /*
        This funtion will recive user ID in parmeter
        and will return user list
    */
    public function destroy($id){
        $user = User::findOrFail($id);
        $user->delete();

        return redirect('/list_user');        
    }

    /*
        This funtion will return user.csv file
    */
    public function exportCsv(){
        $users = User::where('role', '<>', 1)->orderby('id', 'DESC')->get();
        $roles = Roles::all()->keyBy('id');

        $filename = "users.csv";
        $handle = fopen($filename, 'w+');
        fputcsv($handle, array('First Name', 'Last Name', 'Email', 'Role'));

        foreach($users as $row) {
            fputcsv($handle, array($row['first_name'], $row['last_name'], $row['email'], $roles[$row->role]['title']));
        }

        fclose($handle);

        $headers = array(
            'Content-Type' => 'text/csv',
        );

        return Response::download($filename, 'users.csv', $headers);
    }
}
