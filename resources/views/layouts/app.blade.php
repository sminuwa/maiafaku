
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{ myAsset('assets/img/apple-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ myAsset('assets/img/favicon.png') }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>
        E-DOC
    </title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    {{--<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />--}}
    {{--<link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">--}}
    <link rel="stylesheet" type="text/css" href="{{ myAsset('assets/DataTables/datatables.min.css') }}"/>
    <!-- CSS Files -->
    @include('commons.style')
    @yield('css')
    <script src="{{ myAsset('assets/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ myAsset('assets/ckeditor/samples/js/sample.js') }}"></script>
    @livewireStyles
</head>

<body class="">

<div class="wrapper" @auth() @else style="background: #f4f3ef;" @endauth>
    @include('commons.sidebar')
    <div class="main-panel">
        <!-- Navbar -->
        @include('commons.navbar')
        <!-- End Navbar -->
        <div class="content">
            @yield('content')
        </div>
        @include('commons.footer')

        @auth
            @php $user = auth()->user(); @endphp
        <div class="modal fade" id="remiderModal" tabindex="-1" role="dialog" aria-labelledby="remiderModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg mt-0 pt-0" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" style="float:right" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h5 class="modal-title text-left" id="remiderModalLabel">{{ greetings() }} {{$user?->details()?->gender == 'Male' ? 'Sir, ':'Madam, ' }} <small>{{ $user?->fullName() }}</small></h5>

                    </div>
                    <div class="modal-body">
                        ...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <a href="{{ route('memos.received') }}" type="button" class="btn btn-primary">Go to memos</a>
                    </div>
                </div>
            </div>
        </div>
        @endauth

    </div>
</div>
<!--   Core JS Files   -->

<script src="{{ myAsset('assets/js/core/jquery.min.js') }}"></script>
<script src="{{ myAsset('assets/js/core/popper.min.js') }}"></script>
<script src="{{ myAsset('assets/js/core/bootstrap.min.js') }}"></script>
<script src="{{ myAsset('assets/js/plugins/perfect-scrollbar.jquery.min.js') }}"></script>
<!--  Notifications Plugin    -->
<script src="{{ myAsset('assets/js/plugins/bootstrap-notify.js') }}"></script>
<!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
<script src="{{ myAsset('assets/js/paper-dashboard.min.js') }}" type="text/javascript"></script><!-- Paper Dashboard DEMO methods, don't include it in your project! -->
<script src="{{ myAsset('assets/js/datatables.min.js') }}" type="text/javascript"></script><!-- Paper Dashboard DEMO methods, don't include it in your project! -->
<script src="{{ myAsset('assets/js/dataTables.bootstrap4.min.js') }}" type="text/javascript"></script><!-- Paper Dashboard DEMO methods, don't include it in your project! -->
<script src="{{ myAsset('assets/js/bootstrap-select.min.js') }}" type="text/javascript"></script><!-- Paper Dashboard DEMO methods, don't include it in your project! -->
<script src="{{ myAsset('assets/DataTables/datatables.min.js') }}" type="text/javascript"></script>
<script src="{{ myAsset('assets/js/select2.full.min.js') }}"></script>
<script src="{{ myAsset('assets/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ myAsset('master/js-cookies/js.cookie.min.js') }}"></script>
<script src="{{ myAsset('master/js-cookies/js.cookie.min.js') }}"></script>
{{--<script src="{{ myAsset('assets/js/jquery.dataTables.min.js') }}"></script>--}}
{{--<script src="{{ myAsset('assets/js/dataTables.jqueryui.min.js') }}"></script>--}}
@stack('js')
@yield('js')

<script>
    $('table.display').DataTable();

    $(document).ready(function() {

    });
    //general remider model


    $(document).ready(function() {

       /* if($.cookie('showOnlyOne')){
            //it is still within the day
            //hide the div
        } else {
            //either cookie already expired, or user never visit the site
            //create the cookie
            $.cookie('showOnlyOne', 'showOnlyOne', { expires: 1 });

            //and display the div
            setTimeout(function(){
                $('#remiderModal').modal();
            }, 3000)
        }*/


        let audioElement = document.createElement('audio');
        audioElement.setAttribute('src', '{{ myAsset('ring.mp3') }}');

        audioElement.autoplay;

        audioElement.addEventListener('ended', function() {
            this.play();
        }, false);

        audioElement.addEventListener("canplay",function(){
            $("#length").text("Duration:" + audioElement.duration + " seconds");
            $("#source").text("Source:" + audioElement.src);
            $("#status").text("Status: Ready to play").css("color","green");
        });

        audioElement.addEventListener("timeupdate",function(){
            $("#currentTime").text("Current second:" + audioElement.currentTime);
        });

        $('#play').click(function() {
            audioElement.play();
            $("#status").text("Status: Playing");
        });

        $('#pause').click(function() {
            audioElement.pause();
            $("#status").text("Status: Paused");
        });

        $('#restart').click(function() {
            audioElement.currentTime = 0;
        });


        audioElement.addEventListener("canplaythrough", function() {
            /* the audio is now playable; play it if permissions allow */

        });
        // audioElement.play();
        let last = 0;
        setInterval(function(){
            $.ajax({
                url: "{{ route('memos.ringing') }}",
                success: function(data){
                    if(last != data && last > 0){
                        audioElement.currentTime = 0;
                        audioElement.play();
                        // alert(data)
                    }else{
                        audioElement.pause();
                    }
                    last = data
                }
            });

            /*$.ajax({
                url: "{{ route('api.local_to_remote') }}",
                success: function(response){
                    console.log(response)
                }
            })*/
        }, 10000);


    });
</script>
<script src="{{ myAsset('vendor/livewire/livewire.js?id=25f025805c3c370f7e87') }}"></script>
@livewireScripts
</body>
</html>

