@extends('layouts.app')

@section('content')
<div class='container'>
    <div class="row justify-content-center">
        @include('layouts.alert')
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Daily Entry') }}</div>
                <div class="card-body">
                    <form method="POST" action='{{ action("DailyReportController@store") }}'>
                        @csrf
                        <div class="form-group row">
                            <label for="entry_date" class="col-md-4 col-form-label text-md-right">{{ __('Date') }}</label>

                            <div class="col-md-6">
                                <input id="entry_date" type="text" autocomplete="off" class=" datepicker form-control @error('entry_date') is-invalid @enderror" name="entry_date" value="{{old('entry_date')}}" required>

                                @error('entry_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="is_leave" class="col-md-4 col-form-label text-md-right">{{ __('Is Leave?') }}</label>

                            <div class="col-md-6">
                                <div class="form-check form-check-inline">
                                    <input type="radio" id="radio_leave_yes" onclick="toggleLeaveType(this.value)" class="inline @error('is_leave') is-invalid @enderror" name="is_leave" value="yes" autocomplete="is_leave">
                                    <label class="form-check-label" for="radio_leave_yes">&nbsp;Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input type="radio" id="radio_leave_no" onclick="toggleLeaveType(this.value)" class="inline  @error('is_leave') is-invalid @enderror" name="is_leave" value="no"  autocomplete="is_leave">
                                    <label class="form-check-label" for="radio_leave_no">&nbsp;No</label>
                                </div>

                                @error('is_leave')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row" id="leave_type_div" style="display:none">
                            <label for="leave_type" class="col-md-4 col-form-label text-md-right">{{ __('Leave Type') }}</label>

                            <div class="col-md-6">
                                <div class="form-check form-check-inline">
                                    <input type="radio" id="radio_half_day" onclick="toggleLeaveOn(this.value)" class="inline @error('leave_type') is-invalid @enderror" name="leave_type" value="half_day"  autocomplete="leave_type">
                                    <label class="form-check-label" for="radio_half_day">&nbsp;Half Day</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input type="radio" id="radio_full_day" onclick="toggleLeaveOn(this.value)" class="inline  @error('leave_type') is-invalid @enderror" name="leave_type" value="full_day"  autocomplete="leave_type">
                                    <label class="form-check-label" for="radio_full_day">&nbsp;Full Day</label>
                                </div>

                                @error('leave_type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row" id="leave_on_div" style="display:none">
                            <label for="leave_on" class="col-md-4 col-form-label text-md-right">{{ __('Leave Part') }}</label>

                            <div class="col-md-6">
                                <div class="form-check form-check-inline">
                                    <input type="radio" id="radio_leave_on_morning" class="inline @error('leave_on') is-invalid @enderror" name="leave_on" value="morning"  autocomplete="leave_on">
                                    <label class="form-check-label" for="radio_leave_on_morning">&nbsp;Morning</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input type="radio" id="radio_leave_on_evening" class="inline  @error('leave_on') is-invalid @enderror" name="leave_on" value="evening"  autocomplete="leave_on">
                                    <label class="form-check-label" for="radio_leave_on_evening">&nbsp;Evening</label>
                                </div>

                                @error('leave_on')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div style="display:none" id="daily_report_details">
                            <div class="form-group row">
                                <label for="projects" class="col-md-4 col-form-label text-md-right">{{ __('Projects') }}</label>

                                <div class="col-md-6">
                                    <select class="form-control projects" name="projects[project][]"></select>
                                    @error('projects')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="hours_worked" class="col-md-4 col-form-label text-md-right">{{ __('Number Of Hours Worked') }}</label>

                                <div class="col-md-6">
                                    <input id="hours_worked" type="number" min="" class="form-control @error('hours_worked') is-invalid @enderror" name="projects[hours_worked][]" value="{{ old('hours_worked') }}"  autocomplete="hours_worked" autofocus>

                                    @error('hours_worked')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="project_specific_training" class="col-md-4 col-form-label text-md-right">{{ __('Project Specific Training Hours') }}</label>

                                <div class="col-md-6">
                                    <input id="project_specific_training" type="number" class="form-control @error('project_specific_training') is-invalid @enderror" name="projects[project_specific_training][]" value="{{ old('project_specific_training') }}"  autocomplete="project_specific_training" autofocus>

                                    @error('project_specific_training')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="partnership_specific_training" class="col-md-4 col-form-label text-md-right">{{ __('Partnership Specific Training Hours') }}</label>

                                <div class="col-md-6">
                                    <input id="partnership_specific_training" type="number" class="form-control @error('partnership_specific_training') is-invalid @enderror" name="projects[partnership_specific_training][]" value="{{ old('partnership_specific_training') }}"  autocomplete="partnership_specific_training" autofocus>

                                    @error('partnership_specific_training')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="vendor_general_trainings" class="col-md-4 col-form-label text-md-right">{{ __('Vendor General Training Hours') }}</label>

                                <div class="col-md-6">
                                    <input id="vendor_general_trainings" type="number" class="form-control @error('vendor_general_trainings') is-invalid @enderror" name="projects[vendor_general_trainings][]" value="{{ old('vendor_general_trainings') }}"  autocomplete="vendor_general_trainings" autofocus>

                                    @error('vendor_general_trainings')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="over_time" class="col-md-4 col-form-label text-md-right">{{ __('Overtime Hours') }}</label>

                                <div class="col-md-6">
                                    <input id="over_time" type="number" class="form-control @error('over_time') is-invalid @enderror" name="projects[over_time][]" value="{{ old('over_time') }}"  autocomplete="over_time" autofocus>

                                    @error('over_time')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="idle_hours" class="col-md-4 col-form-label text-md-right">{{ __('Idle Hours') }}</label>

                                <div class="col-md-6">
                                    <input id="idle_hours" type="number" class="form-control @error('idle_hours') is-invalid @enderror" name="projects[idle_hours][]" value="{{ old('idle_hours') }}"  autocomplete="idle_hours" autofocus>

                                    @error('idle_hours')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="comments" class="col-md-4 col-form-label text-md-right">{{ __('Comments') }}</label>

                                <div class="col-md-6">
                                    <textarea name="projects[comments][]" class="form-control @error('comments') is-invalid @enderror"></textarea>

                                    @error('idle_hours')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="total_hours" class="col-md-4 col-form-label text-md-right">{{ __('Total Hours') }}</label>

                                <div class="col-md-6">
                                    <input id="total_hours" type="number" readonly class="form-control @error('total_hours') is-invalid @enderror" name="projects[total_hours][]" value="{{ old('total_hours') }}"  autocomplete="total_hours" autofocus>

                                    @error('total_hours')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4">
                                    <button type="button" class="btn btn-primary" onclick="addMore()">
                                        <span class="fa fa-plus"></span>&nbsp;Add More
                                    </button>
                                </div>
                            </div>
                            <div id="moreProjectetailsDiv"></div>
                        </div>
                        
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-success">
                                    {{__('Save')}}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
<script>
    var totalHours = 0;
    $(function() {
        
        $("#hours_worked,#project_specific_training,#partnership_specific_training,#vendor_general_trainings,#over_time,#idle_hours").change(function(){
            totalHours += parseInt($(this).val());
            $("#total_hours").val(totalHours);
        });

        $('.datepicker').datepicker({
            format: 'dd/mm/yyyy',
            autoclose: true 
        });
        getAllProjects();
    })

    function getAllProjects(){
        // return new Promise(resolve => {
        var $selectElement = $(".projects");
        var selectHTML = "";
        axios.get("/getAllProjects").then(response => {
            for (var key in response.data) {
                var row = response.data[key];
                selectHTML += "<option value=" + row.id + ">" + row.project_name + "</option>";
            }
            $selectElement.html(selectHTML);
            // resolve(1)
        }).catch(error => {
            console.log(error);
        })
    // })
    }

    function toggleLeaveType(value) {
        if (value == "yes") {
            $("#leave_type_div").show();
        } else {
            $("#leave_type_div").hide();
            $("#leave_on_div").hide();
            unCheckAll("leave_type");
            unCheckAll("leave_on");
            $("#daily_report_details").show();
        }
    }

    function toggleLeaveOn(value) {
        if (value == "half_day") {
            $("#leave_on_div").show();
            $("#daily_report_details").show();
        } else {
            $("#daily_report_details").hide();
            unCheckAll("leave_on");
            $("#leave_on_div").hide();
        }
    }

    function unCheckAll(name) {
        var nameObj = document.getElementsByName(name);
        for (var i = 0; i < nameObj.length; i++) {
            nameObj[i].checked = false;
        }
    }

    function addMore() {
        var strHTML = "<div><div class='form-group row'>"+
                        "<label for='projects' class='col-md-4 col-form-label text-md-right'>{{ __('Projects') }}</label>"+
                            "<div class='col-md-6'>"+
                                "<select class='form-control projects' name=projects[project][]></select>"+
                                "@error('projects')"+
                                "<span class='invalid-feedback' role='alert'>"+
                                    "<strong>{{ $message }}</strong>"+
                                "</span>"+
                                "@enderror"+
                            "</div>"+
                        "</div>"+
                        "<div class='form-group row'>"+
                            "<label for='hours_worked' class='col-md-4 col-form-label text-md-right'>{{ __('Number Of Hours Worked') }}</label>"+
                            "<div class='col-md-6'>"+
                                "<input id='hours_worked' type='text' class='form-control @error('hours_worked') is-invalid @enderror' name=projects[hours_worked][] value='{{ old('hours_worked') }}'  autocomplete='hours_worked' autofocus>"+
                                "@error('hours_worked')"+
                                "<span class='invalid-feedback' role='alert'>"+
                                    "<strong>{{ $message }}</strong>"+
                                "</span>"+
                                "@enderror"+
                            "</div>"+
                        "</div>"+
                        "<div class='form-group row'>"+
                            "<label for='project_specific_training' class='col-md-4 col-form-label text-md-right'>{{ __('Project Specific Training Hours') }}</label>"+
                            "<div class='col-md-6'>"+
                                "<input id='project_specific_training' type='text' class='form-control @error('project_specific_training') is-invalid @enderror' name=projects[project_specific_training][] value='{{ old('project_specific_training') }}'  autocomplete='project_specific_training' autofocus>"+
                                "@error('project_specific_training')"+
                                "<span class='invalid-feedback' role='alert'>"+
                                    "<strong>{{ $message }}</strong>"+
                                "</span>"+
                                "@enderror"+
                            "</div>"+
                        "</div>"+
                        "<div class='form-group row'>"+
                            "<label for='partnership_specific_training' class='col-md-4 col-form-label text-md-right'>{{ __('Partnership Specific Training Hours') }}</label>"+
                            "<div class='col-md-6'>"+
                                "<input id='partnership_specific_training' type='text' class='form-control @error('partnership_specific_training') is-invalid @enderror' name=projects[partnership_specific_training][] value='{{ old('partnership_specific_training') }}'  autocomplete='partnership_specific_training' autofocus>"+
                                "@error('partnership_specific_training')"+
                                "<span class='invalid-feedback' role='alert'>"+
                                    "<strong>{{ $message }}</strong>"+
                                "</span>"+
                                "@enderror"+
                            "</div>"+
                        "</div>"+
                        "<div class='form-group row'>"+
                            "<label for='vendor_general_trainings' class='col-md-4 col-form-label text-md-right'>{{ __('Vendor General Training Hours') }}</label>"+
                            "<div class='col-md-6'>"+
                                "<input id='vendor_general_trainings' type='text' class='form-control @error('vendor_general_trainings') is-invalid @enderror' name=projects[vendor_general_trainings][] value='{{ old('vendor_general_trainings') }}'  autocomplete='vendor_general_trainings' autofocus>"+
                                "@error('vendor_general_trainings')"+
                                "<span class='invalid-feedback' role='alert'>"+
                                    "<strong>{{ $message }}</strong>"+
                                "</span>"+
                                "@enderror"+
                            "</div>"+
                        "</div>"+
                        "<div class='form-group row'>"+
                            "<label for='over_time' class='col-md-4 col-form-label text-md-right'>{{ __('Overtime Hours') }}</label>"+
                            "<div class='col-md-6'>"+
                                "<input id='over_time' type='text' class='form-control @error('over_time') is-invalid @enderror' name=projects[over_time][] value='{{ old('over_time') }}'  autocomplete='over_time' autofocus>"+
                                "@error('over_time')"+
                                "<span class='invalid-feedback' role='alert'>"+
                                    "<strong>{{ $message }}</strong>"+
                                "</span>"+
                                "@enderror"+
                            "</div>"+
                        "</div>"+
                        "<div class='form-group row'>"+
                            "<label for='idle_hours' class='col-md-4 col-form-label text-md-right'>{{ __('Idle Hours') }}</label>"+
                            "<div class='col-md-6'>"+
                                "<input id='idle_hours' type='text' class='form-control @error('idle_hours') is-invalid @enderror' name=projects[idle_hours][] value='{{ old('idle_hours') }}'  autocomplete='idle_hours' autofocus>"+
                                "@error('idle_hours')"+
                                "<span class='invalid-feedback' role='alert'>"+
                                    "<strong>{{ $message }}</strong>"+
                                "</span>"+
                                "@enderror"+
                            "</div>"+
                        "</div>"+
                        "<div class='form-group row'>"+
                            "<label for='comments' class='col-md-4 col-form-label text-md-right'>{{ __('Comments') }}</label>"+
                            "<div class='col-md-6'>"+
                                "<textarea name=projects[comments][] class='form-control @error('comments') is-invalid @enderror'></textarea>"+
                                "@error('idle_hours')"+
                                "<span class='invalid-feedback' role='alert'>"+
                                    "<strong>{{ $message }}</strong>"+
                                "</span>"+
                                "@enderror"+
                            "</div>"+
                        "</div>"+
                        "<div class='form-group row'>"+
                            "<label for='total_hours' class='col-md-4 col-form-label text-md-right'>{{ __('Total Hours') }}</label>"+
                            "<div class='col-md-6'>"+
                                "<input id='total_hours' type='text' readonly class='form-control @error('total_hours') is-invalid @enderror' name=projects[total_hours][] value='{{ old('total_hours') }}'  autocomplete='total_hours' autofocus>"+
                                "@error('total_hours')"+
                                "<span class='invalid-feedback' role='alert'>"+
                                    "<strong>{{ $message }}</strong>"+
                                "</span>"+
                                "@enderror"+
                            "</div>"+
                        "</div>"+
                        "<div class='form-group row'>"+
                            "<div class='col-md-6 offset-md-4'>"+
                                "<button type='button' class='btn btn-primary' onclick='addMore()'>"+
                                    "<span class='fa fa-plus'></span>&nbsp;Add More"+
                                "</button>&nbsp;&nbsp;"+
                                "<button type='button' class='btn btn-danger' onclick='remove(this)'>"+
                                        "<span class='fa fa-times'></span>&nbsp;Remove"+
                                    "</button>"+
                            "</div>"+
                        "</div></div>'";

                        $("#moreProjectetailsDiv").append(strHTML);
                        getAllProjects();
    }
    function remove(divObj){
        $(divObj).parent().parent().parent().remove();
    }
</script>
@endsection