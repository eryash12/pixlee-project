<?php
/**
 * Created by PhpStorm.
 * User: yash
 * Date: 4/23/16
 * Time: 12:09 PM
 */
class service extends CI_Controller{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->helper('date');
    }
    function post($tag,$startDate,$endDate){
        //request recieved for data
//        $tag = "sometimesiamjusthappy";
////        $tag = "nike";
//        $startDate =1461222000;
//        $endDate =1461481200;
        //checking if tag exists in db
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
        if($getResultCount < 30){
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
        $results = $this->user_model->getResults($tag,$startDate,$endDate);
        echo json_encode($results);
    }
}
//pagination function
//function paginate($tag,$response,$endDate,$startDate,$origEndDate,$origStartDate){
//        $imgData = $response->data;
//        $lastIndex = sizeof($imgData);
//        $max = $imgData[0]->created_time;
//        $min = $imgData[$lastIndex-1]->created_time;
//        $abc = unix_to_human($endDate);
//        $def = unix_to_human($startDate);
//        $ghi = unix_to_human($max);
//        $xyz = unix_to_human($min);
//        echo "<br>";
//        echo "max = $max".PHP_EOL;
//        echo "<br>";
//        echo "min = $min".PHP_EOL;
//        echo "<br>";
//        echo "end = $endDate".PHP_EOL;
//        echo "<br>";
//        echo "start = $startDate".PHP_EOL;
//        echo "<br>";
//        if($endDate >= $max){
//          echo "endDate >= max";
//        }
//        else{
//            echo "endDate < max";
//        }
//        echo "<br>";
//        if($endDate >= $min){
//            echo "endDate >= min";
//        }
//        else{
//            echo "endDate < min";
//        }
//        echo "<br>";
//        if($startDate >= $max){
//            echo "startDate >= max";
//        }
//        else{
//            echo "startDate < max";
//        }
//        echo "<br>";
//        if($startDate >= $min){
//            echo "startDate >= min";
//        }
//        else{
//            echo "startDate < min";
//        }
//        echo "<br>";
//
//
//        $nextUrl = null;
//        if(property_exists($response->pagination,'next_url')){
//            $nextUrl = $response->pagination->next_url;
//        }
//
//
//        if($endDate<=$max && $startDate >= $min){
//            echo "case1";
//            //collect all data and store in db and echo it
//            $this->getContents($imgData,$tag,$origEndDate,$origStartDate);
//            if($nextUrl != null){
//                $nextResponse =  file_get_contents($nextUrl);
//                $nextResponse = json_decode($nextResponse);
//
//                $nextImgData = $nextResponse->data;
//                $nextMax = $nextImgData[0]->created_time;
//                $this->paginate($tag,$nextResponse,$endDate,$startDate,$origEndDate,$origStartDate);
//            }
//            else{
//                echo "End of results in case2";
//                return;
//            }
//
//
//        }
//        //case2 if $endDate<min
//        elseif($endDate<$min){
//            echo "case2";
//            //paginate to next batch
//            if($nextUrl != null){
//                $nextResponse =  file_get_contents($nextUrl);
//                $nextResponse = json_decode($nextResponse);
//                $this->paginate($tag,$nextResponse,$endDate,$startDate,$origEndDate,$origStartDate);
//            }
//            else{
//                echo "No results";
//                return;
//            }
//
//
//        }
//
//        //case3 if start <= max and if end <min
//        elseif(($endDate<=$max && $endDate >= $min)||($startDate<=$max && $startDate >= $min)||($endDate > $max && $startDate < $min)){
//            echo "case3";
//            //collect data from $startDate to $min
//            //recurse paginate from ($nextResponse,$nextmax as startDate,$endDate)
//            $this->getContents($imgData,$tag,$origEndDate,$origStartDate);
//            if($nextUrl != null){
//                $nextResponse =  file_get_contents($nextUrl);
//                $nextResponse = json_decode($nextResponse);
//
//                $nextImgData = $nextResponse->data;
//                $nextMax = $nextImgData[0]->created_time;
//                $this->paginate($tag,$nextResponse,$endDate,$startDate,$origEndDate,$origStartDate);
//            }
//            else{
//                echo "End of results in case2";
//                return;
//            }
//
//        }
//
//        //case4  if we go ahead that is $start > $max && $end>$max
//        elseif($endDate>$max && $startDate>$max){
//            echo "case4";
//            //stop recursing and return
//            echo "End of results";
//            return;
//        }
//        //case4 when there is no data in the current pagination i.e $start < $min and $end<$min
//
//        //case5 when enddate > max
//
////        elseif($endDate > $max && $startDate > $min){
////            echo "case5";
////            $this->getContents($imgData,$tag,$origEndDate,$origStartDate);
////            return;
////        }
//
//    }
?>
<!--elseif($endDate<=$max && $startDate < $min){-->
<!--echo "case2";-->
<!--//collect data from $startDate to $min-->
<!--//recurse paginate from ($nextResponse,$nextmax as startDate,$endDate)-->
<!--$this->getContents($imgData,$tag,$origEndDate,$origStartDate);-->
<!--if($nextUrl != null){-->
<!--$nextResponse =  file_get_contents($nextUrl);-->
<!--$nextResponse = json_decode($nextResponse);-->
<!---->
<!--$nextImgData = $nextResponse->data;-->
<!--$nextMax = $nextImgData[0]->created_time;-->
<!--$this->paginate($tag,$nextResponse,$endDate,$startDate,$origEndDate,$origStartDate);-->
<!--}-->
<!--else{-->
<!--echo "End of results in case2";-->
<!--return;-->
<!--}-->
<!---->
<!--}-->

