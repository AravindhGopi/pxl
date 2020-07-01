<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function index(){
        $data['type'] = "add";
        $data['users'] = User::where("role","!=","admin")->get();
        return view('users')->with("data",$data);
    }
    public function store(Request $request){
        $users = $request->all();
        $users['role'] = "employee";
        User::create($users);
        return redirect()->back()->with("status","User Added Successfully");
    }

    public function edit($id){
        $data['type'] = "update";
        $data['users'] = User::where("role","!=","admin")->get();
        $data['user'] = User::find($id);
        return view('users')->with("data",$data);
    }

    public function update(Request $request, $id){
        User::where('id',$id)->update($request->except(['_method','_token']));
        return redirect()->route('users_view')->with("status","User Updated Successfully");
    }
}
