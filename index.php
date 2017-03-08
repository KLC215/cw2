<?php
require 'DataConverter.php';
require 'XMLResponse.php';
require 'JSONResponse.php';

//$dataConverter = new DataConverter();

//$dataConverter->convertData();

//$xml = new XMLResponse('stationList');
//
//$xml->xmlStations('station', 1, [
//	'foo'  => 'bar',
//	'bar'  => 'foo',
//	'John' => 'Doe',
//]);

$stationList = [
	'stationList' => [
		['station' => [
			'no'   => 1,
			'dasd' => 'dadas',
			'adas' => 'dadas',
		]],
		['station' => [
			'no'   => 2,
			'dasd' => 'dadas',
			'adas' => 'dadas',
		]],
		['station' => [
			'no'   => 3,
			'dasd' => 'dadas',
			'adas' => 'dadas',
		]],
	],
];

$json = new JSONResponse();
$json->jsonStations($stationList);


