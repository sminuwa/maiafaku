@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header ">

                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="card-title">Manage Account Ledger</h5>
                        </div>
                        <div class="col-md-6 text-right" >
                            <a href="javascript:history.back();" class="btn btn-warning btn-sm">
                                <span class="fa fa-close"></span> Close
                            </a>
                            <a href="#" class="btn btn-success btn-sm btn-flat add-ledger-btn">
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
                            <th>Code</th>
                            <th>GCCA</th>
                            <th>Description</th>
                            <th class="no-content"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($ledgers as $ledger)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $ledger->code }}</td>
                                <td>{{ $ledger->gcca }}</td>
                                <td>{{ $ledger->description }}</td>
                                <td class="text-right">
                                    <a href="#" title="Edit" class="btn btn-outline-success btn-sm cursor-pointer edit"
                                       id="{{ $ledger->id }}"
                                       code="{{ $ledger->code }}"
                                       gcca="{{ $ledger->gcca }}"
                                       description="{{ $ledger->description }}"
                                    ><i class="las la-edit"></i>Edit</a>
                                    <a href="#" title="Delete" class="btn btn-outline-danger btn-sm cursor-pointer delete"
                                       id="{{ $ledger->id }}"><i class="las la-trash">Delete</i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>

                    </table>

                </div>
            </div>

        </div>
    </div>

    <div class="modal fade" id="add-ledger-modal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Manage Account Ledger</h4>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('accounts.ledger.store') }}">
                        @csrf
                        <input type="hidden" value="" name="ledger_id" id="ledger_id"/>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="gcca">GCCA</label>
                                    <select type="text" name="gcca" id="gcca" class="form-control">
                                        @php $gccas = \App\Models\AccountGcca::orderBy('description', 'asc')->get() @endphp
                                        @foreach($gccas as $gcca)
                                            <option value="{{ $gcca->code }}">{{ $gcca->description }} ({{$gcca->code}})</option>
                                        @endforeach
                                    </select>
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
    <div class="modal fade" id="delete-ledger-modal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Are you sure you want to delete?</h4>
                </div>
                <div class="modal-body">
                    <form class="delete-ledger-form" method="post" action="">
                        @csrf
                        {{ method_field('DELETE') }}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group text-center">
                                    <button type="button" class="btn btn-default btn-sm waves-effect" data-dismiss="modal">Cancel</button>
                                    <button class="btn btn-danger btn-sm">Yes, Delete!</button>
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
            $(".add-ledger-btn, .edit").on("click",function (e) {
                let ledger_id = $(this).attr('id')
                let code = $(this).attr('code')
                let gcca = $(this).attr('gcca')
                let description = $(this).attr('description')
                if(ledger_id){
                    $("#ledger_id").val(ledger_id);
                    $("#code").val(code);
                    $("#gcca").val(gcca);
                    $("#description").val(description);
                }else{
                    $("#ledger_id").val('');
                    $("#code").val('');
                    $("#gcca").val('');
                    $("#description").val('');
                }

                $("#add-ledger-modal").modal();
            });
            $('#table_id').DataTable();

            $('.delete').on('click', function(){
                let ledger_id = $(this).attr('id')
                let url = "{{ route('accounts.ledger.destroy', ':id') }}"
                url = url.replace(':id', ledger_id);
                $('.delete-ledger-form').attr('action', url)
                $("#delete-ledger-modal").modal();
            })
        });
    </script>
@endpush
