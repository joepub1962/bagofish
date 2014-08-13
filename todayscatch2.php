<?php
?>

<!DOCTYPE HTML>
<meta charset="UTF-8">
<html>
<head>
	<title>Today's Catch</title>
    <!-- Le styles -->
	<link href="css/bootstrap.css" rel="stylesheet">
	<link href="css/main.css" rel="stylesheet">
	<style>
		body 
		{
			padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
		}
		#over, .alert-info 
		{
			 z-index: 100;
			 background-color: black;
			 color: white;
			 border: 3px solid #fbeed5;
			 border-color: #bce8f1;
		}
	</style>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-responsive.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="http://tobagoborn.com/demo/favicon.ico">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

	<!--   cartodb & leaflet -->
	<link rel="shortcut icon" href="http://cartodb.com/favicon/favicon_32x32.ico" />
	<link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.3.1/leaflet.css" />
	<link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.3.1/leaflet.ie.css" />
	<link  href="cartodb-leaflet/css/cartodb-leaflet.css" rel="stylesheet" type="text/css">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
	<script src="http://cdn.leafletjs.com/leaflet-0.3.1/leaflet.js"></script>
	<script type="text/javascript" src="cartodb-leaflet/js/wax.leaf.js"></script>
	<script type="text/javascript" src="cartodb-leaflet/dist/cartodb-leaflet.js"></script>
	<script type="text/javascript" src="cartodb-leaflet/dist/cartodb-popup.js"></script>

	<script type="text/javascript">
	var cartodb_leaflet1, cartodb_leaflet2;
	//var popup = new L.CartoDBPopup();

	function initialize()
	{

		var today = new Date();

		var map = new L.Map('map_canvas1',
		{
			doubleClickZoom:true,zoomControl:true, scrollWheelZoom: false, touchZoom: false, dragging: true, minZoom:11, maxZoom:13
		}).setView(new L.LatLng(11.22,  -60.65), 9);

		//var tilesUrl = 'http://tobagoborn.com/tiles/tobagobasemap/{z}/{x}/{y}.png',
		//var tilesUrl = 'http://192.168.1.50/tiles/tobagobasemap/{z}/{x}/{y}.png',
		//var tilesUrl = 'http://192.168.1.50/tiles/1.0.0/tobago/{z}/{x}/{y}.png',
		var tilesUrl = 'http://tobagoborn.com/tiles/1.0.0/tobago/{z}/{x}/{y}.png',

		tilesLayer = new L.TileLayer(tilesUrl, {maxZoom: 12});
		map.addLayer(tilesLayer,true);

		var query = "SELECT L.the_geom_webmercator, L.landing_sites, F.first_name, F.last_name,C.number_of_species FROM catch C, lsites L, fishermen F WHERE C.have_catch = 1 AND C.site_code = L.site_code AND C.fisherman_id = F.fisherman_id AND C.catch_date > now()::date";

	    cartodb_leaflet2 = new L.CartoDBLayer(
		{
		
			map_canvas: 'map_canvas1',
			map: map,
			user_name:"tobagoborn",
			table_name: 'catch',
			query: query,
			interactivity: 'landing_sites,first_name,last_name,number_of_species',

			featureOver: function(ev,latlng,pos,data) 
			{
				var html = "";
				html += "<p><b><u>TODAY'S CATCH</u></b>" + "</p>";
				html += "<p><b>Site Name: </b>" + data.landing_sites +"</p>";
				html += "<p><b>Fisher Man: </b>" + data.first_name +" " + data.last_name + "</p>";
				html += "<p><b>Number of Species Caught: </b>" + data.number_of_species +"</p>";
				html += "Click to get more information about this Landing Site";


				var X = 0;
				var Y = 0;
				X += pos.x;
				Y += pos.y;
				document.body.style.cursor = "pointer";
				$("div#over").css('position', 'absolute');
				$("div#over").offset({top: Y, left: X});
				$("div#over").html(html);
				$("div#over").show();

				},
			featureOut: function()
			{
				document.body.style.cursor = "default";
				hidePopup();
			},

			auto_bound: false,
			debug: false,

			//------- CLICK EVENT -----------
			featureClick: function(ev, latlng, pos, data) 
			{

				var html = "";
				for (var column in data)
				{
					html +=  column + ':<b>  ' + data[column] + '</b><br>';
				}
				$("div#click").html(html);
			},

	    });

		map.addLayer(cartodb_leaflet2);	

		function hidePopup() 
		{
			$("div#over").hide();
		}
		

	}


	</script>
	
	<!-- End of cartodb & leaflet -->

</head>

  <body onload="initialize()">
	<div class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container">

				<a class="brand" href="/daycatch">CATCH OF THE DAY</a>
				<ul class="nav">
					<li><a href="/daycatch">Home</a></li>
					<li><a href="landingsites.html">Landing Sites</a></li>
					<li class="active"><a href="todayscatch2.php">Today's Catch</a></li>
					<li><a href="about.html">About</a></li>
				</ul>
			</div> <!-- container -->
		</div> <!-- navbar-inner -->
	</div> <!-- navbar -->


	<div class="container">
		<div id="caption">
			<h1>TODAY'S CATCH: 

			<?php
			echo "(". date("M/d/Y") . ")"; 
			?>
			</h1>
			<center> Hover over landing site for more info</center>

		
		<div id="main">
		<div id="map_canvas1" background-color: "white; "> <!--border:1px solid black; " -->
		</div>
		<div id="over">
		</div>

		<div id="click">
		</div>

		</div><!-- MAIN -->

	</div> <!-- /container -->


    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <!-- script src="js/jquery.js"></script -->
    <script src="js/bootstrap.min.js"></script>

  </body>

</html>
