<?php

/**
 * Class RESTful
 */
class RESTful
{
	/**
	 *    Error code for non-recognized number
	 */
	const NUMBER_NOT_RECOGNIZED = 1000;

	/**
	 *    Error code for missing parameter
	 */
	const MISSING_PARAM = 1100;

	/**
	 *    Error code for non-recognized parameter
	 */
	const PARAM_NOT_RECOGNIZED = 1200;

	/**
	 *    Error code for internal error
	 */
	const ERROR_IN_SERVICE = 1300;

	/**
	 * Response non-recognized number error
	 *
	 * @param string $msg
	 *
	 * @return array
	 */
	public function responseNumberNotRecognized($msg = 'Number is not recognized')
	{
		return $this->response(RESTful::NUMBER_NOT_RECOGNIZED, $msg);
	}

	/**
	 * Response missing parameter error
	 *
	 * @param string $msg
	 *
	 * @return array
	 */
	public function responseMissingParam($msg = 'Required parameters are missing')
	{
		return $this->response(RESTful::MISSING_PARAM, $msg);
	}

	/**
	 * Response non-recognized parameter error
	 *
	 * @param string $msg
	 *
	 * @return array
	 */
	public function responseParamNotRecognized($msg = 'Parameter not recognized')
	{
		return $this->response(RESTful::PARAM_NOT_RECOGNIZED, $msg);
	}

	/**
	 * Response internal error
	 *
	 * @param string $msg
	 *
	 * @return array
	 */
	public function responseErrorInService($msg = 'Error in service')
	{
		return $this->response(RESTful::ERROR_IN_SERVICE, $msg);
	}

	/**
	 * Response message for above errors
	 *
	 * @param $code
	 * @param $msg
	 *
	 * @return array
	 */
	private function response($code, $msg)
	{
		return [
			'error' => [
				'code' => $code,
				'msg'  => $msg,
			],
		];
	}
}