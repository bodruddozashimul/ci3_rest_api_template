<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

use \Firebase\JWT\JWT;

class Userlib{
	protected $CI;
    public function __construct() {
		$this->CI = &get_instance();
    }

    function get_user_data(){
        $headers = $this->CI->input->get_request_header('Authorization');
        $kunci = $this->CI->config->item('thekey'); //secret key for encode and decode
        $token= "token";
        if (!empty($headers)) {
            if (preg_match('/Bearer\s(\S+)/', $headers , $matches)) {
                $token = $matches[1];
            }
        }
        try {
            $decoded = JWT::decode($token, $kunci, array('HS256'));
            return $decoded;
        }
        catch (Exception $e){
            $invalid = ['status' => false, 'message' => $e->getMessage(), 'data'=>array()];
            $this->CI->response($invalid, 401);//401
        }
        return 0;
    }
}
?>