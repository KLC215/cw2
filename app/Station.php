<?php
require_once(ROOTPATH . '/core/response/RESTful.php');
require_once(ROOTPATH . '/core/response/ResponseFormat.php');
require_once(ROOTPATH . '/core/database/DatabaseConnection.php');


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
		if (!isset($_GET['no'])) {
			$this->selectAllStations();
		} else {
			$this->selectSpecificStation($_GET['no']);
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

	public function setPdo($pdo)
	{
		$this->pdo = $pdo;
	}

	public function setFormat()
	{
		$this->format =
			isset($_GET['format']) && $_GET['format'] != ''
				? strtolower($_GET['format'])
				: '';
	}

	public function setLang()
	{
		$this->lang =
			isset($_GET['lang']) && $_GET['lang'] != ''
				? strtoupper($_GET['lang'])
				: '';
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
				$this->responseParamNotRecognized('Empty')
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
				JSONResponse::jsonError($error);
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