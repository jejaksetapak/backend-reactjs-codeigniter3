<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_users extends CI_Model
{
	public function login($data)
	{
		$sqlLog = $this->db->where('user_email', $data['email'])
			->where('user_status', '1')->get('user');
		if ($sqlLog->num_rows() > 0) {
			$rrLog = $sqlLog->row_array();
			if (password_verify($data['password'], $rrLog['user_password'])) {
				$newdata = array(
					'Iduser'           => $rrLog['user_id'],
					'name_users'         => $rrLog['user_name'],
					'email_users'         => $rrLog['user_email']

				);
				$itemArray['data'] = $newdata;
				$itemArray['status'] = 'true';
				$itemArray['type'] = 0;
				$itemArray['msg'] = 'Login Success';
			} else {
				$itemArray['data'] = array();
				$itemArray['status'] = 'false';
				$itemArray['type'] = 1;
				$itemArray['msg'] = 'Wrong Password';
			}
		} else {
			$itemArray['status'] = 'false';
			$itemArray['type'] = 1;
			$itemArray['msg'] = 'Wrong Email';
		}
		return $itemArray;
	}
	private function cekUser($email){
        $sql=$this->db->where('user_email',$email)
            ->where('user_status', '1')->get('user');
        return $sql;
    }
	public function register($data)
	{
		// die(print_r($data));
		$passUser = password_hash($data['password'], PASSWORD_DEFAULT);
		$dataIns = array(
			"user_name" => $data['name'],
			"user_email" => $data['email'],
			"user_status" => '1',

		);
		$cekUser = $this->cekUser($data['email']);
		if ($cekUser->num_rows() > 0) {
			if ($data['userId'] == '') {
				$type = '1';
				$msg = "Email user already exists";
			} else {
				$dataIns["users_update"] = date('Y-m-d H:i:s');
				if ($data['password'] == '') {
				} else {
					$dataIns["user_password"] = $passUser;
				}
				$this->db->where('user_id', $data['userId'])->update('user', $dataIns);
				$type = '0';
				$msg = "Update success";
			}
		} else {
			if ($data['userId'] == '') {
				$dataIns["user_create"] = date('Y-m-d H:i:s');
				$dataIns["user_password"] = $passUser;
				$this->db->insert('user', $dataIns);
				$type = '0';
				$msg = "Input success";
			} else {
				$dataIns["user_update"] = date('Y-m-d H:i:s');
				if ($data['password'] == '') {
				} else {
					$dataIns["user_password"] = $passUser;
				}
				$this->db->where('user_id', $data['userId'])->update('user', $dataIns);
				$type = '0';
				$msg = "Update success";
			}
		}
		return $res = array(
			"type" => $type,
			"msg" => $msg
		);
	}
}
