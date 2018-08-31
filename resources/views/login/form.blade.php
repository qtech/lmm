
<!DOCTYPE html>
<html lang="en" class="no-js">

    <head>

        <meta charset="utf-8">
        <title>{{config('app.name')}}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta http-equiv="cache-control" content="private, max-age=0, no-cache">
        <meta http-equiv="pragma" content="no-cache">
        <meta http-equiv="expires" content="0">
        <link href="{{asset('app_icon.png')}}" rel="icon" type="image/png">
        <!-- CSS -->
        <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=PT+Sans:400,700'>
        <link rel="stylesheet" href="{{asset('/assets/login/css/reset.css')}}">
        <link rel="stylesheet" href="{{asset('/assets/login/css/supersized.css')}}">
        <link rel="stylesheet" href="{{asset('/assets/login/css/style.css')}}">

        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
            <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

    </head>

    <body>

        <div class="page-container login_page_fixed">
            <img src="{{asset('app_icon.png')}}" style="height:75px !important; width:150px !important;">
            
            <form action="{{route('login.auth')}}" method="post">
            @if(count($errors)>0)
                @foreach($errors->all() as $error)
            <div style="display: block; background: rgba(255, 0, 0, 0.5);  padding: 15px; border-radius: 6px;">
                {{ $error }}
            </div>
                @endforeach
            @endif
            @if(session('error'))
                <div style="display: block; background: rgba(255, 0, 0, 0.5);  padding: 15px; border-radius: 6px;">
                {{ session('error') }}
            </div>
            @endif
            {{csrf_field()}}
                <input type="text" name="username" class="username" placeholder="Username" style="border:1px solid silver !important;" value="{{old('username')}}">
                <input type="password" name="password" class="password" placeholder="Password" style="border:1px solid silver !important;">
                <button type="submit" style="background-color:silver !important; border:none !important;">Login</button>
                <div class="error"><span>+</span></div>
            </form>            
        </div>

        <!-- Javascript -->
        <script src="{{asset('/assets/login/js/jquery-1.8.2.min.js')}}"></script>
        <script src="{{asset('/assets/login/js/supersized.3.2.7.min.js')}}"></script>        
        <script src="{{asset('/assets/login/js/scripts.js')}}"></script>
        <script type="text/javascript">
            
            jQuery(function($){

                $.supersized({

                    // Functionality
                    slide_interval     : 3000,    // Length between transitions
                    transition         : 1,    // 0-None, 1-Fade, 2-Slide Top, 3-Slide Right, 4-Slide Bottom, 5-Slide Left, 6-Carousel Right, 7-Carousel Left
                    transition_speed   : 1000,    // Speed of transition
                    performance        : 1,    // 0-Normal, 1-Hybrid speed/quality, 2-Optimizes image quality, 3-Optimizes transition speed // (Only works for Firefox/IE, not Webkit)

                    // Size & Position
                    min_width          : 0,    // Min width allowed (in pixels)
                    min_height         : 0,    // Min height allowed (in pixels)
                    vertical_center    : 1,    // Vertically center background
                    horizontal_center  : 1,    // Horizontally center background
                    fit_always         : 0,    // Image will never exceed browser width or height (Ignores min. dimensions)
                    fit_portrait       : 1,    // Portrait images will not exceed browser height
                    fit_landscape      : 0,    // Landscape images will not exceed browser width

                    // Components
                    slide_links        : 'blank',    // Individual links for each slide (Options: false, 'num', 'name', 'blank')
                    slides             : [    // Slideshow Images
                                             {image : '{{asset("lmm.png")}}'}
                                         ]

                });

            });

        </script>

    </body>

</html>

