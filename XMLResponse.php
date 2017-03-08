<?php


class XMLResponse
{
	private $rootTag;

	/**
	 * XMLResponse constructor.
	 *
	 * @param $rootTag
	 */
	public function __construct($rootTag)
	{
		$this->rootTag = $rootTag;
	}

	public function xmlHeader($header)
	{
		header("Content-Type: text/xml");
		echo '<?xml version="1.0" encoding="UTF-8"?>'. "\n";
		echo "<$header>\n";
	}

	public function xmlStations($tag, $no, $params = [])
	{
		// Generate XML header
		$this->xmlHeader($this->rootTag);

		// Generate XML body
		echo "\t<$tag no=\"$no\">\n";

		if($params) {
			foreach($params as $key => $val) {
				echo "\t\t<$key>" . htmlspecialchars($val) . "</$key>\n";
			}
		}

		echo "\t</$tag>\n";

		// Generate XML footer
		$this->xmlFooter($this->rootTag);

	}

	public function xmlFooter($footer)
	{
		echo "</$footer>\n";
		exit();
	}
}