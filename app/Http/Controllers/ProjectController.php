<?php

namespace App\Http\Controllers;

use App\Projects;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(){
        $data['type'] = "add";
        $data['projects'] = Projects::all();
        return view('projects')->with("data",$data);
    }

    public function store(Request $request){
        Projects::create([
            "project_name"=>$request->project_name
        ]);
        return redirect()->back()->with("status","Project Added Successfully");
    }

    public function edit($id){
        $data['type'] = "update";
        $data['projects'] = Projects::all();
        $data['project'] = Projects::find($id);
        return view('projects')->with("data",$data);
    }

    public function update(Request $request, $id){
        Projects::where('id',$id)->update([
            "project_name"=>$request->project_name
        ]);
        return redirect()->route('projects_view')->with("status","Project Updated Successfully");
    }

    public function delete($id){
        Projects::destroy($id);
        return redirect()->route('projects_view')->with("status","Project Deleted Successfully");
    }

    public function getAllProjects(){
        return Projects::all();
    }
}
