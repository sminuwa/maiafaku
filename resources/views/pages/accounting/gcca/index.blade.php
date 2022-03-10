@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header ">

                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="card-title">Manage GCCA</h5>
                        </div>
                        <div class="col-md-6 text-right" >
                            <a href="javascript:history.back();" class="btn btn-warning btn-sm">
                                <span class="fa fa-close"></span> Close
                            </a>
                            <a href="#" class="btn btn-success btn-sm btn-flat add-gcca-btn">
                              <span class="btn-label">
                                <i class="nc-icon nc-paper"></i>
                              </span>
                                Create New
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body ">
                    @if(session()->has('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session()->has('error'))
                        <div class="alert alert-success">{{ session('error') }}</div>
                    @endif
                    <table class="table table-bordered table-striped" tag-type="datatable" style="font-size: 13px;">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Prefix</th>
                            <th>Code</th>
                            <th>Description</th>
                            <th class="no-content"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($gccas as $gcca)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $gcca->prefix }}</td>
                                <td>{{ $gcca->code }}</td>
                                <td>{{ $gcca->description }}</td>
                                <td class="text-right">
                                    <a href="#" title="Edit" class="btn btn-outline-success btn-sm cursor-pointer edit"
                                       id="{{ $gcca->id }}"
                                       prefix="{{ $gcca->prefix }}"
                                       code="{{ $gcca->code }}"
                                       description="{{ $gcca->description }}"
                                    ><i class="las la-edit"></i>Edit</a>
                                    <a href="#" title="Delete" class="btn btn-outline-danger btn-sm cursor-pointer delete"
                                       id="{{ $gcca->id }}"><i class="las la-trash">Delete</i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>

                    </table>

                </div>
            </div>

        </div>
    </div>

    <div class="modal fade" id="add-gcca-modal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Manage GCCA</h4>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('accounts.gccas.store') }}">
                        @csrf
                        <input type="hidden" value="" name="gcca_id" id="gcca_id"/>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="prefix">Prefix</label>
                                    <input type="text" name="prefix" id="prefix" class="form-control" placeholder="Prefix (e.g. A10">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="code">Code</label>
                                    <input type="text" name="code" id="code" class="form-control" placeholder="Code">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <input type="text" name="description" id="description" class="form-control" placeholder="Description">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group text-right">
                                    <button class="btn btn-info btn-sm">Save</button>
{{--                                    <button type="button" class="btn btn-default btn-sm waves-effect" data-dismiss="modal">Close</button>--}}
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
    <div class="modal fade" id="delete-gcca-modal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Manage GCCA</h4>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('accounts.gccas.destroy', 1) }}">
                        @csrf
                        <input type="hidden" value="" name="gcca_id" id="gcca_id"/>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="prefix">Prefix</label>
                                    <input type="text" name="prefix" id="prefix" class="form-control" placeholder="Prefix (e.g. A10">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="code">Code</label>
                                    <input type="text" name="code" id="code" class="form-control" placeholder="Code">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <input type="text" name="description" id="description" class="form-control" placeholder="Description">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endSection

@push('js')
    <script>
        $(document).ready(function(){
            $(".add-gcca-btn, .edit").on("click",function (e) {
                let gcca_id = $(this).attr('id')
                let prefix = $(this).attr('prefix')
                let code = $(this).attr('code')
                let description = $(this).attr('description')
                if(gcca_id){
                    $("#gcca_id").val(gcca_id);
                    $("#prefix").val(prefix);
                    $("#code").val(code);
                    $("#description").val(description);
                }else{
                    $("#gcca_id").val('');
                    $("#prefix").val('');
                    $("#code").val('');
                    $("#description").val('');
                }

                $("#add-gcca-modal").modal();
            });
            $('#table_id').DataTable();
        });
    </script>
@endpush
