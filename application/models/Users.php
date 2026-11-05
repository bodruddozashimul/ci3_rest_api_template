<?php if(!defined('BASEPATH')) exit('No direct script allowed');

class Users extends CI_Model{
    function api_login_check($username, $password){
        $this->db->select("id, username, password");
        $this->db->from("api_users");

        $this->db->where("username", $username);
        $this->db->where("password", $password);

        $res = $this->db->get();

        if($res->num_rows() > 0){
            return $res->row();
        }

        return array();
    }
}