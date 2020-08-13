@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @include('layouts.alert')
    </div>
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">{{ __('Add Employees') }}</div>

                <div class="card-body">
                    @if($data['type'] == "update")
                    <form method="POST" action='{{ route("users_$data[type]",$data["user"]->id) }}'>
                        @method('PUT')
                        @else
                        <form method="POST" action='{{ route("users_$data[type]") }}'>
                            @endif
                            @csrf
                            <div class="form-group row">
                                <label for="resource_name" class="col-md-4 col-form-label text-md-right">{{ __('Resource Name') }}</label>

                                <div class="col-md-6">
                                    <input id="resource_name" type="text" class="form-control @error('resource_name') is-invalid @enderror" name="resource_name" value="{{ ($data['type'] == 'update') ? $data['user']->resource_name : old('resource_name') }}" required autocomplete="resource_name" autofocus>

                                    @error('resource_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="parexel_user_id" class="col-md-4 col-form-label text-md-right">{{ __('Parexel Id') }}</label>

                                <div class="col-md-6">
                                    <input id="parexel_user_id" type="text" class="form-control @error('parexel_user_id') is-invalid @enderror" name="parexel_user_id" value="{{ ($data['type'] == 'update') ? $data['user']->parexel_user_id : old('parexel_user_id') }}" required autocomplete="parexel_user_id" autofocus>

                                    @error('parexel_user_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ ($data['type'] == 'update') ? $data['user']->email : old('email') }}" required autocomplete="email">

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="mobile" class="col-md-4 col-form-label text-md-right">{{ __('Mobile') }}</label>

                                <div class="col-md-6">
                                    <input id="mobile" type="text" class="form-control @error('mobile') is-invalid @enderror" name="mobile" value="{{ ($data['type'] == 'update') ? $data['user']->mobile : old('mobile') }}" required autocomplete="mobile" autofocus>

                                    @error('mobile')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="level" class="col-md-4 col-form-label text-md-right">{{ __('Level') }}</label>

                                <div class="col-md-6">
                                    <div class="form-check form-check-inline">
                                        <input type="radio" id="radio_junior" class="inline @error('level') is-invalid @enderror" name="level" value="junior" required autocomplete="level" autofocus {{($data['type'] == 'update' && $data['user']->level == 'junior')?'checked':''}}>
                                        <label class="form-check-label" for="radio_junior">&nbsp;Junior</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" id="radio_senior" class="inline  @error('level') is-invalid @enderror" name="level" value="senior" required autocomplete="level" autofocus {{($data['type'] == 'update' && $data['user']->level == 'senior')?'checked':''}}>
                                        <label class="form-check-label" for="radio_senior">&nbsp;Senior</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" id="radio_associate" class="@error('level') is-invalid @enderror" name="level" value="associate" required autocomplete="level" autofocus {{($data['type'] == 'update' && $data['user']->level == 'associate')?'checked':''}}>
                                        <label class="form-check-label" for="radio_associate">&nbsp;Associate</label>
                                    </div>

                                    @error('level')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            @if(!($data['type'] == "update"))
                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>
                            @endif
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ ($data['type'] == 'update') ? __('Update') :__('Add') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5>{{ __('Employee List') }}</h5>
                </div>
                <ul class="list-group">
                    @foreach($data['users'] as $value)
                    <li class="list-group-item"><a href="{{route('users_edit',$value->id)}}">{{$value->resource_name}}</a>
                        <!-- <button onclick="deletevalue('{{--$employee->id--}}')" class="float-right btn btn-danger fa fa-trash"></button></li> -->
                    @endforeach
                    @if(count($data['users']) == 0)
                    <li class="list-group-item">No records</li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection