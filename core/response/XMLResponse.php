<?php


/**
 * Class XMLResponse
 */
class XMLResponse
{
	const XML_FORMAT = 'xml';

	/**
	 * Set XML header
	 *
	 * @param $header
	 */
	private static function setXMLHeader($header)
	{
		header("Content-Type: text/xml");
		echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
		echo "<$header>\n";
	}

	/**
	 * Convert station data to XML format
	 *
	 * @param       $rootTag
	 * @param       $tag
	 * @param array $stations
	 */
	public static function xmlStations($rootTag, $tag, $stations = [])
	{
		// Generate XML header
		XMLResponse::setXMLHeader($rootTag);

		// Generate XML body
		for ($i = 0; $i < sizeof($stations); $i++) {

			echo "\t<$tag no=\"{$stations[$i]['no']}\">\n";

			foreach ($stations[$i] as $key => $val) {

				if ($key != 'no') {
					echo "\t\t<$key>" . htmlspecialchars($val) . "</$key>\n";
				}

			}

			echo "\t</$tag>\n";
		}

		// Generate XML footer
		XMLResponse::setXMLFooter($rootTag);

	}

	public static function xmlError($rootTag, $tag, $msg = [])
	{
		XMLResponse::setXMLHeader($rootTag);

		echo "\t<$tag>\n";

		foreach ($msg[$tag] as $key => $val) {

			echo "\t\t<$key>" . htmlspecialchars($val) . "</$key>\n";

		}

		echo "\t</$tag>\n";

		XMLResponse::setXMLFooter($rootTag);
	}

	/**
	 * Set XML footer
	 *
	 * @param $footer
	 */
	private static function setXMLFooter($footer)
	{
		echo "</$footer>\n";
		exit();
	}
}