<?php
/**
 * Created by PhpStorm.
 * User: yash
 * Date: 2/15/16
 * Time: 7:15 PM
 */
class Home extends CI_Controller{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
    }
    function index()
    {

        $this->load->view("Main_page");

    }
    function map(){
        $this->load->view("map");
    }
    function get($tag,$startDate,$endDate){
//        $results = $this->user_model->get_data($tag,$startDate,$endDate);
        $tag = "nike";
        $checkTag = $this->user_model->checkTag($tag);

        if(!$checkTag){
            $response = file_get_contents("https://api.instagram.com/v1/tags/$tag/media/recent?access_token=44475601.1677ed0.f1f91cc38e1d41feb05d46a6fb7997a3");
            $response = json_decode($response);
            $img_data = $response->data;
            if(sizeof($img_data)>0) {
                if(property_exists($response->pagination,'next_max_tag_id')){
                    $nextMaxTagId = $response->pagination->next_max_tag_id;
                }
                else{
                    $nextMaxTagId = 'N/A';
                }
                $this->user_model->insertTag($tag,$nextMaxTagId);
                $this->get_contents($img_data,$tag);
                $this->get($tag,$startDate,$endDate);

            }
            else{
                echo "Tag doesnt Exist";
                exit;
            }
        }
        else{

        }



    }
    function post(){
        $tag = 'chodubhagatmadarchodbhenchod';
        $tag = 'nike';
        $response = file_get_contents("https://api.instagram.com/v1/tags/$tag/media/recent?access_token=44475601.1677ed0.f1f91cc38e1d41feb05d46a6fb7997a3");
        $response = json_decode($response);
//        echo "<pre>";
//        print_r($response<!--);
           //echo "</pre>";
        $responseData = $response->data;
        echo "<pre>";
        print_r($responseData);
        echo(property_exists($responseData[0]->caption,'text'));
        echo "</pre>";
        exit;
        $data['nextMaxTagId'] = $response->pagination->next_max_tag_id;
        $this->user_model->updateQuery($tag,$data['nextMaxTagId']);
        echo "<pre>";
        print_r($data);
        echo "</pre>";

    }
    function test($a,$b){
//        $str = "#ncsk#nike#nikefy abcd #nike is awesome #nikefy is awesome";
//        $regex = "/#nike[#\s]/";
//        preg_match_all($regex,$str, $matches);
//        echo "<pre>";
//        print_r($matches);
//        echo "</pre>";

       if(strcmp('video','video')){
        echo "yes";
       }
    }
    function get_contents($img_data,$tag){
        for($i = 0 ; $i<sizeof($img_data); $i++){
            $thisImg = $img_data[$i];
            $data['type'] = $thisImg->type;
            $data['timestamp'] = $thisImg->created_time;
            $data['insta_link'] = $thisImg->link;
            if(strcmp($data['type'],'video')==0){
                $videoLinks = $thisImg->videos;
                $data['std_res'] = $videoLinks->standard_resolution->url;
                $data['low_res'] = $videoLinks->low_resolution->url;
                $data['thumb'] = "N/A";
            }
            else{
                $imgLinks = $thisImg->images;
                $data['std_res'] = $imgLinks->standard_resolution->url;
                $data['low_res'] = $imgLinks->low_resolution->url;
                $data['thumb'] =  $imgLinks->thumbnail->url;
            }
            $data['user_name'] = $thisImg->user->username;

            if(strcmp(gettype($thisImg->caption),'object')==0){

                $caption_text = $thisImg->caption->text;
                $regex = "/#".$tag."/";
                preg_match_all($regex,$caption_text, $matches);
                if(sizeof($matches[0]) > 0){
                    $data['timestamp'] = $thisImg->caption->created_time;
                }
            }
            elseif($thisImg->comments->count > 0){
                $comments=$thisImg->comments->data;
                for($j = 0; $j<sizeof($comments) ; ++$j){
                    $thisComment = $comments[$j];
                    if(property_exists($thisComment,'text')){
                        $comment_text = $thisComment->text;
                        $regex = "/#".$tag."/";
                        preg_match_all($regex,$comment_text, $matches);
                        if(sizeof($matches[0]) > 0 && (strcmp($thisComment->from->username,$data['user_name'])==0)){
                            $data['timestamp'] = $thisComment->created_time;
                        }
                    }
                }

            }
            else{
                $data['timestamp'] = $thisImg->created_time;
            }
            $this->user_model->insertResults($data,$tag);
        }
    }



}
?>