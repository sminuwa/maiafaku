@extends('layouts.master')

@section('content')
    <div class="row layout-spacing layout-top-spacing" id="cancel-row">
        <div class="col-lg-12">
            <div class="">
                <div class="widget-content searchable-container grid">
                    <div class="card-box">
                        <div class="row">
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 text-center"></div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 text-center">
                                Month:
                                <div class="input-group">
                                    <input id="basicExample" class="form-control flatpickr flatpickr-input active" type="text" placeholder="Select date...">
                                    <div class="input-group-append">
                                        <button class="btn btn-soft-secondary" type="button">Go!</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 text-center"></div>
                        </div>
                    </div>
                    <div class="card-box">
                        <div class="text-right">
                            <button class="btn btn-primary bg-gradient-primary"><i class="las la-print"></i> Print</button>
                        </div>
                        <div class="content-section py-1 animated animatedFadeInUp fadeInUp">
                            <div class="row inv--head-section mb-4">
                                <div class="col-sm-12 col-12 text-center">
                                    <div class="company-info">
                                        <img src="{{ myAsset("logo.png") }}"/>
                                    </div>
                                    <h3 class="m-0">ALBABELLO TRADING COMPANY LTD</h3>
                                    <h5 class="m-0 bg-gradient-primary" style="color:white">
                                        Salary sheet of February 2022
                                    </h5>
                                    <h6 class="m-0">{{ auth()->user()->fullName() }}</h6>
                                </div>
                            </div>

                            <div class="row inv--product-table-section">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead class="">
                                            <tr>
                                                <th scope="col">S.No</th>
                                                <th scope="col">Employee Name</th>
                                                <th scope="col">Designation</th>
                                                <th class="text-right" scope="col">Gross Salary</th>
                                                <th class="text-right" scope="col">Total Deduction</th>
                                                <th class="text-right" scope="col">Net Salary</th>
                                                <th class="text-right" scope="col">Payment Total</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($staffs as $staff)
                                                <tr>
                                                    <td class="text-center">{{ $loop->iteration }}</td>
                                                    <td>{{ $staff->fullName() }}</td>
                                                    <td>{{ $staff->position()->name ?? null }}</td>
                                                    <td class="text-right">$300</td>
                                                    <td class="text-right">$30000</td>
                                                    <td class="text-right">$30000</td>
                                                    <td class="text-right">$30000</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <th colspan="3" class="text-left">Total</th>
                                                <th class="text-right">$700</th>
                                                <th class="text-right">$21000</th>
                                                <th class="text-right">$21000</th>
                                                <th class="text-right">$21000</th>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-sm-12 col-12 text-center">
                                    <h6 class=" inv-title">This is Salary sheet of only one month</h6>
                                </div>
                            </div>
                            <div class="footer-contact">
                                <div class="row">
                                    <div class="col-sm-12 col-12">
                                        <p class="">Email: payroll@albabello.com &nbsp;|&nbsp; Contact: 08135067070 &nbsp;|&nbsp; Website: www.albabello.com</p>
                                    </div>
                                </div>
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

@push('css')
    <link href="{{ myAsset('master/assets/css/apps/invoice.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ myAsset('master/assets/css/ui-elements/pagination.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ myAsset('master/plugins/jquery-ui/jquery-ui.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ myAsset('master/assets/css/elements/tooltip.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ myAsset('master/assets/css/apps/ecommerce.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .table td, .table th {
            padding: 0.1rem;
        }
    </style>
@endpush

@section('js')
    <script src="{{ myAsset('master/assets/js/apps/ecommerce.js') }}"></script>
    <script>
        $(document).ready(function () {

        });
    </script>
@endsection
