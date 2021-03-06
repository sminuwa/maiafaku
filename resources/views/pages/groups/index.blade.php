@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="card-title">Groups</h5>
                        </div>
                        <div class="col-md-6 text-right" >
                            <a href="javascript:history.back();" class="btn btn-warning btn-sm">
                                <span class="fa fa-close"></span> Close
                            </a>
                            <a href="#" class="btn btn-success btn-sm btn-flat"  id="add-staff-btn">
                              <span class="btn-label">
                                <i class="nc-icon nc-paper"></i>
                              </span>
                                Create New
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table_id" width="100%" class="table table-bordered table-striped" tag-type="datatable" style="font-size: 13px;color:#5476AA !important;">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Group Name</th>
                                <th class="text-right" width="300"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($records as $record)
                                <tr>
                                    <td> {{$loop->index+1 }} </td>
                                    <td>{{ $record->name }}</td>
                                    <td class="text-right" >
                                        <a class="btn btn-outline-secondary btn-sm editP" href="#"  branch="{{$record->name}}" pid="{{$record->id}}">
                                            Edit
                                        </a>
                                        <a class="btn btn-outline-secondary btn-sm" href="{{ route('group.single',[$record->id]) }}" >
                                            View
                                        </a>
                                        &nbsp
                                        <form onsubmit="return confirm('Are you sure you want to delete?')"
                                              action="{{ route('group.destroy',[$record->id]) }}"
                                              method="post"
                                              style="display: inline">
                                            {{csrf_field()}}
                                            <button type="submit" class="btn btn-outline-danger btn-sm cursor-pointer"   {{$record->hasMembers()?"disabled":''}}>
                                                {{$record->hasMembers()?"Cannot ":' '}} Delete <i class="text-danger fa fa-remove"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                            @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="add-staff-modal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Manage Group</h4>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('group.store') }}">
                        @csrf
                        <input type="hidden" name="p_id" id="p_id">
                        <div class="row">
                            <div class="col-md-12 pr-1">
                                <div class="form-group">
                                    <label>Group Name</label>
                                    <input type="text" class="form-control" placeholder="Site Name"
                                           value=""
                                           name="name" id="branch">
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button class="btn btn-info btn-sm">Save</button>
                                    <button type="button" class="btn btn-default btn-sm waves-effect" data-dismiss="modal">Close</button>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection


@push('js')
    <script>
        $(document).ready(function(){
            $("#add-staff-btn, .editP").on("click",function (e) {
                if($(this).attr('branch')){
                    $("#p_id").val($(this).attr('pid'));
                    $("#branch").val($(this).attr('branch'));
                }else{
                    $("#p_id").val('');
                    $("#branch").val('');
                }

                $("#add-staff-modal").modal();
            });
            $('#table_id').DataTable();
        });
    </script>
@endpush
