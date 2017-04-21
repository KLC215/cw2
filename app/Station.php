<?php
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/core/response/RESTful.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/core/response/ResponseFormat.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/core/database/DatabaseConnection.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/core/helpers.php');

/**
 * Class Station
 */
class Station extends RESTful
{
	private $pdo;
	private $format;
	private $lang;

	public function __construct()
	{
		$db = new DatabaseConnection();

		$this->setPdo($db->connect());
		$this->setFormat();
		$this->setLang();

	}

	public function getStationData()
	{
		if (!isset($_GET['no']) &&
			!isset($_GET['district']) &&
			!isset($_GET['type']) &&
			!isset($_GET['provider']) &&
			!isset($_GET['get']) &&
			!isset($_GET['en']) &&
			!isset($_GET['tc'])
		) {
			$this->selectAllStations();
		}
		if (isset($_GET['no'])) {
			$this->selectSpecificStation($_GET['no']);
		}
		if (isset($_GET['district'])) {
			$this->selectStationsByDistrict($_GET['district']);
		}
		if (isset($_GET['type'])) {
			$this->selectStationsByType($_GET['type']);
		}
		if (isset($_GET['provider'])) {
			$this->selectStationsByProvider($_GET['provider']);
		}
	}

	/**
	 *    Select all stations and show to user
	 */
	public function selectAllStations()
	{
		$this->checkErrors();

		$query = $this->pdo->prepare(
			"SELECT
			  s.no,
			  sl.location,
			  sl.latitude  AS lat,
			  sl.longitude AS lng,
			  sl.type,
			  al.name      AS districtL,
			  dl.name      AS districtS,
			  sl.address,
			  sl.provider,
			  sl.parking_no,
			  s.img
			FROM stations s
			  INNER JOIN stations_lang sl ON s.id = sl.station
			  INNER JOIN districts_lang dl ON sl.district = dl.id
			  INNER JOIN areas_lang al ON dl.area = al.id
			  INNER JOIN lang l ON sl.lang = l.code
			WHERE l.code = '{$this->lang}'
			ORDER BY s.no;"
		);

		$query->execute();

		if ($this->format == XMLResponse::XML_FORMAT) {
			$this->showDataResponse($this->format, $query->fetchAll(PDO::FETCH_ASSOC));
		} else {
			$this->showDataResponse($this->format, $query->fetchAll(PDO::FETCH_OBJ));
		}

	}

	/**
	 *    Select specific station and show to user
	 */
	public function selectSpecificStation($id)
	{
		$this->checkErrors();

		if (!is_numeric($id)) {
			$this->showErrorResponse(
				$this->getFormat(),
				$this->responseNumberNotRecognized()
			);
			die();
		}

		$query = $this->pdo->prepare(
			"SELECT
			  s.no,
			  sl.location,
			  sl.latitude  AS lat,
			  sl.longitude AS lng,
			  sl.type,
			  al.name      AS districtL,
			  dl.name      AS districtS,
			  sl.address,
			  sl.provider,
			  sl.parking_no,
			  s.img
			FROM stations s
			  INNER JOIN stations_lang sl ON s.id = sl.station
			  INNER JOIN districts_lang dl ON sl.district = dl.id
			  INNER JOIN areas_lang al ON dl.area = al.id
			  INNER JOIN lang l ON sl.lang = l.code
			WHERE l.code = '{$this->lang}' AND s.no = {$id}
			ORDER BY s.no;"
		);

		$query->execute();

		if ($query->rowCount() <= 0) {
			$this->showErrorResponse(
				$this->getFormat(),
				$this->responseNumberNotRecognized()
			);
			die();
		}

		if ($this->format == XMLResponse::XML_FORMAT) {
			$this->showDataResponse($this->format, $query->fetchAll(PDO::FETCH_ASSOC));
		} else {
			$this->showDataResponse($this->format, $query->fetchAll(PDO::FETCH_OBJ));
		}
	}

	private function selectStationsByDistrict($district)
	{
		if (!$district) {
			$this->showErrorResponse(
				$this->getFormat(),
				$this->responseMissingParam()
			);
			die();
		}

		$query = $this->pdo->prepare(
			"SELECT
			  s.no,
			  sl.location,
			  sl.latitude  AS lat,
			  sl.longitude AS lng,
			  sl.type,
			  al.name      AS districtL,
			  dl.name      AS districtS,
			  sl.address,
			  sl.provider,
			  sl.parking_no,
			  s.img
			FROM stations s
			  INNER JOIN stations_lang sl ON s.id = sl.station
			  INNER JOIN districts_lang dl ON sl.district = dl.id
			  INNER JOIN areas_lang al ON dl.area = al.id
			  INNER JOIN lang l ON sl.lang = l.code
			WHERE l.code = '{$this->lang}' AND sl.district = {$district}
			ORDER BY s.no;"
		);

		$query->execute();

		if ($query->rowCount() <= 0) {
			$this->showErrorResponse(
				$this->getFormat(),
				$this->responseNumberNotRecognized()
			);
			die();
		}

		if ($this->format == JSONResponse::JSON_FORMAT) {
			JSONResponse::jsonStations($query->fetchAll(PDO::FETCH_OBJ));
		}

	}

	public function selectStationsByType($type)
	{
		if (!$type) {
			$this->showErrorResponse(
				$this->getFormat(),
				$this->responseMissingParam()
			);
			die();
		}

		$query = $this->pdo->prepare(
			"SELECT
			  s.no,
			  sl.location,
			  sl.latitude  AS lat,
			  sl.longitude AS lng,
			  sl.type,
			  al.name      AS districtL,
			  dl.name      AS districtS,
			  sl.address,
			  sl.provider,
			  sl.parking_no,
			  s.img
			FROM stations s
			  INNER JOIN stations_lang sl ON s.id = sl.station
			  INNER JOIN districts_lang dl ON sl.district = dl.id
			  INNER JOIN areas_lang al ON dl.area = al.id
			  INNER JOIN lang l ON sl.lang = l.code
			WHERE l.code = '{$this->lang}' AND sl.type = '{$type}'
			ORDER BY s.no;"
		);

		$query->execute();

		if ($query->rowCount() <= 0) {
			$this->showErrorResponse(
				$this->getFormat(),
				$this->responseNumberNotRecognized()
			);
			die();
		}

		if ($this->format == JSONResponse::JSON_FORMAT) {
			JSONResponse::jsonStations($query->fetchAll(PDO::FETCH_OBJ));
		}
	}

	public function selectStationsByProvider($provider)
	{
		if (!$provider) {
			$this->showErrorResponse(
				$this->getFormat(),
				$this->responseMissingParam()
			);
			die();
		}

		$query = $this->pdo->prepare(
			"SELECT
			  s.no,
			  sl.location,
			  sl.latitude  AS lat,
			  sl.longitude AS lng,
			  sl.type,
			  al.name      AS districtL,
			  dl.name      AS districtS,
			  sl.address,
			  sl.provider,
			  sl.parking_no,
			  s.img
			FROM stations s
			  INNER JOIN stations_lang sl ON s.id = sl.station
			  INNER JOIN districts_lang dl ON sl.district = dl.id
			  INNER JOIN areas_lang al ON dl.area = al.id
			  INNER JOIN lang l ON sl.lang = l.code
			WHERE l.code = '{$this->lang}' AND sl.provider = '{$provider}'
			ORDER BY s.no;"
		);

		$query->execute();

		if ($query->rowCount() <= 0) {
			$this->showErrorResponse(
				$this->getFormat(),
				$this->responseNumberNotRecognized()
			);
			die();
		}

		if ($this->format == JSONResponse::JSON_FORMAT) {
			JSONResponse::jsonStations($query->fetchAll(PDO::FETCH_OBJ));
		}
	}

	public function setPdo($pdo)
	{
		$this->pdo = $pdo;
	}

	public function setFormat()
	{
		$this->format = correctFormat();
	}

	public function setLang()
	{
		$this->lang = correctLang();
	}

	/**
	 *  Check errors before showing data
	 */
	private function checkErrors()
	{
		if (!$this->pdo) {
			$this->showErrorResponse(
				$this->getFormat(),
				$this->responseErrorInService()
			);
			die();
		}

		if (!isset($_GET['format']) || !isset($_GET['lang'])) {
			$this->showErrorResponse(
				$this->getFormat(),
				$this->responseMissingParam()
			);
			die();
		}

		if ($this->format == '' || $this->lang == '') {
			$this->showErrorResponse(
				$this->getFormat(),
				$this->responseParamNotRecognized()
			);
			die();
		}


		if (!in_array($this->format, ResponseFormat::$formats)
			|| !in_array($this->lang, Language::$languages)
		) {
			$this->showErrorResponse(
				$this->getFormat(),
				$this->responseParamNotRecognized()
			);
			die();
		}

		if (isset($_GET['no']) && $_GET['no'] == '') {
			$this->showErrorResponse(
				$this->getFormat(),
				$this->responseParamNotRecognized()
			);
			die();
		}

	}

	/**
	 * Choose correct format and show data response
	 *
	 * @param $format
	 * @param $data
	 */
	private function showDataResponse($format, $data)
	{
		switch ($format) {
			case XMLResponse::XML_FORMAT:
				XMLResponse::xmlStations('stationList', 'station', $data);
				break;
			case JSONResponse::JSON_FORMAT:
				JSONResponse::jsonStations($data);
				break;
		}
	}

	/**
	 * Choose correct format and show error response
	 *
	 * @param $format
	 * @param $error
	 */
	private function showErrorResponse($format, $error)
	{
		switch ($format) {
			case XMLResponse::XML_FORMAT:
				XMLResponse::xmlError('stationList', 'error', $error);
				break;
			case JSONResponse::JSON_FORMAT:
				JSONResponse::jsonMessage($error);
				break;
		}
	}

	/**
	 * Get correct response format, default is json format
	 *
	 * @return string
	 */
	private function getFormat()
	{
		return in_array($this->format, ResponseFormat::$formats)
			? $this->format
			: 'json';
	}

}