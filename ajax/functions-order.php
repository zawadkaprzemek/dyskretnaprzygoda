<?php 

if(!function_exists('curlShot')){
	function curlShot($url, $user_agent, $referer, $ip, $init = true, $post = true, $params = array(), $array = array()){
		
		$headers = [
			'Referer: '.$referer, 
			'User-Agent: '.$user_agent,
			'X-Forwarded-For: '.$ip
		];
		
		$ch = curl_init();
		
		if($post){
			$postdata = buildPostQuery($array);
			//var_dump($postdata);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata); 
			curl_setopt($ch, CURLOPT_POST, 1);
		}
		
		curl_setopt ($ch, CURLOPT_URL, $url);
		curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt ($ch, CURLOPT_USERAGENT, $user_agent);
		curl_setopt ($ch, CURLOPT_TIMEOUT, 10);
		//curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		
		if(arrayKeysExists(array('PHPSESSID', 'SID'), $params)){
			$cookie = buildCookieQuery($params);
			curl_setopt ($ch, CURLOPT_COOKIE, $cookie);
		}
		
		curl_setopt ($ch, CURLOPT_REFERER, $referer); 
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		//curl_setopt($ch, CURLOPT_HEADER, 1);
		//curl_setopt($ch,  CURLOPT_RETURNTRANSFER, true); 
		$response = curl_exec ($ch);
		//$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		curl_close($ch);

		return $response;

	}
}


if(!function_exists('curlInit')){
	function curlInit($url, $user_agent, $referer, $ip){
		return curlShot($url, $user_agent, $referer, $ip, true);
	}
}


if(!function_exists('curlOrder')){
	function curlOrder($url, $user_agent, $referer, $ip, $params, $array){
		return curlShot($url, $user_agent, $referer, $ip, false, true, $params, $array);
	}
}


if(!function_exists('arrayKeysExists')){
	function arrayKeysExists($keys, $array){
		foreach($keys as $k){
			if(!array_key_exists($k, $array)){
				return false;
			}
		}
		return true;
	}
}


if(!function_exists('buildGetQuery')){
	function buildGetQuery($array, $init = true){
		if($init){
			$getdata = isset($array['aid']) && strlen($array['aid']>0) ? '?aid='.$array['aid'] : '?aid=768';
			if(isset($array['cid']) && strlen($array['cid']>0)){ 
				$getdata .= '&cid='.$array['cid']; 
			}
			if(isset($array['ac']) && strlen($array['ac']>0)){ 
				$getdata .= '&ac='.$array['ac']; 
			}
		}
		else {
			$getdata = isset($array['UID']) ? '?uid='.$array['UID'] : '';
		}
		return $getdata;
	}
}


if(!function_exists('buildPostQuery')){
	function buildPostQuery($array){
		return "note=".$array['note']."&name=".$array['name']."&surname=".$array['surname']."&email=".$array['email']."&phone=".$array['phone']."&address=".$array['address']."&pcode=".$array['pcode']."&city=".$array['city']."&country=".$array['country']."&api_key=".$array['api_key']."&aid=".$array['aid']."&cid=".$array['cid']."&ac=".$array['ac']."&base_url=".$array['base_url']."&price=".$array['price']."&referer=".$array['referer']."&ip=".$array['ip'];
	}
}


if(!function_exists('buildCookieQuery')){
	function buildCookieQuery($params){
		return "SID=".$params['SID']."; PHPSESSID=".$params['PHPSESSID'];
	}
}


if(!function_exists('makeOrder')){
	function makeOrder($array){
		
		/* init shot */
		
		$url 		= $array['order_url'];
		$ip 		= $array['ip'];
		$referer 	= $array['referer'];
		$user_agent = $array['user_agent'];
		
		$url .= buildGetQuery($array);
		
		$params = curlInit($url, $user_agent, $referer, $ip);
		
		/* order shot */
		
		$url = $array['order_url'].'order1.php';
		
		$url .= buildGetQuery($params, false);
		
		return curlOrder($url, $user_agent, $referer, $ip, $params, $array);
		
	}
}