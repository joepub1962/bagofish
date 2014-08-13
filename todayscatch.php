<?php
?>

<html>
<head>
	<title>Today's Catch</title>
    <!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <style>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
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
		var map = new L.Map('map_canvas',
		{
			doubleClickZoom:false,zoomControl:false,scrollWheelZoom: false,touchZoom: false,dragging: false
		}).setView(new L.LatLng(11.22,  -60.65), 11);

		//var tilesUrl = 'http://tobagoborn.com/tiles/tobagobasemap/{z}/{x}/{y}.png',
		var tilesUrl = 'http://192.168.1.50/tiles/tobagobasemap/{z}/{x}/{y}.png',
		//var tilesUrl = 'http://tobagoborn.com/tiles/1.0.0/tobago/{z}/{x}/{y}.png',

		tilesLayer = new L.TileLayer(tilesUrl, {maxZoom: 11});
		map.addLayer(tilesLayer,true);

		//var popup = new L.CartoDBPopup();

	    cartodb_leaflet1 = new L.CartoDBLayer(
		{
			map_canvas: 'map_canvas',
			map: map,
			user_name:"tobagoborn",
			table_name: 'lsites',
			query: "SELECT * FROM {{table_name}}",
			interactivity: "location_id,location_name",

			featureOver: function(ev,latlng,pos,data) 
			{
				var X = 0;
				var Y = 0;
				X += pos.x;
				Y += pos.y;
				document.body.style.cursor = "pointer";
				$("div#over").css('position', 'absolute');
				$("div#over").offset({top: Y, left: X});
				$("div#over").html(data.location_name);
			},
			featureOut: function()
			{
				document.body.style.cursor = "default";
			},

			auto_bound: false,
			debug: false
	    });
		//map.addLayer(cartodb_leaflet1);
		
		var query = "SELECT L.the_geom_webmercator, L.location_name, F.first_name, F.last_name,C.number_of_species FROM catch C, location L, fishermen F WHERE C.have_catch = 1 AND C.location_id = L.location_id AND C.fisherman_id = F.fisherman_id";

	    cartodb_leaflet2 = new L.CartoDBLayer(
		{
		
			map_canvas: 'map_canvas',
			map: map,
			user_name:"tobagoborn",
			table_name: 'location',
			query: query,
			interactivity: 'landing_sites,first_name,last_name,number_of_species',

			featureClick: function(ev, latlng, pos, data) 
			{

				var html = "";
				for (var column in data)
				{
					html +=  column + ':<b>  ' + data[column] + '</b><br>';
				}
				$("div#click").html(html);
			},
			featureOver: function(ev,latlng,pos,data) 
			{
				var X = 0;
				var Y = 0;
				X += pos.x;
				Y += pos.y;
				document.body.style.cursor = "pointer";
				$("div#over").css('position', 'absolute');
				$("div#over").offset({top: Y, left: X});
				$("div#over").html(data.location_name);
			},
			featureOut: function()
			{
				document.body.style.cursor = "default";
			},

			auto_bound: false,
			debug: false
	    });
		map.addLayer(cartodb_leaflet2);
		
		//cartodb_leaflet1.hide();
		//cartodb_leaflet2.hide();
		//$("#lsites").val("selectedIndex", 0);

/*		$("#lsites").click(
			function()
			{
				$("div#click").html("");
			});

		$("#lsites").change(
			function()
			{
				if($("#lsites").val() == 0)
				{
					$("div#over").html("");
					cartodb_leaflet1.hide();
					cartodb_leaflet2.hide();
				}
				if($("#lsites").val() == 1)
				{
					$("div#over").html("");
					cartodb_leaflet1.show(11);
					cartodb_leaflet2.hide();
				}
				if($("#lsites").val() == 2)
				{
				$("div#over").html("");
					cartodb_leaflet2.show();
					cartodb_leaflet1.hide();
				}
			}); */

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
		<div id="caption" style="text-align: center;>
			<h1>TODAY'S CATCH<br>
			
			<?php
			echo "(". date("M/d/Y") . ")"; 
			?>
			</h1>
		</div>
		<!-- div id="main" -->
		<div id="map_canvas" style="height:400px; width:700px; background-color:white; "> <!--border:1px solid black; " --></div>
		<div id="over"></div>

		<div id="click"></div>

		</div><!-- MAIN -->

	</div> <!-- /container -->


    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <!-- script src="js/jquery.js"></script -->
    <script src="js/bootstrap.min.js"></script>

  </body>

</html>
