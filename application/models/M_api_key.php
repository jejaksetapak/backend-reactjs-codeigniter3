<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_api_key extends CI_Model {
	public function __construct() {
		parent::__construct();
		date_default_timezone_set("Asia/Jakarta");
		$header 	= $this->input->request_headers();
		$dataRequest = json_decode(file_get_contents('php://input'), true);
		// $apiKey 	= "3314135853C22A453B29DD42736A91A7DE38D46C65A3AA065059A845E242EFCC";
		$apiKey 	= "123456";
		// $header['Apikey'] == $apiKey
		if(!isset($dataRequest)){
			$this->errorMessage("not parameter request");
		}
		// if(!isset($header['api-key'])){
		// 	$this->errorMessage("api key not found");
		// }
		// if($header['api-key'] !=$apiKey){
		// 	$this->errorMessage("ApiKey is Wrong");
		// }
		
    }
	private function sendOutput($response)
	{
		$this->output
			->set_status_header(200)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES))
			->_display();
		exit;
	}
	private function errorMessage($parameter = '')
	{
		$response = array(
			'errStatus' => 1,
			'errMessage' => $parameter,
			'data' => '',
			'systemTime' => date('Y-m-d H:i:s'),
			'elapseTime' => $this->benchmark->elapsed_time()
		);
		$this->sendOutput($response);
	}

}
