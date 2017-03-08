<?php


class JSONResponse
{
	public function jsonStations($stations = [])
	{
		echo json_encode($stations, JSON_PRETTY_PRINT);
	}
}