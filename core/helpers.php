<?php

/**
 * Die and var dump a variable
 *
 * @param $var
 */
function dd($var)
{
	echo "<pre>" . var_dump($var) . "</pre>";
	die();
}


/**
 *    Set correct format
 */
function correctFormat()
{
	return isset($_GET['format']) && !empty($_GET['format'])
		? strtolower($_GET['format'])
		: '';
}

/**
 *    Set correct language
 */
function correctLang()
{
	return isset($_GET['lang']) && !empty($_GET['lang'])
		? strtoupper($_GET['lang'])
		: '';
}