<?php

defined('BASEPATH') OR exit('No direct script access allowed');
use \Firebase\JWT\JWT;

class Auth extends BD_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['users_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key
        $this->load->model('users');
    }

    

    public function login_post()
    {
        $u = $this->post('username'); //Username Posted
        $p = md5($this->post('password')); //Pasword Posted

        $kunci = $this->config->item('thekey');
        $invalidLogin = ['status' => 'Invalid Login']; //Respon if login invalid
        $val = $this->users->api_login_check($u, $p); //Model to get single data row from database base on username

//        pnd($val);

        if(empty($val)){
            $this->response($invalidLogin, REST_Controller::HTTP_NOT_FOUND);
        }

		$match = $val->password;   //Get password for user from database
        if($p == $match){  //Condition if password matched
        	$token['id'] = $val->id;  //From here
            $token['username'] = $u;
            $date = new DateTime();
            $token['iat'] = $date->getTimestamp();
            $token['exp'] = $exp = $date->getTimestamp() + $this->config->item('jwt_expire'); //To here is to generate token
            $output['token'] = JWT::encode($token,$kunci ); //This is the output token
            $output['request_time'] = date('Y-m-d H:i:s');
            $output['expire_date_time'] = date('Y-m-d H:i:s', $exp);
            $output['expire_date'] = date('Y-m-d', $exp);
            $output['expire_time'] = date('H:i:s', $exp);
            $output['expire_duration'] = $this->config->item('jwt_expire');;
            $this->set_response($output, REST_Controller::HTTP_OK); //This is the respon if success
        }
        else {
            $this->set_response($invalidLogin, REST_Controller::HTTP_NOT_FOUND); //This is the respon if failed
        }
    }

}
