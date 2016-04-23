<?php

class User_model extends CI_Model
{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();

    }
//    function write_data($topic ,$msg){
////        $data['firstname'] = json_encode($a);
//        $data['topic'] = $topic;
//        $data['value'] = $msg;
//        $this->load->helper('date');
//        $unix =  now('PST');
//        $data['timestamp'] = $unix;
//        $this->db->insert("sensors_data", $data);
//    }
    function get_data($tag,$startDate,$endDate){
//        $query = 'select * from search_queries,search_results
//                  '
    }
    function store_data(){

    }
    function checkTag($tag){
        $query = "select * from search_queries where tag = '$tag'";
        $results = $this->db->query($query);
        if($results->num_rows() > 0) {
            return true;
        }
        else {
            return false;
        }
    }
    function insertTag($tag,$nextMaxTagId){
        $this->db->query("insert into search_queries (tag,next_max_tag_id) values ('$tag','$nextMaxTagId')");
    }
    function insertResults($data,$tag){
        $this->db->query("insert into search_results (search_tag,img_url_std,time_posted,instagram_link,content_type,img_url_low,img_url_thumb,user_name) values ('$tag','{$data['std_res']}','{$data['timestamp']}','{$data['insta_link']}','{$data['type']}','{$data['low_res']}','{$data['thumb']}','{$data['user_name']}')");
    }
}