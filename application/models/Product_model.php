<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
description :
참고 사이트 : http://www.ciboard.co.kr/user_guide/kr/
*/

class Product_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
    }

    public function fetchDiv($pc_seq){
        $this->db->select("*");
        $this->db->from("product_div");

        $this->db->where("pd_pc_seq", $pc_seq);

        $this->db->order_by("pd_sort asc");

        $query = $this->db->get();

        return $query->result_array();
    }

    public function fetchSubDiv($pd_seq,$pr_seq){
        $this->db->select("*");
        $this->db->from("product_sub_div a");
        $this->db->join("product_sub b","a.ps_seq = b.prs_ps_seq and prs_pr_seq = '".$pr_seq."' ","left");
        $this->db->where("ps_pd_seq",$pd_seq);

        // if($pr_seq != ""){
        //     $this->db->where("prs_pr_seq",$pr_seq);
        // }
        $this->db->order_by("ps_seq asc");
        $query = $this->db->get();

        return $query->result_array();
    }

    public function selectProduct($pr_seq){
        $this->db->select("a.*, b.pi_name, c.c_name");
        $this->db->from("product a");
        $this->db->join("product_items b","a.pr_pi_seq = b.pi_seq","left");
        $this->db->join("clients c", "a.pr_c_seq = c.c_seq","left");

        $this->db->where("pr_seq",$pr_seq);
        $query = $this->db->get();

        return $query->row_array();
    }

    public function selectCategory($pc_seq){
        $this->db->select("*");
        $this->db->from("product_category");
        $this->db->where("pc_seq",$pc_seq);

        $query = $this->db->get();

        return $query->row_array();
    }

    public function selectMaxProductCode($pc_seq){
        $this->db->select("pr_code");
        $this->db->from("product");

        $this->db->where("pr_pc_seq",$pc_seq);
        $this->db->limit(1);
        $this->db->order_by("pr_code desc");

        $query = $this->db->get();
        $result = $query->row_array();

        $pr_code = $result["pr_code"];
        $pr_num = substr($result["pr_code"],-4);

        return $pr_num+1;
    }
}

?>