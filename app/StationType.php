<?php
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/core/database/DatabaseConnection.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/core/helpers.php');

class StationType
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

	public function getStationTypeData()
	{
		if (isset($_GET['get']) &&
			!empty($_GET['get']) &&
			$_GET['get'] == 'type'
		) {
			$this->selectStationTypes();
		}
	}

	public function selectStationTypes()
	{
		$query = $this->pdo->prepare(
			"SELECT DISTINCT type
			  FROM stations_lang;"
		);

		$query->execute();

		if ($query->rowCount() <= 0) {
			JSONResponse::jsonMessage("Cannot fetch station types");
			die();
		}

		JSONResponse::jsonStationType($query->fetchAll(PDO::FETCH_OBJ));
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