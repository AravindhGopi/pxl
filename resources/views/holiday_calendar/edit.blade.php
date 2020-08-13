@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @include('layouts.alert')
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Holiday Calendar') }}</div>
                <div class="card-body">
                    <form method="POST" action='{{ action("HolidayCalendarController@update",$holidayCalendar->id) }}'>
                        @method('PUT')
                        @csrf
                        <div class="form-group row">
                            <label for="holiday_at" class="col-md-4 col-form-label text-md-right">{{ __('Date') }}</label>

                            <div class="col-md-6">
                                <input id="holiday_at" type="text" class=" datepicker form-control @error('holiday_at') is-invalid @enderror" name="holiday_at" value="{{\Carbon\Carbon::parse($holidayCalendar->holiday_at)->format('d/m/Y')}}" required autocomplete="holiday_at">

                                @error('holiday_at')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{__('Update')}}
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
    $(function() {
        $('.datepicker').datepicker({
            format: 'dd/mm/yyyy'
        });


    })
</script>
@endsection