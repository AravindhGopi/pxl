<?php

namespace App\Http\Controllers;

use App\DailyReport;
use App\DailyReportDetails;
use App\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class DailyReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('daily_reports.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        DB::beginTransaction();
        $dailyReport = new DailyReport();
        $dailyReport->entry_date = DateTime::createFromFormat("d/m/Y",$request->entry_date)->format('Y-m-d');
        $dailyReport->user_id = Auth::id();
        $dailyReport->is_leave = ($request->is_leave == 'yes') ? 1 : 0;
        $dailyReport->leave_type = isset($request->leave_type) ? $request->leave_type : '';
        $dailyReport->leave_on = isset($request->leave_on) ? $request->leave_on : '';
        $dailyReport->save();
        $dailyReportId = $dailyReport->id;
        $allProjects = array();
        for($i=0; $i<sizeof($request->projects['hours_worked']); $i++){
            $projects = array();
            $projects['hours_worked'] = $request->projects['hours_worked'][$i];
            $projects['project_specific_training'] = $request->projects['project_specific_training'][$i];
            $projects['partnership_specific_training'] = $request->projects['partnership_specific_training'][$i];
            $projects['vendor_general_trainings'] = $request->projects['vendor_general_trainings'][$i];
            $projects['over_time'] = $request->projects['over_time'][$i];
            $projects['idle_hours'] = $request->projects['idle_hours'][$i];
            $projects['comments'] = $request->projects['comments'][$i];
            $projects['total_hours'] = $request->projects['total_hours'][$i];
            $projects['project_id'] = $request->projects['project'][$i];
            $allProjects[] = $projects;
        }

        foreach($allProjects as $project){
            $dailyReportDetails = new DailyReportDetails();
            $dailyReportDetails->daily_report_id = $dailyReportId;
            $dailyReportDetails->hours_worked = $project['hours_worked'];
            $dailyReportDetails->project_id = $project['project_id'];
            $dailyReportDetails->project_specific_training = $project['project_specific_training'];
            $dailyReportDetails->partnership_specific_training = $project['partnership_specific_training'];
            $dailyReportDetails->vendor_general_trainings = $project['vendor_general_trainings'];
            $dailyReportDetails->over_time = $project['over_time'];
            $dailyReportDetails->idle_hours = $project['idle_hours'];
            $dailyReportDetails->comments = $project['comments'];
            $dailyReportDetails->total_hours = $project['total_hours'];
            $dailyReportDetails->save();
        }
        DB::commit();
        return redirect()->back()->with('success','Saved Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DailyReport  $dailyReport
     * @return \Illuminate\Http\Response
     */
    public function show(DailyReport $dailyReport)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DailyReport  $dailyReport
     * @return \Illuminate\Http\Response
     */
    public function edit(DailyReport $dailyReport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DailyReport  $dailyReport
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DailyReport $dailyReport)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DailyReport  $dailyReport
     * @return \Illuminate\Http\Response
     */
    public function destroy(DailyReport $dailyReport)
    {
        //
    }

    public function filterProjectWise(Request $request){
        $projectId = $request->projects;
        $selectedMonth = $request->selected_month;
        $fromDate = $selectedMonth."-1";
        $d = new DateTime($fromDate);
        $toDate = $d->format( 'Y-m-t' );
        // return Datatables::collection(User::all())->make(true);
        
        // $data = User::select('*')->get();
        DB::enableQueryLog();
        $data = DailyReportDetails::select("*")
                ->join('daily_reports','daily_report_details.daily_report_id','daily_reports.id')
                ->join('users','daily_reports.user_id','users.id')
                ->where('project_id',$projectId)
                ->whereRaw(DB::raw("DATE(entry_date) BETWEEN '$fromDate' AND '$toDate'"))
                ->groupBy('daily_reports.user_id')
                ->get();

        // dd(DB::getQueryLog());  
        return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function ($row) use($projectId,$selectedMonth) {
            $url = url("generateProjectWiseReport/".$row->user_id."/".$projectId."/".$selectedMonth);
            return "<a target='_blank' href=".$url." data-ids='".json_encode($row)."' class='btn btn-xs btn-success'>Go To&nbsp;&nbsp;<i class='fa fa-paper-plane'></i></a>";
        })
        ->rawColumns(['action'])
        ->make(true);
    }
}
