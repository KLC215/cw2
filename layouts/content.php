<div class="container">

</div>

<div id="map"></div>


<script>
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

				 let stations = stationList.station;

				 // Create a map object and specify the DOM element for display.
				 let map = new google.maps.Map(document.getElementById('map'), {
					 center: { lat: 22.342200, lng: 114.106777 },
					 zoom: 12
				 });

				 // Add markers on the map
				 stations.forEach(function (item, index) {
					 addMarker(item, map);
				 });

				 $('#amount').text(stations.length);

			 });

	}

	function addMarker(location, map) {
		let marker = new google.maps.Marker({
			position: new google.maps.LatLng(location.lat, location.lng),
			draggable: false,
			map: map
		});

	}
</script>