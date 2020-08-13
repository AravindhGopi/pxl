<?php

namespace App\Http\Controllers;

use App\HolidayCalendar;
use DateTime;
use Illuminate\Http\Request;

class HolidayCalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return view('')
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $holidayCalendar = HolidayCalendar::all();
        return view('holiday_calendar.holiday_calendar')->with('data',$holidayCalendar);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $myDateTime = DateTime::createFromFormat('d/m/Y', $request->holiday_at);
        $newDateString = $myDateTime->format('Y-m-d');
        $holidayCalendar = new HolidayCalendar();
        $holidayCalendar->holiday_at = $newDateString;
        $holidayCalendar->save();

        return redirect()->back()->with("status","Holiday Calendar Updated");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\HolidayCalendar  $holidayCalendar
     * @return \Illuminate\Http\Response
     */
    public function show(HolidayCalendar $holidayCalendar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\HolidayCalendar  $holidayCalendar
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $holidayCalendar = HolidayCalendar::find($id);
        return view('holiday_calendar.edit', compact('holidayCalendar'));        

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\HolidayCalendar  $holidayCalendar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $myDate = DateTime::createFromFormat('d/m/Y',$request->holiday_at);
        $newDateString = $myDate->format('Y-m-d');
        $holidayCalendar = HolidayCalendar::find($id);
        $holidayCalendar->holiday_at = $newDateString;
        $holidayCalendar->save();

        $holidayCalendar = HolidayCalendar::all();
        return view('holiday_calendar.holiday_calendar')->with('data',$holidayCalendar);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\HolidayCalendar  $holidayCalendar
     * @return \Illuminate\Http\Response
     */
    public function destroy(HolidayCalendar $holidayCalendar)
    {
        HolidayCalendar::destroy($holidayCalendar->id);
        return redirect()->back()->with("status","Holiday removed");

    }
}
