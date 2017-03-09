<?php
require ROOT_PATH . "/core/DataConverter.php";
require ROOT_PATH . "/core/response/XMLResponse.php";
require ROOT_PATH . "/core/response/JSONResponse.php";
require ROOT_PATH . "/app/Station.php";
require ROOT_PATH . "/app/Language.php";

// Convert data to database
$dataConverter = new DataConverter();
$dataConverter->convertData();

// Get language and store into variable in Language Class
Language::getLanguages();

// Get station data and show to user
$station = new Station();
$station->getStationData();