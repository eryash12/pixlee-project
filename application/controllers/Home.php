<?php
/**
 * Created by PhpStorm.
 * User: yash
 * Date: 2/15/16
 * Time: 7:15 PM
 */
class Home extends CI_Controller{
    function index()
    {

        $this->load->view("Main_page");

    }
    function map(){
        $this->load->view("map");
    }


}
?>