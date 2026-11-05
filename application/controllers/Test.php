<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends BD_Controller {
    function __construct()
    {
        parent::__construct();
        $this->auth();
    }
	
	public function sample_post_data_post(){
		$data = $this->post('data');

        $this->response([
            'status' => TRUE,
            'message' => 'Your POST data',
            'data' => $data
        ], REST_Controller::HTTP_OK);
	}

    public function sample_get_data_get()
    {
        $data = $this->get('data');

		
		$this->response([
			'status' => TRUE,
			'message' => 'Your GET data',
			'data' => $data
		], REST_Controller::HTTP_OK);
    }
}
