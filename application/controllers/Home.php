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
        $tag = "sometimesiamjusthappy";
        $startDate =1460876400;
        $endDate =1460876400;
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
                $this->getContents($img_data,$tag);
                $this->get($tag,$startDate,$endDate);

            }
            else{
                echo "Tag doesnt Exist";
                exit;
            }
        }
        else{
            echo "reached to send data";
            $this->sendData($tag,$startDate,$endDate,0);

        }
    }
    function sendData($tag,$startDate,$endDate,$lastUrlId){
        $noOfResults = $this->user_model->getNumberOfResults($tag,$startDate,$endDate,$lastUrlId);
        echo $noOfResults;
        $startDate =1460876400;
        $endDate =1460876400;
        if($noOfResults > 0 && $noOfResults <9){
            $action = $this->paginate($tag);
            if(!$action){
                //no more results available
                $results = $this->user_model->getResults($tag,$startDate,$endDate,$lastUrlId);
                echo json_encode($results);
            }
            else {
                //again get results
                $this->sendData($tag, $startDate, $endDate,$lastUrlId);
            }
        }
        elseif($noOfResults == 0){

            //paginate to get more results
            $action = $this->paginate($tag);
            if(!$action){
                //no more results available
                echo "No more results";
            }
            else {
                //again get results
                $this->sendData($tag, $startDate, $endDate,$lastUrlId);
            }
        }
        else{
            $results = $this->user_model->getResults($tag,$startDate,$endDate,$lastUrlId);
            echo json_encode($results);
        }

    }
    function paginate($tag){
        echo "got till pagination";
        $nextId = $this->user_model->getNextUrlId($tag);
        if(strcmp($nextId,'N/A')==0){
            return false;
        }
        else {
            $response = file_get_contents("https://api.instagram.com/v1/tags/$tag/media/recent?access_token=44475601.1677ed0.f1f91cc38e1d41feb05d46a6fb7997a3&max_tag_id=$nextId");
            $response = json_decode($response);
            $img_data = $response->data;
            if (sizeof($img_data) > 0) {
                if (property_exists($response->pagination, 'next_max_tag_id')) {
                    $nextMaxTagId = $response->pagination->next_max_tag_id;
                } else {
                    $nextMaxTagId = 'N/A';
                }
                $this->user_model->updateTag($tag, $nextMaxTagId);
                echo "filling contents";
                $this->getContents($img_data, $tag);

            }
            return true;
        }
    }
    function post(){
        $tag = 'chodubhagatmadarchodbhenchod';
        $tag = 'love';
        $response = file_get_contents("https://api.instagram.com/v1/tags/love/media/recent?access_token=44475601.1677ed0.f1f91cc38e1d41feb05d46a6fb7997a3&count=50");
        $response = json_decode($response);
//        echo "<pre>";
//        print_r($response<!--);
           //echo "</pre>";
        $responseData = $response->data;
        echo "<pre>";
        print_r($response);
//        echo(property_exists($responseData[0]->caption,'text'));
        echo "</pre>";
        exit;
        $data['nextMaxTagId'] = $response->pagination->next_max_tag_id;
        $this->user_model->updateQuery($tag,$data['nextMaxTagId']);
        echo "<pre>";
        print_r($data);
        echo "</pre>";

    }

    function test(){
        $nextUrl = "https://api.instagram.com/v1/tags/nike/media/recent?access_token=44475601.1677ed0.f1f91cc38e1d41feb05d46a6fb7997a3&count=50";
        while($nextUrl != null){
            $response = file_get_contents("https://api.instagram.com/v1/tags/nike/media/recent?access_token=44475601.1677ed0.f1f91cc38e1d41feb05d46a6fb7997a3&count=50");
            $response = json_decode($response);
            echo "<pre>";
            print_r($response);
            echo "</pre>";
            if(property_exists($response->pagination,'next_url')){
                $nextUrl = $response->pagination->next_url;
            }
            else{
                $nextUrl = null;
            }
        }
    }
    function getContents($img_data,$tag){
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
        echo "contents filled";

    }
    function getResults(){
        $results = $this->user_model->getAllResults();
        echo json_encode($results);
    }



}
?>