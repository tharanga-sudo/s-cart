@if (sc_config('SITE_STATUS') == 'off')
@include($templatePath . '.maintenance')
@php
    exit();
@endphp
@endif

        <!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-2CG1T5QC5S"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());

        gtag('config', 'G-2CG1T5QC5S');
    </script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $description??sc_store('description') }}">
    <meta name="keyword" content="{{ $keyword??sc_store('keyword') }}">
    <title>{{$title??sc_store('title')}}</title>
    <meta property="og:image" content="{{ !empty($og_image)?asset($og_image):asset('images/org.jpg') }}"/>
    <meta property="og:url" content="{{ \Request::fullUrl() }}"/>
    <meta property="og:type" content="Website"/>
    <meta property="og:title" content="{{ $title??sc_store('title') }}"/>
    <meta property="og:description" content="{{ $description??sc_store('description') }}"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!--Module meta -->
@isset ($blocksContent['meta'])
    @foreach ( $blocksContent['meta']  as $layout)
        @php
            $arrPage = explode(',', $layout->page)
        @endphp
        @if ($layout->page == '*' ||  (isset($layout_page) && in_array($layout_page, $arrPage)))
            @if ($layout->type =='html')
                {!! $layout->text !!}
            @endif
        @endif
    @endforeach
@endisset
<!--//Module meta -->

    <!-- css default for item s-cart -->
@include('common.css')
<!--//end css defaut -->

    <link href="{{ asset($templateFile.'/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ asset($templateFile.'/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{ asset($templateFile.'/css/prettyPhoto.css')}}" rel="stylesheet">
    <link href="{{ asset($templateFile.'/css/animate.css')}}" rel="stylesheet">
    <link href="{{ asset($templateFile.'/css/main.css')}}" rel="stylesheet">
    <link href="{{ asset($templateFile.'/css/responsive.css')}}" rel="stylesheet">
<!--[if lt IE 9]>
    <script src="{{ asset($templateFile.'/js/html5shiv.js')}}"></script>
    <script src="{{ asset($templateFile.'/js/respond.min.js')}}"></script>
    <![endif]-->
    <link rel="shortcut icon" href="{{ asset($templateFile.'/images/ico/favicon.ico')}}">
    <link rel="apple-touch-icon-precomposed" sizes="144x144"
          href="{{ asset($templateFile.'/images/ico/apple-touch-icon-144-precomposed.png')}}">
    <link rel="apple-touch-icon-precomposed" sizes="114x114"
          href="{{ asset($templateFile.'/images/ico/apple-touch-icon-114-precomposed.png')}}">
    <link rel="apple-touch-icon-precomposed" sizes="72x72"
          href="{{ asset($templateFile.'/images/ico/apple-touch-icon-72-precomposed.png')}}">
    <link rel="apple-touch-icon-precomposed"
          href="{{ asset($templateFile.'/images/ico/apple-touch-icon-57-precomposed.png')}}">
    <style type="text/css" rel="stylesheet">
        .btn.btn-default.dropdown-toggle {
            border-top-right-radius: 0px;
            border-bottom-right-radius: 0px;
            border: none;
            background-color: #eee;
            height: 40px;
        }

        #search_input {
            border-text-outline: none;
            height: 40px;
            border: none;
            background: #eee;
        }
        #btnSearch{
            background: #eee;
            border: none;
            height: 40px;
            margin-left: -4px;
        }
        #btnSearch:focus{
            border: none;
            background: rgba(238, 238, 238, 0.6);
        }
        .shop-menu ul li a{
            background: none;
        }
        .shop-menu ul li a:hover{
            background: none;
        }
        .ui-autocomplete {
            z-index: 9999 !important;
        }

    </style>

    <!--Module header -->
@isset ($blocksContent['header'])
    @foreach ( $blocksContent['header']  as $layout)
        @php
            $arrPage = explode(',', $layout->page)
        @endphp
        @if ($layout->page == '*' ||  (isset($layout_page) && in_array($layout_page, $arrPage)))
            @if ($layout->type =='html')
                {!! $layout->text !!}
            @endif
        @endif
    @endforeach
@endisset
<!--//Module header -->
    <style type="text/css" rel="stylesheet">
        body {
            font-family: 'Work Sans', sans-serif;
            font-size: 1.4rem;
            font-weight: 400;
            color: #555;
        }
    </style>
</head>
<!--//head-->
<body>

@include($templatePath.'.header')

<!--Module banner -->
@isset ($blocksContent['banner_top'])
    @foreach ( $blocksContent['banner_top']  as $layout)
        @php
            $arrPage = explode(',', $layout->page)
        @endphp
        @if ($layout->page == '*' ||  (isset($layout_page) && in_array($layout_page, $arrPage)))
            @if ($layout->type =='html')
                {!! $layout->text !!}
            @elseif($layout->type =='view')
                @if (view()->exists('block.'.$layout->text))
                    @include('block.'.$layout->text)
                @endif
            @elseif($layout->type =='module')
                {!! sc_block_render($layout->text) !!}
            @endif
        @endif
    @endforeach
@endisset
<!--//Module banner -->


<!--Module top -->
@isset ($blocksContent['top'])
    @foreach ( $blocksContent['top']  as $layout)
        @php
            $arrPage = explode(',', $layout->page)
        @endphp
        @if ($layout->page == '*' ||  (isset($layout_page) && in_array($layout_page, $arrPage)))
            @if ($layout->type =='html')
                {!! $layout->text !!}
            @elseif($layout->type =='view')
                @if (view()->exists('block.'.$layout->text))
                    @include('block.'.$layout->text)
                @endif
            @elseif($layout->type =='module')
                {!! sc_block_render($layout->text) !!}
            @endif
        @endif
    @endforeach
@endisset
<!--//Module top -->


<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-12" id="breadcrumb">
                <!--breadcrumb-->
            @yield('breadcrumb')
            <!--//breadcrumb-->

                <!--fillter-->
            @yield('filter')
            <!--//fillter-->
            </div>

            <!--Notice -->
        @include($templatePath.'.notice')
        <!--//Notice -->

            <!--body-->
        @section('main')
            @include($templatePath.'.left')
            @include($templatePath.'.center')
            @include($templatePath.'.right')
        @show
        <!--//body-->

        </div>
    </div>
</section>

@include($templatePath.'.footer')

<script src="{{ asset($templateFile.'/js/jquery.js')}}"></script>
<script src="{{ asset($templateFile.'/js/jquery-ui.min.js')}}"></script>
<script src="{{ asset($templateFile.'/js/bootstrap.min.js')}}"></script>
<script src="{{ asset($templateFile.'/js/jquery.scrollUp.min.js')}}"></script>
<script src="{{ asset($templateFile.'/js/jquery.prettyPhoto.js')}}"></script>
<script src="{{ asset($templateFile.'/js/main.js')}}"></script>


@stack('scripts')

<!-- js default for item s-cart -->
@include('common.js')
<!--//end js defaut -->

<!--Module bottom -->
@isset ($blocksContent['bottom'])
    @foreach ( $blocksContent['bottom']  as $layout)
        @php
            $arrPage = explode(',', $layout->page)
        @endphp
        @if ($layout->page == '*' ||  (isset($layout_page) && in_array($layout_page, $arrPage)))
            @if ($layout->type =='html')
                {!! $layout->text !!}
            @elseif($layout->type =='view')
                @if (view()->exists('block.'.$layout->text))
                    @include('block.'.$layout->text)
                @endif
            @elseif($layout->type =='module')
                {!! sc_block_render($layout->text) !!}
            @endif
        @endif
    @endforeach
@endisset
<!--//Module bottom -->
<script type="text/javascript">
    // jQuery wait till the page is fullt loaded
    $(document).ready(function () {
        // keyup function looks at the keys typed on the search box
        $('#search_input').on('keyup', function () {
            // the text typed in the input field is assigned to a variable
           // alert(0);
            var query = $(this).val();
            // call to an ajax function
            $.ajax({
                // assign a controller function to perform search action - route name is search
                url: "{{ route('searchAjax') }}",
                // since we are getting data methos is assigned as GET
                type: "GET",
                // data are sent the server
                data: {'keyword': query},
                // if search is succcessfully done, this callback function is called
                success: function (data) {
                    // print the search results in the div called country_list(id)
                    $('#products_list').html(data);
                }
            })
            // end of ajax call
        });

        // initiate a click function on each search result
        $(document).on('click', 'li', function () {
            // declare the value in the input field to a variable
            var value = $(this).text();
            // assign the value to the search box
            $('#search_input').val(value);
            // after click is done, search results segment is made empty
            $('#products_list').html("");
        });
    });
</script>
</body>
</html>
