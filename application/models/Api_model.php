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
        return $this->db->insert($data);

    }
}

?>