@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @include('layouts.alert')
    </div>
    <div class="row float-right">
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="container">
                <form action="{{url('projects_filter')}}" method="post">
                    @csrf
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Select Project</label>
                        <div class="col-sm-4">
                            <select class="form-control" id="projects" name="projects"></select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Select Date</label>
                        <div class="col-sm-4">
                            <input id="selected_month" type="text" class="datepicker form-control" name="selected_month" autocomplete="off">
                        </div>
                        <button class="btn btn-primary" type="button" onclick="filterProjects()">Filter</button>
                    </div>
                </form>
            </div>
            <div class="card">
                <div class="card-header">{{ __('Project Wise Report') }}</div>
                <div class="card-body">
                    <table class="table table-bordered project_report_dt">
                        <thead>
                            <tr>
                                <td>S. No</td>
                                <td>Resource Name</td>
                                <td>Action</td>
                            </tr>
                        </thead>
                        <!-- <tbody>
                            <tr>
                                <td>1</td>
                                <td>123</td>
                                <td>aadf</td>
                            </tr>
                        </tbody> -->
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"/> -->
<link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<style>
    .btn-success {
        color: #fff !important;
    }
</style>
<script>
    $(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('.datepicker').datepicker({
            format: "yyyy-mm",
            viewMode: "months",
            minViewMode: "months",
            autoclose: true
        });
        getAllProjects();
    })
    var dataTable = "";
    function filterProjects() {
        dataTable = $('.project_report_dt').DataTable({
            "bDestroy": true,
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ url('projects_filter') }}",
                type: "POST",
                "data": function(d) {
                    d.projects = $('#projects').val();
                    d.selected_month = $('#selected_month').val();
                }
            },
            columns: [
                //   {data: 'id', name: 'id', 'visible': false},
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'resource_name',
                    name: 'resource_name'
                },
                {
                    data: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });
    }

    function getAllProjects() {
        // return new Promise(resolve => {
        var $selectElement = $("#projects");
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
</script>
@endsection