<head>
		

		<link rel="stylesheet" href="demo.css" type="text/css" media="all">
		<link rel="stylesheet" href="jquery.dropSlideMenu.css" type="text/css" media="all">

		<script type="text/javascript" src="jquery-1.3.2.min.js"></script>
		<script type="text/javascript" src="jquery-ui-1.7.2.custom.min.js"></script>
		<script type="text/javascript" src="jquery.event.hover.js"></script>
		<script type="text/javascript" src="jquery.dropSlideMenu.js"></script>

		<script type="text/javascript">
			$(document).ready(function() {
				$("#navigation").dropSlideMenu({
					indicators: true, // adds a div to the list items for attaching indicators (arrows)
					clickstream: true, // highlights the clickstream in a menu by comparing the links to the current URL path
					openEasing: "easeOutQuad", // open animation effect
					closeEasing: "easeInQuad", // close animation effect
					duration: 600, // speed of drop down animation (in milliseconds)
					delay: 800, // delay before the drop down closes (in milliseconds)
					hideSelects: true // hide all select elements on the page when the menu is active (IE6 only)
				});
			});
		</script>
	</head>
<div id="navigation">
				<ul>
					<li><a href="/home">Home</a></li>
					<li><a href="/planets">Planets</a>
						<ul>
							<li><a href="/planets/mercury">Mercury</a></li>
							<li><a href="/planets/venus">Venus</a></li>
							<li><a href="/planets/earth">Earth</a></li>
							<li><a href="/planets/mars">Mars</a></li>
							<li><a href="/planets/jupiter">Jupiter</a></li>
							<li><a href="/planets/saturn">Saturn</a></li>
							<li><a href="/planets/uranus">Uranus</a></li>
							<li><a href="/planets/neptune">Neptune</a></li>
						</ul>
					</li>
					<li><a href="demo.html">Continents</a>
						<ul>
							<li><a href="/continents/africa">Africa</a></li>
							<li><a href="/continents/antarctica">Antarctica</a></li>
							<li><a href="/continents/asia">Asia</a></li>
							<li><a href="/continents/australia">Australia</a></li>
							<li><a href="demo.html">Europe</a></li>
							<li><a href="/continents/north-america">North America</a></li>
							<li><a href="/continents/south-america">South America</a></li>
						</ul>
					</li>
					<li><a href="#">Oceans</a>
						<ul>
							<li><a href="/oceans/arctic">Arctic</a></li>
							<li><a href="/oceans/atlantic">Atlantic</a></li>
							<li><a href="/oceans/indian">Indian</a></li>
							<li><a href="/oceans/pacific">Pacific</a></li>
							<li><a href="/oceans/southern">Southern</a></li>
						</ul>
					</li>
					<li><a href="/about">About</a></li>
					<li><a href="/contact">Contact</a></li>
				</ul>
			</div>