<?php
require __DIR__ . '/database/DatabaseConnection.php';

/**
 * Class DataConverter
 */
class DataConverter
{
	/**
	 * @var PDO
	 */
	private $pdo;

	/**
	 * @var array
	 */
	private $tables = [];

	/**
	 * @var array
	 */
	private $urls = [
		'https://opendata.clp.com.hk/GetChargingSectionXML.aspx?lang=EN',
		'https://opendata.clp.com.hk/GetChargingSectionXML.aspx?lang=TC',
	];

	/**
	 * @var bool
	 */
	private $stationInserted = false;

	/**
	 * DataConverter constructor.
	 */
	public function __construct()
	{
		$db = new DatabaseConnection();

		$this->pdo = $db->connect();

		$this->getTablesName();
	}

	/**
	 *    Convert xml data from urls to database
	 */
	public function convertData()
	{
		if($this->checkDataExist()) {
			return;
		}

		foreach ($this->urls as $url) {

			try {
				$xml = simplexml_load_file($url);

				//var_dump(sizeof($xml->stationList->station));

				//var_dump($this->getDistrictId('Wong Tai Sin'));

				$this->insertLanguages($xml);

				$this->insertAreasAndDistricts($xml);

				$this->insertStations($xml);


			} catch (Exception $e) {
				die($e->getMessage());
			}

		}
	}

	/**
	 * Insert record into a table
	 *
	 * @param $table
	 * @param $params
	 */
	private function insert($table, $params)
	{
		$sql = sprintf(
			'insert into %s (%s) values (%s)',
			$table,
			implode(', ', array_keys($params)),
			':' . implode(', :', array_keys($params))
		);
		try {
			$statement = $this->pdo->prepare($sql);
			$statement->execute($params);
		} catch (Exception $e) {
			die($e->getMessage());
		}
	}

	/**
	 * Insert all languages to database
	 *
	 * @param $xml
	 */
	private function insertLanguages($xml)
	{
		$this->insert($this->tables['lang'], [
			'code' => $xml->Language,
		]);
	}

	/**
	 * Insert all areas and districts to database
	 *
	 * @param $xml
	 */
	private function insertAreasAndDistricts($xml)
	{
		for ($i = 0; $i < sizeof($xml->areaList->area); $i++) {

			// Insert areas
			$this->insert($this->tables['areas_lang'], [
				'lang' => $xml->Language,
				'name' => $xml->areaList->area[$i]->name,
			]);

			$lastInsertAreaId = $this->pdo->lastInsertId();

			for ($j = 0; $j < sizeof($xml->areaList->area[$i]->districtList->district); $j++) {

				// Insert districts
				$this->insert($this->tables['districts_lang'], [
					'area' => $lastInsertAreaId,
					'lang' => $xml->Language,
					'name' => $xml->areaList->area[$i]->districtList->district[$j]->name,
				]);

			}

		}
	}

	/**
	 * Insert all stations to database
	 *
	 * @param $xml
	 */
	private function insertStations($xml)
	{
		for ($i = 0; $i < sizeof($xml->stationList->station); $i++) {

			if (!$this->stationInserted) {
				$this->insert($this->tables['stations'], [
					'no'  => $xml->stationList->station[$i]->no,
					'img' => $xml->stationList->station[$i]->img,
				]);
			}

			$lastInsertStationId = $this->stationInserted
				? $this->getStationId($xml->stationList->station[$i]->no)[0]->id
				: $this->pdo->lastInsertId();

			$this->insert($this->tables['stations_lang'], [
				'station'    => $lastInsertStationId,
				'lang'       => $xml->Language,
				'district'   => $this->getDistrictId($xml->stationList->station[$i]->districtS)[0]->id,
				'location'   => $xml->stationList->station[$i]->location,
				'latitude'   => $xml->stationList->station[$i]->lat,
				'longitude'  => $xml->stationList->station[$i]->lng,
				'type'       => $xml->stationList->station[$i]->type,
				'address'    => $xml->stationList->station[$i]->address,
				'provider'   => $xml->stationList->station[$i]->provider,
				'parking_no' => $xml->stationList->station[$i]->parkingNo,
			]);
		}

		$this->stationInserted = true;
	}

	/**
	 *    Get all tables name
	 */
	private function getTablesName()
	{
		$result = $this->pdo->query('show tables');

		while ($row = $result->fetch(PDO::FETCH_OBJ)) {
			$this->tables[$row->Tables_in_cw2] = $row->Tables_in_cw2;
		}

		//var_dump($this->tables);
	}

	/**
	 * @param $district
	 *
	 * @return array
	 */
	private function getDistrictId($district)
	{
		$query = $this->pdo->prepare(
			"select id from {$this->tables['districts_lang']}
			where name = '{$district}'"
		);

		$query->execute();

		return $query->fetchAll(PDO::FETCH_OBJ);
	}

	/**
	 * @param $stationNo
	 *
	 * @return array
	 */
	private function getStationId($stationNo)
	{
		$query = $this->pdo->prepare(
			"select id from {$this->tables['stations']}
			where no = '{$stationNo}'"
		);

		$query->execute();

		return $query->fetchAll(PDO::FETCH_OBJ);
	}

	/**
	 * Check if data are existed in database
	 *
	 * @return bool
	 */
	private function checkDataExist()
	{
		$query = $this->pdo->prepare(
			"SELECT *
			  FROM lang;"
		);

		$query->execute();

		if ($query->rowCount() > 0) {
			return true;
		}

		return false;
	}

}