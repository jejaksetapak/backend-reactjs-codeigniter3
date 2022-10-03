<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
class User extends CI_Controller
{
	public function __construct() {
		parent::__construct();
		$this->load->model('M_api_key');
	}
	public function login(){
		$dataAPI = json_decode(file_get_contents('php://input'), true);
		$this->load->model('M_users', 'user');
		$jwt = new JWT();
		$JwtSecretKey="ayamgoren";
		$username =$dataAPI['email'];
		$password =$dataAPI['password'];
		$params =array(
			"email"=>$username,
			"password" =>$password
		);

		$data = $this->user->login($params);
		// die(print_r($data));
		if($data['type'] =='0'){
			$token =$jwt->encode($data['data'],$JwtSecretKey,'HS256');
			$response=array(
				"type"=>0,
				"msg" =>$data['msg'],
				"token"=>$token
			);
		}else{
			$response=array(
				"type"=>1,
				"msg" =>$data['msg'],
				"token"=>''
			);
		}
		echo json_encode($response);

	}
	public function register(){
		$dataAPI = json_decode(file_get_contents('php://input'), true);
		$this->load->model('M_users', 'user');
		$send=$this->user->register($dataAPI);
		echo json_encode($send);
	}
}
