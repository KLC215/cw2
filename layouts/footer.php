<!-- Google Map Javascript API -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCWJm93-OKx4ibxo74PEDEY0JfNuOX4IXo&callback=initMap"
		async defer></script>
<!-- Jquery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

<!-- Bootstrap-->
<script src="../assets/js/bootstrap.js"></script>

<!-- SweetAlert2 -->
<script src="../assets/js/sweetalert2.min.js"></script>

<!-- Datatables -->
<script src="../assets/js/datatables.js"></script>

<!-- Jquery chained -->
<script src="../assets/js/jquery.chained.js"></script>

<!-- Lodash -->
<script src="../assets/js/lodash.js"></script>

<script>

	let stations = [];
	let map = null;
	let markers = [];

	function initMap() {

		axios.get(API_URL, { params: { lang: 'en', format: 'json' } })
			 .then(function (response) {

				 let stationList = response.data.stationList;

				 if (stationList.error) {
					 swal(
						 stationList.error.msg,
						 'Error code: <b>' + stationList.error.code + '</b>',
						 'error'
					 );
					 return;
				 }

				 stations = stationList.station;

				 // Create a map object and specify the DOM element for display.
				 map = new google.maps.Map(document.getElementById('map'), {
					 center: { lat: 22.342200, lng: 114.106777 },
					 zoom: 12
				 });

				 // Add markers on the map
				 stations.forEach(function (item, index) {
					 addMarker(item, map);
				 });

			 });

	}

	// Adds a marker to the map and push to the array.
	function addMarker(location, map) {
		let marker = new google.maps.Marker({
			position: new google.maps.LatLng(location.lat, location.lng),
			draggable: false,
			map: map
		});

		markers.push(marker);
	}

	// Sets the map on all markers in the array.
	function setMapOnAll(map) {
		for (var i = 0; i < markers.length; i++) {
			markers[i].setMap(map);
		}
	}

	// Removes the markers from the map, but keeps them in the array.
	function clearMarkers() {
		setMapOnAll(null);
	}

	// Shows any markers currently in the array.
	function showMarkers() {
		setMapOnAll(map);
	}

	// Deletes all markers in the array by removing references to them.
	function deleteMarkers() {
		clearMarkers();
		markers = [];
	}

</script>

<script src="../assets/js/main.js"></script>

</body>
</html>