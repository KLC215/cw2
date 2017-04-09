<!-- Google Map Javascript API -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCWJm93-OKx4ibxo74PEDEY0JfNuOX4IXo&callback=initMap"
		async defer></script>
<!-- Jquery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

<!-- Bootstrap-->
<script src="../assets/js/bootstrap.js"></script>

<!-- SweetAlert2 -->
<script src="../assets/js/sweetalert2.min.js"></script>

<!-- Lodash -->
<script src="../assets/js/lodash.js"></script>

<!-- Lightbox -->
<script src="../assets/js/lightbox.js"></script>

<!-- Noty -->
<script src="../assets/js/jquery.noty.packaged.min.js"></script>

<script src="../assets/js/scotchPanels.min.js"></script>

<script>

	let localeCode = 'EN';
	let enStations = [];
	let tcStations = [];
	let map = null;
	let markers = [];
	let activeWindow = null;
	let myLocation = {};
	let sidePanel = null;
	let preRememberIndex = 0;
	let recordedNo = [];

	let directionsService = null;
	let directionsDisplay = null;

	function initMap() {

		directionsService = new google.maps.DirectionsService;
		directionsDisplay = new google.maps.DirectionsRenderer;

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

				 enStations = stationList.station;

				 // Create a map object and specify the DOM element for display.
				 map = new google.maps.Map(document.getElementById('map'), {
					 center: { lat: 22.342200, lng: 114.106777 },
					 zoom: 12
				 });

				 // Add markers on the map
				 enStations.forEach(function (item, index) {
					 addMarker(item, map, index);
				 });

				 if (navigator.geolocation) {
					 navigator.geolocation.getCurrentPosition(function (position) {
						 myLocation = {
							 lat: position.coords.latitude,
							 lng: position.coords.longitude
						 };

						 addMyMarker(myLocation, map);
						 map.setCenter(myLocation);

					 }, function () {
						 handleLocationError(true);
					 });
				 } else {
					 // Browser doesn't support Geolocation
					 handleLocationError(false);
				 }


			 });

		axios.get(API_URL, { params: { lang: 'tc', format: 'json' } })
			 .then(function (response) {

				 tcStations = response.data.stationList.station;

			 });
	}

	function translateMarkers() {
		if (localeCode === 'EN') {
			deleteMarkers();
			enStations.forEach(function (item, index) {
				addMarker(item, map);
			});
			noty({
				text: 'Changed language to English !',
				layout: 'topCenter',
				type: 'success',
				timeout: 3000
			});
		} else {
			deleteMarkers();
			tcStations.forEach(function (item, index) {
				addMarker(item, map);
			});
			noty({
				text: '已轉換語言至中文 !',
				layout: 'topCenter',
				type: 'success',
				timeout: 3000
			});
		}
	}

	// Adds a marker to the map and push to the array. new google.maps.Marker
	function addMarker(location, map, index) {

		let marker = new google.maps.Marker({
			position: new google.maps.LatLng(location.lat, location.lng),
			draggable: false,
			map: map,
			animation: google.maps.Animation.DROP,
			icon: '../assets/images/label-station-green.svg'
		});

		let infoContent = '<div class="well"><div class="media">\n\t' +
			'<div class="media-left">\n\t\t' +
			'<a href="' + checkImage(location.img) + '" data-lightbox="image-info-window"><img class="media-object" src="' + checkImage(location.img) + '" alt="' + location.location + '" width="96" height="96" /></a>\n\t\t' +
			'</div>\n\t' +
			'<div class="media-body">\n\t\t' +
			'<div class="alert alert-dismissable alert-info"> ' +
			'<h4 class="media-heading"><strong>' + location.location + '</strong></h4><hr>' +
			'<div><h5><b>' + location.address + '</b></h5></div>' +
			'<br><h5><span class="label label-info">' + location.type.replace(/;/, " & ") + '</span></h5>\n\t' +
			'</div>' +
			'<a class="btn btn-success" onclick="directTo(' + index + ', ' + location.no + ')">' + checkLocaleForDirectButton() + '</a>' +
			'<a class="btn btn-primary pull-right" onclick="getMoreInfo(' + location.no + ')" tkey="moreInfo">' + checkLocaleForInfoButton() + '</a>' +
			'</div>\n' +
			'</div>' +
			'</div>';


		let infoWindow = new google.maps.InfoWindow({
			content: infoContent,
		});

		marker.addListener('click', infoCallback(infoWindow, marker));

		markers.push(marker);
	}

	function addMyMarker(location, map) {

		let marker = new google.maps.Marker({
			position: new google.maps.LatLng(location.lat, location.lng),
			draggable: false,
			map: map,
			animation: google.maps.Animation.DROP,
			icon: '../assets/images/map.svg'
		});

		let myInfoContent = '<div class="well">' +
			'<span style="color: red">I am here!</span>' +
			'</div>';

		let myInfoWindow = new google.maps.InfoWindow({
			content: myInfoContent,
		});

		marker.addListener('click', infoCallback(myInfoWindow, marker));
	}

	function handleLocationError(browserHasGeolocation, infoWindow, pos) {
		noty({
			text: browserHasGeolocation
				? 'Error: The Geolocation service failed.'
				: 'Error: Your browser doesn\'t support geolocation.',
			layout: 'topCenter',
			type: 'warning'
		});

	}

	// Sets the map on all markers in the array.
	function setMapOnAll(map) {
		for (let i = 0; i < markers.length; i++) {
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

	function checkImage(img) {
		return img !== ""
			? IMAGE_URL + img
			: './assets/images/No_Image_Available.png';
	}

	function checkLocaleForInfoButton() {
		return localeCode === 'EN' ? 'More Info' : '詳細資料';
	}
	function checkLocaleForDirectButton() {
		return localeCode === 'EN' ? 'Mark it to destination' : '設為目的地';
	}

	function infoCallback(infoWindow, marker) {
		return function () {
			//Close active window if exists
			if (activeWindow !== null)
				activeWindow.close();
			//Open new window
			infoWindow.open(map, marker);
			//Store new window in global variable
			activeWindow = infoWindow;
		};
	}

	function directTo(index, no) {

		preRememberIndex = index;

		directionsDisplay.setMap(null);

		axios.get(API_URL, { params: { lang: localeCode, format: 'json', no: no } })
			 .then(response => {

				 let request = {
					 origin: myLocation,
					 destination: {
						 lat: parseFloat(response.data.stationList.station[0].lat),
						 lng: parseFloat(response.data.stationList.station[0].lng)
					 },
					 travelMode: google.maps.TravelMode.DRIVING
				 };

				 directionsDisplay.setMap(map);
				 directionsDisplay.setPanel(document.getElementById('my-panel'));

				 deleteMarkers();

				 $('#btnResetMap').attr('disabled', false);
				 $('#btnTogglePanel').attr('disabled', false);
				 $('#btnRemember').attr('disabled', false);

				 addMarker(response.data.stationList.station[0]);

				 sidePanel = $('#my-panel').scotchPanel({
					 containerSelector: 'body', // As a jQuery Selector
					 direction: 'left', // Make it toggle in from the left
					 duration: 300, // Speed in ms how fast you want it to be
					 transition: 'ease', // CSS3 transition type: linear, ease, ease-in, ease-out, ease-in-out, cubic-bezier(P1x,P1y,P2x,P2y)
					 clickSelector: '.toggle-panel', // Enables toggling when clicking elements of this class
					 distanceX: '20%', // Size fo the toggle
					 enableEscapeKey: true // Clicking Esc will close the panel
				 });

				 sidePanel.open();

				 directionsService.route(request, function (response, status) {
					 if (status === google.maps.DirectionsStatus.OK) {
						 directionsDisplay.setDirections(response);
					 } else {
						 alert('Something goes wrong!\n' + status);
					 }
				 });
			 });
	}

	function getMoreInfo(no) {
		axios.get(API_URL, {
			params: {
				no: no,
				format: 'json',
				lang: localeCode
			}
		}).then(response => {
			let station = response.data.stationList.station[0];

			$('#infoImageBox').attr('href', checkImage(station.img));
			$('#infoImage').attr('src', checkImage(station.img))
						   .attr('width', 128)
						   .attr('height', 128);
			$('#infoLocation').html("<h5>" + station.location + "</h5>");
			$('#infoAddress').html("<h5>" + station.address.replace(/,/g, ",<br>") + "</h5>");
			$('#infoArea').html("<h5>" + station.districtL + "</h5>");
			$('#infoDistrict').html("<h5>" + station.districtS + "</h5>");
			$('#infoType').html('<h5><span class="label label-info">' + station.type.replace(/;/, " & ") + '</span></h5>');
			$('#infoProvider').html("<h5>" + station.provider + "</h5>");

			$('#infoModal').modal();
		});
	}

	function resetMap() {

		preRememberNo = 0;

		sidePanel.toggle();

		directionsDisplay.setMap(null);
		$('#search-modal').appendTo("body");
		$('#btnResetMap').attr('disabled', true);
		$('#btnTogglePanel').attr('disabled', true);
		$('#btnRemember').attr('disabled', true);
		$('body').removeClass('scotchified')
				 .removeAttr('jstcache');

		deleteMarkers();

		if (localeCode === 'EN') {
			enStations.forEach(function (item, index) {
				addMarker(item, map);
			});
		} else {
			tcStations.forEach(function (item, index) {
				addMarker(item, map);
			});
		}

		noty({
			text: localeCode === 'EN' ? 'Successfully reset map !' : '成功重設地圖 !',
			layout: 'topCenter',
			type: 'success',
			timeout: 3000
		});

		return false;
	}

	function togglePanel() {
		$('#btnTogglePanel').click(function () {
			sidePanel.toggle();

			$('#search-modal').appendTo("body");

			return false;
		});
	}

</script>

<script src="../assets/js/main.js"></script>

</body>
</html>