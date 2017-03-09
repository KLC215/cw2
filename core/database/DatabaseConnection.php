<?php

/**
 * Class PDO
 */
class DatabaseConnection
{
	/**
	 * @var string
	 */
	private $pdo_connection = 'mysql:host=127.0.0.1';

	/**
	 * @var string
	 */
	private $pdo_dbName = 'cw2';

	/**
	 * @var string
	 */
	private $pdo_username = 'root';

	/**
	 * @var string
	 */
	private $pdo_password = 'root';

	/**
	 * @var array
	 */
	private $pdo_options = [
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
	];

	/**
	 * Connect database with PDO
	 *
	 * @return PDO
	 */
	public function connect()
	{
		try {
			return new PDO(
				$this->pdo_connection . ';dbname=' . $this->pdo_dbName,
				$this->pdo_username,
				$this->pdo_password,
				$this->pdo_options
			);
		} catch (PDOException $e) {

		}
	}
}