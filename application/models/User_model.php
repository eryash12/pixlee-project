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
    function insertTag($tag){
        $this->db->query("insert into search_queries (tag) values ('$tag')");
    }
    function insertResults($data,$tag,$nextId){

        $dupCheck = $this->db->query("select * from search_results where instagram_link = '{$data['instagram_link']}'");
        if($dupCheck->num_rows() > 0){

            return;
        }
        else {

//            $this->db->query("insert into search_results (search_tag,img_url_std,time_posted,instagram_link,content_type,img_url_low,img_url_thumb,user_name,next_max_tag_id,likes,caption,location,user_dp) values ('$tag','{$data['std_res']}','{$data['timestamp']}','{$data['insta_link']}','{$data['type']}','{$data['low_res']}','{$data['thumb']}','{$data['user_name']}','$nextId','{$data['likes']}','{$data['caption_text']}','{$data['location']}','{$data['user_dp']}')");
//            return true;
            $this->db->insert('search_results',$data);
        }
    }
    function getNumberOfResults($tag,$startDate,$endDate){
        $results = $this->db->query("select count(*) as number FROM (select * from search_results where search_tag = '$tag' and time_posted < $endDate and time_posted > $startDate ORDER by img_id ) as sb ");
        $refResults = $results->result_array();
        $refResults = $refResults[0]['number'];
        return $refResults;

    }
    function getResults($tag,$startDate,$endDate){
        $results = $this->db->query("select * from search_results where search_tag = '$tag' and time_posted < $endDate and time_posted > $startDate ORDER by img_id ");
        return $results->result_array();
    }
    function getAllResults(){
        $results = $this->db->query("select * from search_results");
        return $results->result_array();
    }
//    function getNextUrlId($tag){
//        $results = $this->db->query("select next_max_tag_id as nextId from search_queries where tag = '$tag'");
//        $refResults = $results->result_array();
//        $refResults = $refResults[0]['nextId'];
//        return $refResults;
//    }
    function updateTag($tag,$nextMaxTagId){
        $this->db->query("UPDATE search_queries SET next_max_id = '$nextMaxTagId' where tag = '$tag'");
    }
    function updateTopTimestamp($tag,$timestamp){
        $results = $this->db->query("select top_timestamp as timestamp from search_queries where tag = '$tag'");
        $refResults = $results->result_array();
        $refResults = $refResults[0]['timestamp'];
        $this->db->query("UPDATE search_queries SET top_timestamp = $timestamp where tag = '$tag'");
    }
    function getTopTimestamp($tag){
        $results = $this->db->query("select top_timestamp as timestamp from search_queries where tag = '$tag'");
        $refResults = $results->result_array();
        $refResults = $refResults[0]['timestamp'];
        return $refResults;
    }
    function insertSearch($data){
        $this->db->select('next_max_tag_id');
        $results = $this->db->get_where('search_present',$data);
        if($results->num_rows()>0){
            $refResults = $results->result_array();
            $refResults = $refResults[0]['next_max_tag_id'];
            return $refResults;
        }
        else{
            $this->db->insert('search_present',$data);
            return false;
        }
    }
    function updateSearch($data){
        $this->db->query("UPDATE search_present SET next_max_tag_id = '{$data['next_max_tag_id']}' where tag = '{$data['tag']}' and start_date = '{$data['start_date']}' and end_date = '{$data['end_date']}'");
    }
}