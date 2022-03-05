@extends('layouts.master')

@section('content')
    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="widget-content widget-content-area br-6">
                <div class="float-right">
                    <button class="btn btn-primary add">
                        <i class="las la-plus-circle"></i> Add Account
                    </button>
                </div>
                <h4 class="table-header mb-4">GL Accounts</h4>
                @if(session()->has('success'))
                    <div class="alert alert-success"> {{ session('success') }}</div>
                @endif
                @if(session()->has('error'))
                    <div class="alert alert-danger"> {{ session('error') }}</div>
                @endif

                <div class="table-responsive mb-4">
                    <table class="export-data table" style="width:100%">
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
                        @foreach($codes as $code)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $code->prefix }}</td>
                                <td>{{ $code->code }}</td>
                                <td>{{ $code->description }}</td>
                                <td class="text-right">
                                    <a href="#" title="Edit" class="font-20 text-primary edit"
                                       id="{{ $code->id }}"
                                       prefix="{{ $code->prefix }}"
                                       code="{{ $code->code }}"
                                       description="{{ $code->description }}"
                                    ><i class="las la-edit"></i></a>
                                    <a href="#" title="Delete" class="font-20 text-danger warning delete"
                                       id="{{ $code->id }}"><i class="las la-trash"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>

    </div>

@endSection

@section('modals')
    <div id="addEditAccountModal" class="modal animated {{ modalAnimation() }}" role="dialog">
        <div class="modal-dialog {{ modalClasses() }}">
            <!-- Modal content-->
            <div class="modal-content {{ modalPadding() }}">
                <div class="modal-header">
                    <h5 class="modal-title">Add/Edit Account</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addEditAccountForm" method="post" action="{{ route('vehicles.location.store') }}">
                        @csrf
                        <input type="hidden" value="" name="location_id" id="location-id"/>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" class="form-control"
                                           placeholder="Location">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancel</button>
                    <button type="button" class="btn btn-primary saveAccount">Save</button>
                </div>
            </div>
        </div>
    </div>

    <form action="" method="post" id="deleteAccountForm">
        @csrf
        {{ method_field('DELETE') }}
    </form>
@endsection

@section('css')

@endsection

@section('js')
    <script>
        $(document).ready(function () {
            $('body').on('click', '.edit, .add', function () {
                let account_id = $(this).attr('id')
                let prefix = $(this).attr('prefix')
                let code = $(this).attr('code')
                let description = $(this).attr('description')
                if (account_id) {
                    $('#account_id').val(account_id)
                    $('#prefix').val(prefix)
                    $('#code').val(code)
                    $('#description').val(description)
                } else {
                    $('#account_id').val("")
                    $('#prefix').val("")
                    $('#code').val("")
                    $('#description').val("")
                }

                $('#addEditAccountModal').modal();
                $('.btnSave').click(function () {
                    $('#addEditAccountForm').submit();
                })
            });

            $('.saveAccount').click(function () {
                $('#addEditAccountForm').submit();
            })



            $('.widget-content .warning.delete').on('click', function () {
                let location_id = $(this).attr('id');
                let url = "{{ route('vehicles.location.destroy',':id') }}"
                url = url.replace(':id', location_id);
                $('#deleteAccountForm').attr('action', url)
                swal({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Confirm',
                    confirmButtonClass: 'btn-danger',
                    padding: '2em'
                }).then(function (result) {
                    if (result.value) {
                        $('#deleteAccountForm').submit();
                    } else {
                        swal(
                            'You cancelled!',
                            'Your record is safe now.',
                            'error',
                        )
                    }
                })
            })


        });


    </script>
@endsection
