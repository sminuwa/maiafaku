@extends('layouts.master')

@section('content')
    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="widget-content widget-content-area br-6">
                {{--<div class="float-right">
                    <button class="btn btn-primary add">
                        <i class="las la-plus-circle"></i> Enroll staff
                    </button>
                </div>--}}
                <h4 class="table-header mb-4">Payslip page for <span class="text-danger">{{ $user->fullName() }}</span></h4>
                @if(session()->has('success'))
                    <div class="alert alert-success"> {{ session('success') }}</div>
                @endif
                @if(session()->has('error'))
                    <div class="alert alert-danger"> {{ session('error') }}</div>
                @endif

                <div class="widget-content shadow-none widget-content-area normal-tabs-vertical">
                    <div class="row mb-4 mt-3">
                        <div class="col-sm-3 col-12 pr-0">
                            <div class="nav flex-column nav-pills mb-sm-0 mb-3 text-center mx-auto" role="tablist" aria-orientation="vertical">
                                @foreach($user->payslipYear() as $year)
                                    <a class="nav-link @if($loop->first) active @endif" data-toggle="pill" href="#tab{{ $year }}" role="tab" aria-controls="v-border-pills-home" aria-selected="true"> {{ $year }} </a>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-sm-9 col-12 pl-0">
                            <div class="tab-content" id="v-border-pills-tabContent">
                                @foreach($user->payslipYear() as $year)
                                <div class="tab-pane fade @if($loop->first) show active @endif" id="tab{{ $year }}" role="tabpanel" aria-labelledby="v-border-pills-home-tab">
                                    <ul class="list-group">
                                        @foreach($user->payslipMonth($year) as $month)
                                        <li class="list-group-item">
                                            <a href="#{{ $month->payroll_user_id }}"><i class="las la-book mr-3 font-17"></i>{{ $month->date->format('F') }}</a>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>

    </div>

@endSection

@section('modals')
    <div id="addEditLocationModal" class="modal animated {{ modalAnimation() }}" role="dialog">
        <div class="modal-dialog {{ modalClasses() }}">
            <!-- Modal content-->
            <div class="modal-content {{ modalPadding() }}">
                <div class="modal-header">
                    <h5 class="modal-title">Add/Edit Location</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addEditLocationForm" method="post" action="{{ route('vehicles.location.store') }}">
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
                        <div class="form-group">
                            <div class="ripple-checkbox-primary">
                                <input class="inp-cbx add-coordinate" id="cbx" type="checkbox" style="display: none">
                                <label class="cbx" for="cbx">
                                    <span>
                                        <svg width="12px" height="10px" viewBox="0 0 12 10">
                                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                    </span>
                                    <span class="text-light-black">Add coordinate of this location</span>
                                </label>
                            </div>
                        </div>
                        <div class="row coordinate">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="latitude">Latitude</label>
                                    <input type="text" name="latitude" id="latitude" class="form-control"
                                           placeholder="Latitude">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="longitude"> Longitude</label>
                                    <input type="text" name="longitude" id="longitude" class="form-control shadow"
                                           placeholder="Longitude">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancel</button>
                    <button type="button" class="btn btn-primary saveLocation">Save</button>
                </div>
            </div>
        </div>
    </div>

    <form action="" method="post" id="deleteLocationForm">
        @csrf
        {{ method_field('DELETE') }}
    </form>
@endsection

@section('css')

@endsection

@section('js')
    <script>
        $(document).ready(function () {
            $('.coordinate').hide();

            $('.add-coordinate').change(function () {
                if ($(this).is(':checked')) {
                    $('.coordinate').slideDown();
                } else {
                    $('.coordinate').slideUp();
                }
            })

            $('body').on('click', '.edit, .add', function () {
                let location_id = $(this).attr('id')
                let name = $(this).attr('name')
                let latitude = $(this).attr('latitude')
                let longitude = $(this).attr('longitude')
                if (location_id) {
                    $('#location-id').val(location_id)
                    $('#name').val(name)
                    $('#latitude').val(latitude)
                    $('#longitude').val(longitude)
                } else {
                    $('#location-id').val("")
                    $('#name').val("")
                    $('#latitude').val("")
                    $('#longitude').val("")
                }

                $('#addEditLocationModal').modal();
                $('.btnSave').click(function () {
                    $('#addEditLocationForm').submit();
                })
            });

            $('.saveLocation').click(function () {
                $('#addEditLocationForm').submit();
            })



            $('.widget-content .warning.delete').on('click', function () {
                let location_id = $(this).attr('id');
                let url = "{{ route('vehicles.location.destroy',':id') }}"
                url = url.replace(':id', location_id);
                $('#deleteLocationForm').attr('action', url)
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
                        $('#deleteLocationForm').submit();
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
