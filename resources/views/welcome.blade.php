<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Your description">
    <meta name="author" content="Your name">
	<meta property="og:site_name" content="" /> <!-- website name -->
	<meta property="og:site" content="" /> <!-- website link -->
	<meta property="og:title" content=""/> <!-- title shown in the actual shared post -->
	<meta property="og:description" content="" /> <!-- description shown in the actual shared post -->
	<meta property="og:image" content="" /> <!-- image link, make sure it's jpg -->
	<meta property="og:url" content="" /> <!-- where do you want your post to link to -->
	<meta name="twitter:card" content="summary_large_image"> <!-- to have large image post format in Twitter -->

    <title>Livestock</title>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,400;0,600;0,700;1,400;1,600&display=swap" rel="stylesheet">
    <link href="{{asset('client_side_assets/css/bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('client_side_assets/css/fontawesome-all.css')}}" rel="stylesheet">
    <link href="{{asset('client_side_assets/css/swiper.css')}}" rel="stylesheet">
	<link href="{{asset('client_side_assets/css/magnific-popup.css')}}" rel="stylesheet">
	<link href="{{asset('client_side_assets/css/styles.css')}}" rel="stylesheet">
	
	<!-- Favicon  -->
    <link rel="icon" href="images/favicon.png">
</head>
<body>
        <div class="flex-center position-ref full-height" id="clientSide">
            <router-view> </router-view>
        </div>
        
    </body>
    <script src="{{mix('js/client_side.js')}}"></script>
    <script src="{{asset('client_side_assets/js/jquery.min.js')}}"></script> 
    <script src="{{asset('client_side_assets/js//bootstrap.min.js')}}"></script>
    <script src="{{asset('client_side_assets/js/jquery.easing.min.js')}}"></script> 
    <script src="{{asset('client_side_assets/js/jquery.magnific-popup.js')}}"></script>
    <script src="{{asset('client_side_assets/js/swiper.min.js')}}"></script> 
    <script src="{{asset('client_side_assets/js/scripts.js')}}"></script>
</html>
