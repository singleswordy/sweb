<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 基础库 - HTTP
 */
class Http {
	/**
	 * 执行GET请求
	 *
	 * @param string $url 要请求的URL
	 * @param int $connect_timeout 连接超时
	 * @param int $read_timeout 读写超时
	 * @param array $extra_header 额外的HTTP头
	 * @return string 返回的数据/false 失败
	 */
	public function get($url,$connect_timeout = 10,$read_timeout = 30,$extra_header = array()) {
		//初始化
		$ch = curl_init();

		//分拆URL
		$url_component = parse_url($url);
		if(empty($url_component))
		{
			log_message('error','分析URL不成功:'.$url);
			return false;
		}

		//设置URL
		curl_setopt($ch, CURLOPT_URL, $url);

		//设置请求参数
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $connect_timeout);
		curl_setopt($ch, CURLOPT_TIMEOUT, $read_timeout);
		curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');
		curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
		if($url_component['scheme'] == 'https')
		{
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
		}

		//如果有额外的HTTP需要设置，则执行设置
		if(empty($extra_header) === false)
		{
			curl_setopt($ch, CURLOPT_HTTPHEADER, $extra_header);
		}

		//记录信息(request)
		log_message('debug','HTTP请求数据' . json_encode(array('url' => $url,'extra_header' => $extra_header)) );

		//执行请求并记录数据
		$result = curl_exec($ch);
		$curl_info = curl_getinfo($ch);

		//如果不成功则返回false
		if($result === false)
		{
			log_message('error','执行GET请求不成功:' . json_encode( $curl_info ));
			return false;
		}

		//关闭句柄
		curl_close($ch);

		//记录信息(response)
		log_message('debug','HTTP返回数据:' . $result );

		//返回结果
		return $result;
	}

	/**
	 * 执行POST请求
	 *
	 * @param string $url 目标URL
	 * @param array/string $post_data 要发送的数据
	 * @param int $connect_timeout 连接超时
	 * @param int $read_timeout 读写超时
	 * @param array $extra_header 额外的HTTP头
	 * @param string $content_type	请求header的contentType
	 * @return string 返回的数据/false 失败
	 */
	public function post($url,$post_data,$port = 80,$connect_timeout = 10,$read_timeout = 30,$extra_header = array(),$content_type = 'Content-Type: application/x-www-form-urlencoded'){
		//执行请求
		$ch = curl_init();

		//分拆URL
		$url_component = parse_url($url);
		if(empty($url_component))
		{
			log_message('error','分析URL不成功:'.$url);
			return false;
		}
		
		//设置URL,PORT
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_PORT, $port);

		// 设置参数
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		// curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_POSTREDIR, 3);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $connect_timeout);
		curl_setopt($ch, CURLOPT_TIMEOUT, $read_timeout);
		curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:',$content_type));
		curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');
		curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
		if($url_component['scheme'] == 'https')
		{
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
		}

		//如果有额外的HTTP需要设置，则执行设置
		if(empty($extra_header) === false)
		{
			curl_setopt($ch, CURLOPT_HTTPHEADER, $extra_header);
		}
        
		//记录信息(request)
		log_message('debug','HTTP请求数据' . json_encode(array('url' => $url,'post_data' => $post_data,'extra_header' => $extra_header)) );


		//执行请求并记录数据
		$result = curl_exec($ch);
		$curl_info = curl_getinfo($ch);

        //如果不成功则返回false
		if($result === false)
		{
			log_message('error','执行POST请求不成功:' . json_encode( $curl_info ));
			return false;
		}

		//记录信息(response)
		log_message('debug','HTTP返回数据:' . $result );

        //关闭句柄
		curl_close($ch);

        //返回结果
		return $result;
	}
	
}


//End of Script
