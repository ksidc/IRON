<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
description : 비동기 처리 로직들 insert , update , delete, select
참고 사이트 : http://www.ciboard.co.kr/user_guide/kr/
*/

class Api_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
    }

    // 회원 아이디 중복체크
    public function memberIdCheck(){
        $this->db->select("*");
        $this->db->where("mb_id" , $this->input->get("mb_id"));
        $this->db->from("members");

        $query = $this->db->get();
        // 회원아이디가 중복일경우 true
        if($query->num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }

    // 회원 사업자 or 생년월일 중복체크
    public function memberNumberCheck(){
        $this->db->select("*");
        $this->db->where("mb_number" , $this->input->get("mb_number"));
        $this->db->from("members");

        $query = $this->db->get();
        // 회원 사업자 or 생년월일이 중복일경우 true
        if($query->num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }

    // 회원 insert
    public function memberAdd(){
        // data array
        $data = array(
            "mb_id" => $this->input->post("mb_id"),
            "mb_type" => $this->input->post("mb_type"),
            "mb_name" => $this->input->post("mb_name"),
            "mb_number" => $this->input->post("mb_number"),
            "mb_ceo" => $this->input->post("mb_ceo"),
            "mb_zipcode" => $this->input->post("mb_zipcode"),
            "mb_address" => $this->input->post("mb_address"),
            "mb_detail_address" => $this->input->post("mb_detail_address"),
            "mb_tel" => $this->input->post("mb_tel"),
            "mb_phone" => $this->input->post("mb_phone"),
            "mb_email" => $this->input->post("mb_email"),
            "mb_fax" => $this->input->post("mb_fax"),
            "mb_business_conditions" => $this->input->post("mb_business_conditions"),
            "mb_business_type" => $this->input->post("mb_business_type"),
            "mb_contract_name" => $this->input->post("mb_contract_name"),
            "mb_contract_email" => $this->input->post("mb_contract_email"),
            "mb_contract_tel" => $this->input->post("mb_contract_tel"),
            "mb_contract_phone" => $this->input->post("mb_contract_phone"),
            "mb_payment_name" => $this->input->post("mb_payment_name"),
            "mb_payment_email" => $this->input->post("mb_payment_email"),
            "mb_payment_tel" => $this->input->post("mb_payment_tel"),
            "mb_payment_phone" => $this->input->post("mb_payment_phone"),
            "mb_bank" => $this->input->post("mb_bank"),
            "mb_bank_name" => $this->input->post("mb_bank_name"),
            "mb_bank_name_relationship" => $this->input->post("mb_bank_name_relationship"),
            "mb_bank_number" => $this->input->post("mb_bank_number"),
            "mb_bank_input_number" => $this->input->post("mb_bank_input_number"),
            "mb_payment_type" => $this->input->post("mb_payment_type"),
            "mb_auto_payment" => $this->input->post("mb_auto_payment"),
            "mb_payment_publish" => $this->input->post("mb_payment_publish"),
            "mb_payment_publish_type" => $this->input->post("mb_payment_publish_type"),
            "mb_payment_day" => $this->input->post("mb_payment_day")
        );

        // ci 이용 디비 인서트
        return $this->db->insert("members",$data);

    }

    // 회원 list count
    public function countMember(){
        $this->db->select("count(*) as total");
        $this->db->from("members");

        if($this->input->get("searchYn") == "Y"){
            $this->db->where("1=1");
        }

        if($this->input->get("startDate") != "" && $this->input->get("endDate") != ""){
            $this->db->where("date_format(mb_regdate,'%Y-%m-%d') >= '".$this->input->get("startDate")."' and date_format(mb_regdate,'%Y-%m-%d') <= '".$this->input->get("endDate")."' ");
        }

        if($this->input->get("searchWord") != ""){
            $this->db->like($this->input->get("searchType"),$this->input->get("searchWord"),'both');
        }

        $query = $this->db->get();

        $row = $query->row_array();

        return $row["total"];
    }

    // 회원 list select
    public function fetchMember($start,$limit){
        $start = ($start - 1)*10;
        $this->db->select("*");
        $this->db->from("members");

        if($this->input->get("searchYn") == "Y"){
            $this->db->where("1=1");
        }

        if($this->input->get("startDate") != "" && $this->input->get("endDate") != ""){
            $this->db->where("date_format(mb_regdate,'%Y-%m-%d') >= '".$this->input->get("startDate")."' and date_format(mb_regdate,'%Y-%m-%d') <= '".$this->input->get("endDate")."' ");
        }

        if($this->input->get("searchWord") != ""){
            $this->db->like($this->input->get("searchType"),$this->input->get("searchWord"),'both');
        }

        $this->db->limit($limit,$start);

        $query = $this->db->get();

        return $query->result_array();
    }

    // 회원 row
    public function selectMember($mb_seq){
        $this->db->select("*");
        $this->db->from("members");
        $this->db->where("mb_seq",$mb_seq);
        $query = $this->db->get();

        return $query->row_array();
    }

    // 회원 업데이트
    public function memberUpdate($mb_seq){
        // data array
        $data = array(
            // "mb_id" => $this->input->post("mb_id"),
            "mb_type" => $this->input->post("mb_type"),
            "mb_name" => $this->input->post("mb_name"),
            "mb_number" => $this->input->post("mb_number"),
            "mb_ceo" => $this->input->post("mb_ceo"),
            "mb_zipcode" => $this->input->post("mb_zipcode"),
            "mb_address" => $this->input->post("mb_address"),
            "mb_detail_address" => $this->input->post("mb_detail_address"),
            "mb_tel" => $this->input->post("mb_tel"),
            "mb_phone" => $this->input->post("mb_phone"),
            "mb_email" => $this->input->post("mb_email"),
            "mb_fax" => $this->input->post("mb_fax"),
            "mb_business_conditions" => $this->input->post("mb_business_conditions"),
            "mb_business_type" => $this->input->post("mb_business_type"),
            "mb_contract_name" => $this->input->post("mb_contract_name"),
            "mb_contract_email" => $this->input->post("mb_contract_email"),
            "mb_contract_tel" => $this->input->post("mb_contract_tel"),
            "mb_contract_phone" => $this->input->post("mb_contract_phone"),
            "mb_payment_name" => $this->input->post("mb_payment_name"),
            "mb_payment_email" => $this->input->post("mb_payment_email"),
            "mb_payment_tel" => $this->input->post("mb_payment_tel"),
            "mb_payment_phone" => $this->input->post("mb_payment_phone"),
            "mb_bank" => $this->input->post("mb_bank"),
            "mb_bank_name" => $this->input->post("mb_bank_name"),
            "mb_bank_name_relationship" => $this->input->post("mb_bank_name_relationship"),
            "mb_bank_number" => $this->input->post("mb_bank_number"),
            "mb_bank_input_number" => $this->input->post("mb_bank_input_number"),
            "mb_payment_type" => $this->input->post("mb_payment_type"),
            "mb_auto_payment" => $this->input->post("mb_auto_payment"),
            "mb_payment_publish" => $this->input->post("mb_payment_publish"),
            "mb_payment_publish_type" => $this->input->post("mb_payment_publish_type"),
            "mb_payment_day" => $this->input->post("mb_payment_day")
        );
        $this->db->where("mb_seq",$mb_seq);
        // ci 이용 디비 인서트
        return $this->db->update("members",$data);
    }

    // 회원 삭제
    public function memberDelete($mb_seq){

        $this->db->where_in("mb_seq",$mb_seq);

        return $this->db->delete("members");
        // echo $this->db->last_query();
    }

    public function memberExport(){
        $this->db->select("*");
        $this->db->from("members");
        $this->db->where_in("mb_seq",$this->input->post("mb_seq"));

        $query = $this->db->get();

        return $query->result_array();
    }
}

?>