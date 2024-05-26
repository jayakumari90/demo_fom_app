<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;
use DataTables;

class UserController extends Controller
{
    public function index()
    {
        $roles = Role :: get();
        return view('users.index',compact('roles'));  // Ensure this view matches your Blade file
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:15',
            'description' => 'required|string',
            'role_id' => 'required|integer',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Save the user
        $user = new User($request->all());
        if ($request->hasFile('profile_image')) {
            $imageName = time().'.'.$request->profile_image->extension();  
            $request->profile_image->move(public_path('images'), $imageName);
            $user->profile_image = $imageName;
        }
        $user->save();

        return response()->json(['success' => 'User added successfully.']);
    }

    public function getData(Request $request)
    {
        $users = User::select(['id', 'name', 'email', 'phone', 'description', 'role_id', 'profile_image'])->orderBy('id','desc')->get();
        return DataTables::of($users)
            ->addIndexColumn()
            ->make(true);
    }
}
