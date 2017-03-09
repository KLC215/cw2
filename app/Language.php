<?php

class Language extends RESTful
{
	public static $languages = [];

	public static function getLanguages()
	{
		$db = new DatabaseConnection();

		$pdo = $db->connect();

		if(!$pdo) {
			JSONResponse::jsonError(self::responseErrorInService());
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