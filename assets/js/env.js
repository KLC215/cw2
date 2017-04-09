// Index url
const URL = document.URL;

// API urls
const API_URL = URL + 'api.php';
const ALL_STATIONS_URL_JSON_EN = API_URL + '?format=json&lang=en';
const ALL_DISTRICTS_URL_JSON_EN = API_URL + '?get=district&format=json&lang=en';
const ALL_STATION_TYPES_URL_JSON_EN = API_URL + '?get=type&format=json&lang=en';
const ALL_STATION_PROVIDERS_URL_JSON_EN = API_URL + '?get=provider&format=json&lang=en';
const ALL_DISTRICTS_URL_JSON_TC = API_URL + '?get=district&format=json&lang=tc';
const ALL_STATION_TYPES_URL_JSON_TC = API_URL + '?get=type&format=json&lang=tc';
const ALL_STATION_PROVIDERS_URL_JSON_TC = API_URL + '?get=provider&format=json&lang=tc';

// Locale url
const LOCALE_EN_URL = API_URL + '?en';
const LOCALE_TC_URL = API_URL + '?tc';

// Image url
const IMAGE_URL = "https://www.clp.com.hk";