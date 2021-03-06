<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Estimate extends CI_Controller {

    /**
     * 회원 컨트롤러
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model("api_model");
    }

    public function index()
    {
        $data["category"] = $this->api_model->productCategoryList();

        $layout["header"] = $this->load->view("layout/header", '',true);
        $layout["left"] = $this->load->view("layout/left", '',true);
        $layout["content"] = $this->load->view("estimate/list", $data,true);
        $layout["footer"] = $this->load->view("layout/footer", '',true);
        $this->load->view('layout/layout',$layout);
    }
}
