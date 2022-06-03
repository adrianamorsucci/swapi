<?php

namespace apirest\components;

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;

/**
 * Curl Client Component
 *
 */
class CurlClient extends Component
{
	public function init()
	{
		parent::init();
	}

	/** 
	 * GET
	 */
	public function get($url, $params=[], $token=null, $x_auth=false, $bearer=true)
	{
		# Params
		$queryString = http_build_query($params, '', '&');
		if (strlen($queryString>0)) $url .= $queryString;

		# Connection
		$ch = curl_init($url);

		# Options
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		# Authorization
		if ($token!==null) 
		{
			$headers[] = $bearer ? ($x_auth ? sprintf('x-authorization: Bearer %s', $token) : sprintf('Authorization: Bearer %s', $token)) : sprintf('access-token: %s', $token);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		}

		# Response
		$response = curl_exec($ch);

		curl_close($ch);

		return $response;
	}
        
	/** 
	 * HEAD
	 */
	public function head($url, $params=[], $token=null)
	{
		# Params
		$queryString = http_build_query($params, '', '&');
		if (strlen($queryString>0)) $url .= $queryString;

		# Connection
		$ch = curl_init($url);

		# Options
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		// This changes the request method to HEAD
		curl_setopt($ch, CURLOPT_NOBODY, true);

		# Authorization
		if ($token!==null) 
		{
			$headers[] = sprintf('Authorization: Bearer %s', $token);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		}

		# Response
		$response = curl_exec($ch);
		curl_close($ch);

		return $response;
	}

	/** 
	 * POST
	 */
	public function post($url, $data=[], $token=null, $x_auth=false, $bearer=true)
	{
		# Post Data
		$postString = http_build_query($data, '', '&');

		# Connection
		$ch = curl_init($url);

		# Options
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		# Authorization
		if ($token!==null) 
		{
			$headers[] = $bearer ? ($x_auth ? sprintf('x-authorization: Bearer %s', $token) : sprintf('Authorization: Bearer %s', $token)) : sprintf('access-token: %s', $token);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		}

		# Response
		$response = curl_exec($ch);


		curl_close($ch);

		return $response;
	}
        
    /** 
	 * POST
	 */
	public function postJson($url, $data=[], $headers = [], $token=null, $x_auth=false, $bearer=true)
	{
		# Post Data
        //$postString = http_build_query($data, '', '&');
        $postString = json_encode($data);
		
		# Connection
		$ch = curl_init($url);

		# Options
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		# Authorization
		if ($token!==null) 
		{
			$headers[] = $bearer ? ($x_auth ? sprintf('x-authorization: Bearer %s', $token) : sprintf('Authorization: Bearer %s', $token)) : sprintf('access-token: %s', $token);
			
		}
                
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		# Response
		$response = curl_exec($ch);

		curl_close($ch);

		return $response;
	}

	/** 
	 * PUT
	 */
	public function put($url, $data=[], $headers=[], $token=null, $x_auth=false, $bearer=true)
	{
		# Post Data
		//$postString = http_build_query($data, '', '&');
        $postString = json_encode($data);

		# Connection
		$ch = curl_init($url);

		# Authorization
		if ($token!==null) 
		{
			$headers[] = $bearer ? ($x_auth ? sprintf('x-authorization: Bearer %s', $token) : sprintf('Authorization: Bearer %s', $token)) : sprintf('access-token: %s', $token);
			//curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		}
		$headers[] = 'Content-Length: ' . strlen($postString);

		# Options
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
		

		# Response
		$response = curl_exec($ch);

		curl_close($ch);

		return $response;
	}
        
        /** 
	 * PATCH
	 */
	public function patch($url, $data=[], $headers=[], $token=null)
	{
		# Post Data
		//$postString = http_build_query($data, '', '&');
        $postString = json_encode($data);

		# Connection
		$ch = curl_init($url);

		# Authorization
		if ($token!==null) 
		{
			$headers[] = sprintf('Authorization: Bearer %s', $token);
			//curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		}
		$headers[] = 'Content-Length: ' . strlen($postString);

		# Options
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
		

		# Response
		$response = curl_exec($ch);
		curl_close($ch);

		return $response;
	}
        
    /** 
	 * DELETE
	 */
	public function delete($url, $data=[], $headers=[], $token=null)
	{
		# Post Data
		//$postString = http_build_query($data, '', '&');
        $postString = json_encode($data);

		# Connection
		$ch = curl_init($url);

		# Authorization
		if ($token!==null) 
		{
			$headers[] = sprintf('Authorization: Bearer %s', $token);
			//curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		}
		$headers[] = 'Content-Length: ' . strlen($postString);

		# Options
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
		

		# Response
		$response = curl_exec($ch);
		curl_close($ch);

		return $response;
	}
}
