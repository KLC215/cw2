<?php
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/core/database/DatabaseConnection.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/core/helpers.php');

class District
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

	public function getDistrictData()
	{
		if (isset($_GET['get']) &&
			!empty($_GET['get']) &&
			$_GET['get'] == 'district'
		) {
			$this->selectDistricts();
		}
	}

	public function selectDistricts()
	{
		$areas = [];
		$districts = [];

		$query = $this->pdo->prepare(
			"SELECT
				  dl.id as district_id,
				  dl.area as area_id,
				  al.name as area,
				  dl.name as district
				FROM districts_lang dl, areas_lang al
				WHERE dl.lang = '{$this->lang}' AND dl.area = al.id;"
		);

		$query->execute();


		if ($query->rowCount() <= 0) {
			JSONResponse::jsonMessage("Cannot fetch districts");
			die();
		}

		$data = $query->fetchAll(PDO::FETCH_OBJ);

		//dd($data);

		foreach ($data as $datum) {
			if (!in_array($datum->area, $areas)) {
				$areas[$datum->area_id] = $datum->area;
			}
			if (!in_array($datum->district, $districts)) {
				$districts[$datum->area_id][$datum->district_id] = $datum->district;
			}
		}

		$json = [
			'areas'     => $areas,
			'districts' => $districts,
		];

		JSONResponse::jsonDistrict($json);
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

}

/*if (isset($_GET['lang']) && !empty($_GET['lang'])) {

	$lang = strtoupper($_GET['lang']);

	$areas = [];
	$districts = [];

	$query = $pdo->prepare(
		"SELECT
				  dl.id as district_id,
				  dl.area as area_id,
				  al.name as area,
				  dl.name as district
				FROM districts_lang dl, areas_lang al
				WHERE dl.lang = '{$lang}' AND dl.area = al.id;"
	);

	$query->execute();

	$data = $query->fetchAll(PDO::FETCH_OBJ);

	//dd($data);

	foreach ($data as $datum) {
		if (!in_array($datum->area, $areas)) {
			$areas[$datum->area_id] = $datum->area;
		}
		if (!in_array($datum->district, $districts)) {
			$districts[$datum->area_id][$datum->district_id] = $datum->district;
		}
	}

	$json = [
		'areas'     => $areas,
		'districts' => $districts,
	];

	JSONResponse::jsonDistrict($json);

} else {
	JSONResponse::jsonError("Cannot fetch districts");
}*/