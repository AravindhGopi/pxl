@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @include('layouts.alert')
    </div>
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">
                    <h5>{{ __('Add Project') }}</h5>
                </div>
                <div class="card-body">
                    @if($data['type'] == "update")
                    <form method="POST" action='{{ route("projects_$data[type]",$data["project"]->id) }}'>
                        @method('PUT')
                    @else
                    <form method="POST" action='{{ route("projects_$data[type]") }}'>
                    @endif
                        @csrf
                        <div class="form-group row">
                            <label for="project_name" class="col-md-4 col-form-label text-md-right">{{ __('Project Name') }}</label>

                            <div class="col-md-6">
                                <input id="project_name" type="text" class="form-control @error('project_name') is-invalid @enderror" name="project_name" value="{{ ($data['type'] == 'update') ? $data['project']->project_name : old('project_name') }}" required autocomplete="project_name" autofocus>

                                @error('project_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ ($data['type'] == 'update') ? __('Save Project') :__('Add Project') }}
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
                    <h5>{{ __('Project List') }}</h5>
                </div>
                <ul class="list-group">
                    @foreach($data['projects'] as $project)
                    <li class="list-group-item"><a href="{{route('projects_edit',$project->id)}}">{{$project->project_name}}</a>
                        <button onclick="deleteProject('{{$project->id}}')" class="float-right btn btn-danger fa fa-trash"></button></li>
                    @endforeach
                    @if(count($data['projects']) == 0)
                    <li class="list-group-item">No records</li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>
<form id="delete_form" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endsection

<script>
    function deleteProject(id) {
        debugger;
        if (confirm("Are you sure you want to delete?")) {
            $form = $("#delete_form");
            $form.attr("action", "/projects/" + id)
            $form.submit();
        }
    }
</script>