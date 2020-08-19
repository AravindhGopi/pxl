@extends('layouts.app')
@section('content')
<?php

use App\User;
use App\Projects;
use App\DailyReport;
use App\DailyReportDetails;
use Illuminate\Support\Facades\DB;

$userId = request()->route()->parameters['user'];
$projectId = request()->route()->parameters['project'];
$selectedMonth = request()->route()->parameters['selected_month'];

$fromDate = $selectedMonth . "-1";
$d = new DateTime($fromDate);
$toDate = $d->format('Y-m-t');
$month = strtotime($fromDate);
$end = strtotime($toDate);

$user = User::find($userId);
$project = Projects::find($projectId);
// dd($user);
?>
<div class="container">
    <!-- <div class="row justify-content-center">
        @include('layouts.alert')
    </div> -->
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class='text-center'><b>Resource Time Sheet</b></div>
            <hr>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2">
            <b>Resource Name</b>
        </div>
        <div class="col-md-1">
            {{$user->resource_name}}
        </div>
        <div class="offset-md-6 col-md-2">
        <b>Vendor Partner Name</b>
        </div>
        <div class="col-md-1">
            PXL
        </div>
    </div>
    <div class="row">
        <div class="col-md-2">
        <b>User Id</b>
        </div>
        <div class="col-md-1">
            {{$user->parexel_user_id}}
        </div>
        <div class="offset-md-6 col-md-2">
        <b>Contract No</b>
        </div>
        <div class="col-md-1">
            -
        </div>
    </div>
    <div class="row">
        <div class="col-md-2">
        <b>Level</b>
        </div>
        <div class="col-md-1">
            {{$user->level}}
        </div>
        <div class="offset-md-6 col-md-2">
        <b>Project Name</b>
        </div>
        <div class="col-md-1">
            {{$project->project_name}}
        </div>
    </div>
    <div class="row">
        <div class="col-md-2">
        <b> Month &amp; Year</b>
        </div>
        <div class="col-md-1">
            {{$selectedMonth}}
        </div>
    </div>
    <hr>
    <div class="row justify-content-center">
        <div class="col-md-12">
        <?php
            $table = "<table class='table table-bordered'>".
                "<thead>
                    <tr>
                        <th>Day</th>
                        <th>Number of hours Worked</th>
                        <th>Project Specific Training Hours</th>
                        <th>Partnership Specific Training Hours</th>
                        <th>Vendor General Trainings</th>
                        <th>Overtime if any, as per contract terms (Week days)</th>
                        <th>Worked on Leave(s)/Holiday(s)</th>
                        <th>Idle Hour(s)</th>
                        <th>Comments/Justification</th>
                        <th>Total hours</th>
                    </tr>
                </thead>
                <tbody>";

                    
                    // $resultArray = array();
                    $totalHrs = array();
                    while ($month <= $end) {
                        $table .= "<tr>";
                        //  dd($res[0]->selectedDate);
                        $res = DailyReport::select('*', DB::raw("DATE(entry_date) as selectedDate"))
                            ->join('daily_report_details', 'daily_reports.id', 'daily_report_details.daily_report_id')
                            ->where(['user_id' => $userId, 'project_id' => $projectId])
                            ->whereDate("entry_date", date('Y-m-d', $month))
                            // ->whereRaw("DATE(entry_date) BETWEEN '".$fromDate."' AND '".$toDate."'")
                            ->groupBy(DB::raw("DATE(entry_date)"))
                            ->get();
                        if ($res->count() > 0) {
                            // echo "<br>".date('d/m/Y', $month);
                            $table .= "</td>";
                            // $resultArray[] = $res;
                            $table .= "<td>" . date('d/m/Y', strtotime($res[0]->selectedDate)) . "</td>";
                            $table .= "<td>" . numericNullCheck($res[0]->hours_worked) . "</td>";
                            $table .= "<td>" . numericNullCheck($res[0]->project_specific_training) . "</td>";
                            $table .= "<td>" . numericNullCheck($res[0]->partnership_specific_training) . "</td>";
                            $table .= "<td>" . numericNullCheck($res[0]->vendor_general_trainings) . "</td>";
                            $table .= "<td>" . numericNullCheck($res[0]->over_time) . "</td>";
                            $table .= "<td>" . leaveCheck($res[0]) . "</td>";
                            $table .= "<td>" . numericNullCheck($res[0]->idle_hours) . "</td>";
                            $table .= "<td>" . stringNullCheck($res[0]->comments) . "</td>";
                            $table .= "<td>" . numericNullCheck($res[0]->total_hours) . "</td>";

                            $totalHrs[] = ($res[0]->total_hours != "") ? $res[0]->total_hours : 0;
                        }else{
                            $table .= "<td>".date('d/m/Y', $month)."</td>";
                            $table .= "<td>-</td>";
                            $table .= "<td>-</td>";
                            $table .= "<td>-</td>";
                            $table .= "<td>-</td>";
                            $table .= "<td>-</td>";
                            $table .= "<td>-</td>";
                            $table .= "<td>-</td>";
                            $table .= "<td>No Entry</td>";
                            $table .= "<td>-</td>";
                        }

                        $table .= "</tr>";
                        $month = strtotime("+1 day", $month);
                    }
                $table .= "<tr><td colspan=9 style='text-align:right  '><b>Total<b></td><td>".array_sum($totalHrs)."</td></tr>";
                $table .= "</tbody></table>";            

                echo $table;

                function numericNullCheck($value)
                    {
                        return ($value == "") ? "0" : $value;
                    }
                    function stringNullCheck($value)
                    {
                        return ($value == "") ? "-" : $value;
                    }
                    function leaveCheck($value)
                    {
                        $result = "-";
                        if ($value->is_leave) {
                            if ($value->leave_type == "full_day") {
                                $result = 'Full Day Leave';
                            } else if ($value->leave_type == "half_day") {
                                if ($value->leave_on == "morning") {
                                    $result = 'Morning Leave';
                                } else {
                                    $result = 'Evening Leave';
                                }
                            }
                        }
                        return $result;
                    }
            ?>
        </div>
    </div>

</div>

<style>
    table,
    th,
    td {
        border: 2px solid #ccc;
    }
</style>
<script>
    // userId = <?php ?>
    // alert(userId)
</script>
@endsection