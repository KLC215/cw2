<?php
require ROOT_PATH . "/core/DataConverter.php";
require ROOT_PATH . "/core/response/XMLResponse.php";
require ROOT_PATH . "/core/response/JSONResponse.php";
require ROOT_PATH . "/app/Station.php";
require ROOT_PATH . "/app/Language.php";
require ROOT_PATH . "/app/District.php";
require ROOT_PATH . "/app/StationType.php";
require ROOT_PATH . "/app/StationProvider.php";

// Convert data
$dataConverter = new DataConverter();
$dataConverter->convertData();

// Get language and store into variable in Language Class
Language::getLanguages();

// Get station data and show to user
$station = new Station();
$station->getStationData();

// Get district data
$district = new District();
$district->getDistrictData();

// Get station type data
$type = new StationType();
$type->getStationTypeData();

// Get station provider data
$provider = new StationProvider();
$provider->getStationProviderData();