<?php

class User_model extends CI_Model
{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();

    }
    function write_data($topic ,$msg){
//        $data['firstname'] = json_encode($a);
        $data['topic'] = $topic;
        $data['value'] = $msg;
        $this->load->helper('date');
        $unix =  now('PST');
        $data['timestamp'] = $unix;
        $this->db->insert("sensors_data", $data);
    }
}