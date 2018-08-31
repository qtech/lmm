<nav class="side-menu">
	    <ul class="side-menu-list">
	        <li class="grey with-sub {{Request::is('dashboard/*') || Request::is('dashboard') ? 'opened' : ''}}">
	            <a href="{{route('admin.dashboard')}}">
	                <i class="font-icon font-icon-dashboard"></i>
	                <span class="lbl">Dashboard</span>
	            </a>
	        </li>	
	        <li class="brown with-sub {{Request::is('music/*') || Request::is('songs/*') ? 'opened' : ''}}">
	            <a href="{{route('musicgenres.index')}}">
	                <i class="fa fa-music"></i>
	                <span class="lbl">Genres</span>
	            </a>
	        </li>
	        <li class="purple with-sub {{Request::is('hitsingles/*') || Request::is('hitsingles') ? 'opened' : ''}}">
	            <a href="{{route('latin.index')}}">
	                <i class="fa fa-pagelines"></i>
	                <span class="lbl">DJ Mixes</span>
	            </a>
	        </li>	
	        {{-- <li class="gold with-sub {{Request::is('djs/*') || Request::is('djs') ? 'opened' : ''}}">
	            <a href="{{route('english.index')}}">
	                <i class="fa fa-edge"></i>
	                <span class="lbl">Featured Djs</span>
	            </a>
	        </li>	 --}}
	        <li class="blue-dirty {{Request::is('artist/*') || Request::is('artist') ? 'opened' : ''}}">
	            <a href="{{route('albums.index')}}">
	                <i class="fa fa-folder-o" aria-hidden="true"></i>
	                <span class="lbl">Add Artist</span>
	            </a>
	        </li>	
	        <li class="magenta with-sub {{Request::is('artists/*') || Request::is('artists') ? 'opened' : ''}}">
	            <a href="{{route('artists.index')}}">
	                <i class="fa fa-deviantart"></i>
	                <span class="lbl">Artist Songs</span>
	            </a>
	        </li>	
	        {{-- <li class="green with-sub {{Request::is('events/*') || Request::is('events') ? 'opened' : ''}}">
	            <a href="{{route('events.index')}}">
	                <i class="fa fa-sticky-note"></i>
	                <span class="lbl">Events</span>
	            </a>
	        </li>	 --}}
	        {{-- <li class="red {{Request::is('images/*') || Request::is('images') ? 'opened' : ''}}">
	            <a href="{{route('images.index')}}">
	                <i class="fa fa-folder" aria-hidden="true"></i>
	                <span class="lbl">Image Folders</span>
	            </a>
	        </li>	 --}}
	        <li class="aquamarine {{Request::is('gallery/*') || Request::is('gallery') ? 'opened' : ''}}">
	            <a href="{{route('gallerys.index')}}">
	                <i class="fa fa-files-o"></i>
	                <span class="lbl">Gallery</span>
	            </a>
            </li>	
            <li class="pink-red {{Request::is('slider/*') || Request::is('slider') ? 'opened' : ''}}">
	            <a href="{{route('slider.index')}}">
	               <i class="fa fa-picture-o" aria-hidden="true"></i>
	                <span class="lbl">Slider Images</span>
	            </a>
	        </li>
            <li class="aquamarine {{Request::is('products/*') || Request::is('prodcuts') ? 'opened' : ''}}">
	            <a href="{{route('djproducts.index')}}">
	                <i class="fa fa-list-alt"></i>
	                <span class="lbl">DJ Products</span>
	            </a>
	        </li> 
	        {{-- <li class="gold {{Request::is('videos/*') || Request::is('videos') ? 'opened' : ''}}">
	            <a href="{{route('videos.index')}}">
	                <i class="fa fa-video-camera"></i>
	                <span class="lbl">Videos</span>
	            </a>
	        </li> --}}
	        {{-- <li class="aquamarine {{Request::is('videos-of-the-day/*') || Request::is('videos-of-the-day') ? 'opened' : ''}}">
	            <a href="{{route('videos-of-the-day.index')}}">
	                <i class="fa fa-file-video-o" aria-hidden="true"></i>
	                <span class="lbl">Video Of The Day</span>
	            </a>
	        </li>
	         <li class="blue-dirty {{Request::is('audio-of-the-day/*') || Request::is('audio-of-the-day') ? 'opened' : ''}}">
	            <a href="{{route('audio-of-the-day.index')}}">
	               <i class="fa fa-file-audio-o" aria-hidden="true"></i>
	                <span class="lbl">Audio Of The Day</span>
	            </a>
	        </li> --}}
	        {{-- <li class="magenta with-sub {{Request::is('artists_bio/*') || Request::is('artists_bio') ? 'opened' : ''}}">
	            <a href="{{route('artists_bio.main')}}">
	               <i class="fa fa-paint-brush" aria-hidden="true"></i>
	                <span class="lbl">Artist Biographies</span>
	            </a>
	        </li>	
	        <li class="aquamarine {{Request::is('vip/*') || Request::is('vip') ? 'opened' : ''}}">
	            <a href="{{route('vips.index')}}">
	                <i class="fa fa-list-alt"></i>
	                <span class="lbl">VIP list (Sign Up)</span>
	            </a>
            </li> --}}
	        {{-- <li class="pink-red {{Request::is('booking/*') || Request::is('booking') ? 'opened' : ''}}">
	            <a href="{{route('bookings.index')}}">
	                <i class="fa fa-book"></i>
	                <span class="lbl">Booking Details</span>
	            </a>
            </li>	 --}}
            <li class="gold with-sub">
	            <a href="{{route('onair.index')}}">
	                <i class="fa fa-microphone"></i>
	                <span class="lbl">On Air (Radio)</span>
	            </a>
	        </li>
	        <li class="green with-sub {{Request::is('socials/*') || Request::is('socials') ? 'opened' : ''}}">
	            <a href="{{route('socials.index')}}">
	                <i class="fa fa-users"></i>
	                <span class="lbl">Social</span>
	            </a>
	        </li>	
	        {{-- <li class="magenta with-sub {{Request::is('notifications/*') || Request::is('notifications') ? 'opened' : ''}}">
	            <a href="{{route('notifications.index')}}">
	                <i class="font-icon glyphicon glyphicon-send"></i>
	                <span class="lbl">Send Notifications</span>
	            </a>
	        </li>	 --}}
	        {{-- <li class="blue-dirty {{Request::is('share/*') || Request::is('share') ? 'opened' : ''}}">
	            <a href="{{route('shares.index')}}">
	                <i class="fa fa-share-alt"></i>
	                <span class="lbl">Share</span>
	            </a>
	        </li>	 --}}	
	        {{-- <li class="purple with-sub {{Request::is('biography/*') || Request::is('biography') ? 'opened' : ''}}">
	            <a href="{{route('bio.index')}}">
	                <i class="font-icon font-icon-user"></i>
	                <span class="lbl">Biography</span>
	            </a>
	        </li>	
	        <li class="brown with-sub {{Request::is('customer/*') || Request::is('customer') ? 'opened' : ''}}">
	            <a href="{{route('customers.index')}}">
					<i class="fa fa-server"></i>
	                <span class="lbl">Customer Service</span>
	            </a>
	        </li>	         --}}
	    </ul>
	</nav><!--.side-menu-->
