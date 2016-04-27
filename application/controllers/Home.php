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
        $this->output->set_header('HTTP/1.0 200 OK');
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    }
    function index()
    {

        $this->load->view("Main_page");

    }
    function map(){
        $this->load->view("map");
    }

    function getAllResults(){
        $results = $this->user_model->getAllResults();
        echo json_encode($results);
    }
    function post($tag,$startDate,$endDate){
        //request recieved for data
        //checking if tag exists in db
        $this->output->set_header('HTTP/1.0 200 OK');
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $checkTag = $this->user_model->checkTag($tag);

        if(!$checkTag){
            //if tag doesnt exists
            $response = $this->getApiResponse($tag,null);
            $img_data = $response->data;
            //checking the tag for data
            if(sizeof($img_data)>0) {
                //if data exists store the tag in db and paginate to collect results
                $this->user_model->insertTag($tag);
                $this->post($tag,$startDate,$endDate);

            }
            else{
                //if no data present in first call tag doesnt exist
                echo "done";
                exit;
            }
        }
        else{
            //Tag is in the db
            //check if the search params already exist
            $data['tag'] = $tag;
            $data['start_date'] = $startDate;
            $data['end_date'] = $endDate;
            //this will return the nextmaxtagid if search present or will insert the search and return false
            $nextId = $this->user_model->insertSearch($data);
            if(!$nextId) {
                $this->pagination($tag, null, $endDate, $startDate);
            }
            else{
                $this->pagination($tag,$nextId, $endDate, $startDate);
            }
            echo "done";

        }
    }

    function pagination($tag,$nextId,$endDate,$startDate){
//        echo "</br> started pagination max id = $nextId";
        $response = $this->getApiResponse($tag,$nextId);
        $img_data = $response->data;
        if (property_exists($response->pagination, 'next_max_tag_id')) {
            $nextId = $response->pagination->next_max_tag_id;
        }
        else{
            $nextId =null;
        }
        $this->user_model->updateSearch(array('tag'=>$tag,'start_date'=>$startDate,'end_date'=>$endDate,'next_max_tag_id'=>$nextId));
        $this->getContents($img_data,$tag,$endDate,$startDate,$nextId);
        $getResultCount = $this->user_model->getNumberOfResults($tag,$startDate,$endDate);
        if($getResultCount < 90){
            if($nextId != null){

                $this->pagination($tag,$nextId,$endDate,$startDate);
            }
            else{
                return;
            }

        }
        else{
            return;
        }
    }
    function getApiResponse($tag,$nextId = null){
        if($nextId == null) {
            $response = file_get_contents("https://api.instagram.com/v1/tags/$tag/media/recent?access_token=44475601.1677ed0.f1f91cc38e1d41feb05d46a6fb7997a3&count=50");
            $response = json_decode($response);
        }
        else{
            $response = file_get_contents("https://api.instagram.com/v1/tags/$tag/media/recent?access_token=44475601.1677ed0.f1f91cc38e1d41feb05d46a6fb7997a3&count=50&max_tag_id=$nextId");
            $response = json_decode($response);
        }
        return $response;
    }
    function getContents($img_data,$tag,$endDate,$startDate,$nextId){


        for($i = 0 ; $i<sizeof($img_data); $i++){
            $data = [];
            $thisImg = $img_data[$i];
            $data['content_type'] = $thisImg->type;
            $data['time_posted'] = $thisImg->created_time;
            $data['instagram_link'] = $thisImg->link;
            if(strcmp($data['content_type'],'video')==0){
                $videoLinks = $thisImg->videos;
                $data['img_url_std'] = $videoLinks->standard_resolution->url;
                $data['img_url_low'] = $videoLinks->low_resolution->url;
                $data['img_url_thumb'] = "N/A";
            }
            else{
                $imgLinks = $thisImg->images;
                $data['img_url_std'] = $imgLinks->standard_resolution->url;
                $data['img_url_low'] = $imgLinks->low_resolution->url;
                $data['img_url_thumb'] =  $imgLinks->thumbnail->url;
            }
            $data['user_name'] = $thisImg->user->username;
            $data['user_dp'] = $thisImg->user->profile_picture;
            $data['likes'] = $thisImg->likes->count;
            $data['location'] = "";
            if(strcmp(gettype($thisImg->location),'object')==0) {
                if (property_exists($thisImg->location, "name")) {
                    $data['location'] = $thisImg->location->name;
                }
            }
            if(strcmp(gettype($thisImg->caption),'object')==0){

                $caption_text = $thisImg->caption->text;
                $data['caption'] = $caption_text;
                $regex = "/#".$tag."/";
                preg_match_all($regex,$caption_text, $matches);
                if(sizeof($matches[0]) > 0){
                    $data['time_posted'] = $thisImg->caption->created_time;
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
                            $data['time_posted'] = $thisComment->created_time;
                        }
                    }
                }

            }
            else{
                $data['time_posted'] = $thisImg->created_time;

            }
            $data['search_tag'] = $tag;
            $data['next_max_tag_id'] = $nextId;
            if($data['time_posted']<=$endDate && $data['time_posted']>=$startDate){
                $this->user_model->insertResults($data, $tag,$nextId);
            }

        }

//        echo "contents filled";
        return true;
    }
    function get($tag,$startDate,$endDate){
        $this->output->set_header('HTTP/1.0 200 OK');
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $results = $this->user_model->getResults($tag,$startDate,$endDate);
        echo json_encode($results);
    }


}
?>