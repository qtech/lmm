<header class="site-header">
	    <div class="container-fluid">
	
            <a href="{{route('admin.dashboard')}}" class="site-logo">
	            <img class="hidden-md-down" src="{{asset('app_icon.png')}}" alt="" style="right:0px !important; height:65px !important;">
	        </a>
	
	        <button id="show-hide-sidebar-toggle" class="show-hide-sidebar" style="left:40px !important;">
	            <span>toggle menu</span>
	        </button>
	
	        <button class="hamburger hamburger--htla">
	            <span>toggle menu</span>
	        </button>
	        <div class="site-header-content">
	            <div class="site-header-content-in">
	                <div class="site-header-shown">
	                    <div class="dropdown user-menu">
	                        <button class="dropdown-toggle" id="dd-user-menu" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	                            <img src="{{asset('user.png')}}" alt="">
	                        </button>
	                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dd-user-menu">
	                            <a class="dropdown-item" href="{{route('login.logout')}}"><span class="font-icon glyphicon glyphicon-log-out"></span>Logout</a>
	                        </div>
	                    </div>	
	                </div><!--.site-header-shown-->
	            </div><!--site-header-content-in-->
	        </div><!--.site-header-content-->
	    </div><!--.container-fluid-->
	</header><!--.site-header-->