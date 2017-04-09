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

let defaultLocale = 0;
let districts = [];
let areas = [];
let types = [];
let providers = [];

let areaData = {};
let districtData = {};

function requestDistricts() {
	areas = [];
	districts = [];

	$.get(localeCode === 'EN' ? ALL_DISTRICTS_URL_JSON_EN : ALL_DISTRICTS_URL_JSON_TC, function (response) {

		areaData = response.areas;
		districtData = response.districts;

		let id = 0;
		let areaId = 0;

		if (localeCode === 'EN') {
			id = 1;
			areaId = 1;
		} else {
			id = 1;
			areaId = 5;
		}

		// Create a area instance and store into array
		for (id; id <= Object.keys(areaData).length; id++) {
			areas.push(new Area(id, Object.values(areaData)[id - 1]));
		}

		if (localeCode === 'EN') {
			for (areaId; areaId <= Object.keys(districtData).length; areaId++) {

				let districtKeys = Object.keys(districtData[areaId]);

				let districtValues = _.values(districtData[areaId]);

				for (let j = 0; j < districtValues.length; j++) {

					let id = parseInt(districtKeys[j]);

					districts.push(new District(id, areaId, districtValues[j]));
				}
			}
		} else {
			let length = areaId + Object.keys(districtData).length - 1;

			for (areaId; areaId <= length; areaId++) {

				let districtKeys = Object.keys(districtData[areaId]);

				let districtValues = _.values(districtData[areaId]);

				for (let j = 0; j < districtValues.length; j++) {

					let id = parseInt(districtKeys[j]);

					districts.push(new District(id, areaId, districtValues[j]));
				}
			}
		}

		//// Create a district instance and store into array
		//for (areaId; areaId <= Object.keys(districtData).length; areaId++) {
		//
		//	let districtKeys = Object.keys(districtData[areaId]);
		//
		//	let districtValues = _.values(districtData[areaId]);
		//
		//	for (let j = 0; j < districtValues.length; j++) {
		//
		//		let id = parseInt(districtKeys[j]);
		//
		//		districts.push(new District(id, areaId, districtValues[j]));
		//	}
		//}

		let options = [];

		options.push(
			$('<option/>').attr("disabled", true)
						  .attr("selected", true)
						  .html(localeCode === 'EN' ? "Choose area" : "選擇 地區")
		);

		if (localeCode === 'EN') {
			for (let i = 0; i < areas.length; i++) {
				options.push(
					$('<option/>').attr("value", areas[i].id)
								  .html(areas[i].name)
				);
			}
		} else {
			for (let i = 0; i < areas.length; i++) {
				options.push(
					$('<option/>').attr("value", areas[i].id + 4)
								  .html(areas[i].name)
				);
			}
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
						  .html(localeCode === 'EN' ? "Choose type" : "選擇 充電站類型")
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
						  .html(localeCode === 'EN' ? "Choose provider" : "選擇 供應商")
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
function translate(data) {
	$("[tkey]").each(function (index) {
		let strTr = data[$(this).attr('tkey')];
		$(this).html(strTr);
	});
}

$(function () {

	$('#btnLocale').click(function () {

		if (localeCode === 'EN') {
			localeCode = 'TC';
			$.get(LOCALE_TC_URL, function (response) {
				translate(response);
				translateMarkers();

				requestDistricts();
				requestStationType();
				requestProvider();
			});
		} else {
			localeCode = 'EN';
			$.get(LOCALE_EN_URL, function (response) {
				translate(response);
				translateMarkers();

				requestDistricts();
				requestStationType();
				requestProvider();
			});
		}
	});

	$('#search-modal').on('hidden.bs.modal', function () {
		$('#selectSearch').val($("#selectSearch option:first").val());
		$('.childSearchForm').hide();
	});

	$('#selectSearch').change(function () {
		$('.childSearchForm').hide();
		$('#' + $(this).val()).show();
	});

	$('#btnHistory').click(function () {
		initHistoryList();
	});

	requestDistricts();
	requestStationType();
	requestProvider();

});

// Search selection chained
$("#and").find("#area").change(function () {

	let options = [];

	let areaId = parseInt($('#and').find('#area').val());


	options.push(
		$('<option/>').attr("disabled", true)
					  .attr("selected", true)
					  .html(localeCode === 'EN' ? "Choose district" : "請選擇 市區")
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
		$('#errorArea').html(localeCode === 'EN' ? "Please choose an area !" : "請選擇 地區！");
		return;
	}

	// Add has-error class and display error message when user doesn't choose district.
	if ($('#district').val() === null) {
		$('#selectDistrict').addClass('has-error');
		$('#errorDistrict').html(localeCode === 'EN' ? "Please choose a district !" : "請選擇 市區！");
		return;
	}

	// Get request to API with selected district value
	axios.get(API_URL, {
		params: {
			district: $('#district').val(),
			format: 'json',
			lang: localeCode,
		}
	})
		 .then(response => {

			 // Get stations array from response data
			 let stations = response.data.stationList.station;

			 // Delete all markers
			 deleteMarkers();

			 // Add markers on the map
			 stations.forEach(function (item, index) {
				 addMarker(item, map);
			 });

			 $('#search-modal').modal('toggle');

			 notyCompletedSearch();

		 });
});
$('#searchType').click(function () {

	// Remove has-error class and error message in area form group
	$('#selectType').removeClass('has-error');
	$('#errorType').empty();

	// Add has-error class and display error message when user doesn't choose area.
	if ($('#type').val() === null) {
		$('#selectType').addClass('has-error');
		$('#errorType').html(localeCode === 'EN' ? "Please choose a station type !" : "請選擇 充電站類型！");
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

			 // Get stations array from response data
			 let stations = response.data.stationList.station;

			 // Delete all markers
			 deleteMarkers();

			 // Add markers on the map
			 stations.forEach(function (item, index) {
				 addMarker(item, map);
			 });

			 $('#search-modal').modal('toggle');

			 notyCompletedSearch();
		 });
});
$('#searchProvider').click(function () {

	// Remove has-error class and error message in area form group
	$('#selectProvider').removeClass('has-error');
	$('#errorProvider').empty();

	// Add has-error class and display error message when user doesn't choose area.
	if ($('#provider').val() === null) {
		$('#selectProvider').addClass('has-error');
		$('#errorProvider').html(localeCode === 'EN' ? "Please choose a station provider !" : "請選擇 供應商！");
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

			 // Get stations array from response data
			 let stations = response.data.stationList.station;

			 // Delete all markers
			 deleteMarkers();

			 // Add markers on the map
			 stations.forEach(function (item, index) {
				 addMarker(item, map);
			 });

			 $('#search-modal').modal('toggle');

			 notyCompletedSearch();

		 });
});

function notyCompletedSearch() {
	noty({
		text: localeCode === 'EN' ? 'Successfully search !' : '搜尋成功 !',
		layout: 'topCenter',
		type: 'success',
		timeout: 3000
	});
	$('.childSearchForm').hide();
}

function initHistoryList() {
	let locations = localStorage.getItem("location");

	if(locations.length) {
		for (let i = 0; i < locations.length; i++) {
			if(localeCode === 'EN') {
				$('#historyList').append(
					$('li').attr('id', enStations[locations[i]].no)
						   .html('No: ' + enStations[locations[i]].no + '<br>' + enStations[locations[i]].location)
				);
			} else {
				$('#historyList').append(
					$('li').attr('id', tcStations[locations[i]].no)
						   .html('No: ' + tcStations[locations[i]].no + '<br>' + tcStations[locations[i]].location)
				);
			}
		}
	}
}
