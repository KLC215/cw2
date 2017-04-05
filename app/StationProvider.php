<?php
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/core/database/DatabaseConnection.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/core/helpers.php');

class StationProvider
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

	public function getStationProviderData()
	{
		if (isset($_GET['get']) &&
			!empty($_GET['get']) &&
			$_GET['get'] == 'provider'
		) {
			$this->selectStationProviders();
		}
	}

	public function selectStationProviders()
	{
		$query = $this->pdo->prepare(
			"SELECT DISTINCT provider
			  FROM stations_lang;"
		);

		$query->execute();

		if ($query->rowCount() <= 0) {
			JSONResponse::jsonError("Cannot fetch station providers");
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