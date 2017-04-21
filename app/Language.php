<?php

class Language extends RESTful
{
	public static $languages = [];

	public static function getLocale()
	{
		if (isset($_GET['en'])) {
			self::getEN();
		} else if(isset($_GET['tc'])) {
			self::getTC();
		}
	}

	public static function getTC()
	{
		JSONResponse::jsonDistrict(require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/app/langs/TC.php'));
	}

	public static function getEN()
	{
		JSONResponse::jsonDistrict(require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/app/langs/EN.php'));
	}


	public static function getLanguages()
	{
		$db = new DatabaseConnection();

		$pdo = $db->connect();

		if(!$pdo) {
			JSONResponse::jsonMessage(self::responseErrorInService());
			die();
		}

		$query = $pdo->prepare(
			"SELECT lang.code
				FROM lang;"
		);

		$query->execute();

		$languages = $query->fetchAll(PDO::FETCH_ASSOC);

		for ($i =0; $i<sizeof($languages); $i++) {
			 self::$languages[] = $languages[$i]['code'];
		}
	}
}