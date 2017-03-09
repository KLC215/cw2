<div id="map"></div>

<script>

	//document.getElementById('map')
	function initMap() {

		let myMap = $('#content #map')[0];
		// Create a map object and specify the DOM element for display.
		var map = new google.maps.Map(myMap, {
			center: { lat: 22.342200, lng: 114.106777 },
			zoom: 18
		});

		console.log(map);
	}

</script>