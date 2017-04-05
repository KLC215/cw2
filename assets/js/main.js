/**
 * Hong Kong area
 *
 * @param id    Area id
 * @param name    Area name
 * @constructor
 */
let Area = function (id, name) {
	this.id = id;
	this.name = name;
};
Area.prototype.getId = function () {
	return this.id;
};
Area.prototype.getName = function () {
	return this.name;
};


/**
 *    Hong Kong district
 *
 * @param id        District id
 * @param areaId    Parent Id
 * @param name        District name
 * @constructor
 */
let District = function (id, areaId, name) {
	this.id = id;
	this.areaId = areaId;
	this.name = name;
};
District.prototype.getId = function () {
	return this.id;
};
District.prototype.getAreaId = function () {
	return this.areaId;
};
District.prototype.getName = function () {
	return this.name;
};


let districts = [];
let areas = [];
let types = [];
let providers = [];

let areaData = {};
let districtData = {};

function requestDistricts() {
	$.get(ALL_DISTRICTS_URL_JSON_EN, function (response) {

		areaData = response.areas;
		districtData = response.districts;

		// Create a area instance and store into array
		for (let id = 1; id <= Object.keys(areaData).length; id++) {
			areas.push(new Area(id, Object.values(areaData)[id - 1]));
		}

		// Create a district instance and store into array
		for (let areaId = 1; areaId <= Object.keys(districtData).length; areaId++) {

			let districtKeys = Object.keys(districtData[areaId]);
			let districtValues = _.values(districtData[areaId]);

			for (let j = 0; j < districtValues.length; j++) {

				let id = parseInt(districtKeys[j]);

				districts.push(new District(id, areaId, districtValues[j]));
			}
		}

		let options = [];

		options.push(
			$('<option/>').attr("disabled", true)
						  .attr("selected", true)
						  .html("Choose area")
		);

		for (let i = 0; i < areas.length; i++) {
			options.push(
				$('<option/>').attr("value", areas[i].id)
							  .html(areas[i].name)
			);
		}

		$('#and').find('#area').html(options);
	});
}
function requestStationType() {
	$.get(ALL_STATION_TYPES_URL_JSON_EN, function (response) {
		types = response;

		let options = [];

		options.push(
			$('<option/>').attr("disabled", true)
						  .attr("selected", true)
						  .html("Choose type")
		);

		types.forEach((item, index) => {
			options.push(
				$('<option/>').attr("value", item.type)
							  .html(item.type.replace(/;/, " & "))
			);
		});

		$('#type').html(options);
	});
}
function requestProvider() {
	$.get(ALL_STATION_PROVIDERS_URL_JSON_EN, function (response) {

		providers = response;

		let options = [];

		options.push(
			$('<option/>').attr("disabled", true)
						  .attr("selected", true)
						  .html("Choose provider")
		);

		providers.forEach((item, index) => {
			options.push(
				$('<option/>').attr("value", item.provider)
							  .html(item.provider)
			);
		});

		$('#provider').html(options);
	});
}


$(function () {

	$('#search-modal').on('hidden.bs.modal', function () {
		$('#selectSearch').val($("#selectSearch option:first").val());
		$('.childSearchForm').hide();
	});

	$('#selectSearch').change(function () {
		$('.childSearchForm').hide();
		$('#' + $(this).val()).show();
	});

	requestDistricts();
	requestStationType();
	requestProvider();

});

// Search selection chained
$("#and").find("#area").change(function () {

	//console.log(districts);

	let options = [];

	let areaId = parseInt($('#and').find('#area').val());

	options.push(
		$('<option/>').attr("disabled", true)
					  .attr("selected", true)
					  .html("Choose district")
	);

	for (let i = 0; i < districts.length; i++) {

		if (districts[i].areaId === areaId) {
			options.push($("<option/>").attr("value", districts[i].id).html(districts[i].name));
		}
	}

	$("#and").find("#district").html(options).prop('disabled', areaId === 0);
});

//	Search button click events in search modal
$('#searchAND').click(function () {

	// Remove has-error class and error message in area form group
	$('#selectArea').removeClass('has-error');
	$('#errorArea').empty();

	// Remove has-error class and error message in district form group
	$('#selectDistrict').removeClass('has-error');
	$('#errorDistrict').empty();

	// Add has-error class and display error message when user doesn't choose area.
	if ($('#area').val() === null) {
		$('#selectArea').addClass('has-error');
		$('#errorArea').html("Please choose an area !");
		return;
	}

	// Add has-error class and display error message when user doesn't choose district.
	if ($('#district').val() === null) {
		$('#selectDistrict').addClass('has-error');
		$('#errorDistrict').html("Please choose a district !");
		return;
	}

	// Get request to API with selected district value
	axios.get(API_URL, {
		params: {
			district: $('#district').val(),
			format: 'json',
			lang: 'en',
		}
	})
		 .then(response => {
			 console.log(response);

			 // Get stations array from response data
			 let stations = response.data.stationList.station;

			 // Delete all markers
			 deleteMarkers();

			 // Add markers on the map
			 stations.forEach(function (item, index) {
				 addMarker(item, map);
			 });

			 $('#search-modal').modal('toggle');

		 });
});
$('#searchType').click(function () {

	// Remove has-error class and error message in area form group
	$('#selectType').removeClass('has-error');
	$('#errorType').empty();

	// Add has-error class and display error message when user doesn't choose area.
	if ($('#type').val() === null) {
		$('#selectType').addClass('has-error');
		$('#errorType').html("Please choose a station type !");
		return;
	}

	// Get request to API with selected station type value
	axios.get(API_URL, {
		params: {
			type: $('#type').val(),
			format: 'json',
			lang: 'en',
		}
	})
		 .then(response => {
			 console.log(response);

			 // Get stations array from response data
			 let stations = response.data.stationList.station;

			 // Delete all markers
			 deleteMarkers();

			 // Add markers on the map
			 stations.forEach(function (item, index) {
				 addMarker(item, map);
			 });

			 $('#search-modal').modal('toggle');

		 });
});
$('#searchProvider').click(function () {

	// Remove has-error class and error message in area form group
	$('#selectProvider').removeClass('has-error');
	$('#errorProvider').empty();

	// Add has-error class and display error message when user doesn't choose area.
	if ($('#provider').val() === null) {
		$('#selectProvider').addClass('has-error');
		$('#errorProvider').html("Please choose a station provider !");
		return;
	}

	// Get request to API with selected station type value
	axios.get(API_URL, {
		params: {
			provider: $('#provider').val(),
			format: 'json',
			lang: 'en',
		}
	})
		 .then(response => {
			 console.log(response);

			 // Get stations array from response data
			 let stations = response.data.stationList.station;

			 // Delete all markers
			 deleteMarkers();

			 // Add markers on the map
			 stations.forEach(function (item, index) {
				 addMarker(item, map);
			 });

			 $('#search-modal').modal('toggle');

		 });
});

