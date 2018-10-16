<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
description : 비동기 처리 로직들 insert , update , delete, select
참고 사이트 : http://www.ciboard.co.kr/user_guide/kr/
*/

class Service_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
    }

    public function selectServiceRegister($seq){
        $this->db->select("*");
        $this->db->from("service_register a");
        $this->db->join("members b","a.sr_mb_seq = b.mb_seq","left");
        $this->db->join("end_users c","sr_eu_seq=c.eu_seq","left");
        $this->db->join("company_type d","sr_ct_seq = d.ct_seq","left");
        $this->db->join("product_category e","sr_pc_seq = e.pc_seq","left");
        $this->db->join("product_items f","sr_pi_seq = f.pi_seq","left");
        $this->db->join("product g","sr_pr_seq = g.pr_seq","left");
        $this->db->join("product_div h","sr_pd_seq = h.pd_seq","left");
        $this->db->join("product_sub_div i","sr_ps_seq = i.ps_seq","left");
        $this->db->join("clients j","sr_c_seq = j.c_seq","left");

        $this->db->where("sr_seq",$seq);

        $query = $this->db->get();

        return $query->row_array();
    }

    public function selectServiceRegisterPrice($seq){
        $this->db->select("*");
        $this->db->from("service_register_price a");
        $this->db->join("product_sub_div b","sp_ps_seq = ps_seq","left");
        $this->db->where("sp_sr_seq",$seq);

        $query = $this->db->get();

        return $query->row_array();

    }

    public function selectServiceRegisterOption($seq){
        $this->db->select("*");
        $this->db->from("service_register_addoption a");
        $this->db->join("product b","sa_pr_seq = b.pr_seq","left");
        $this->db->join("product_item_sub c","sa_pis_seq = c.pis_seq","left");
        $this->db->join("clients d","sa_c_seq = c_seq","left");
        $this->db->join("service_register_addoption_price e","a.sa_seq = sap_sa_seq","left");

        $this->db->where("sa_sr_seq",$seq);

        $query = $this->db->get();
        // echo $this->db->last_query();

        return $query->result_array();
    }

    public function selectService($sv_seq){
        $this->db->select("*",true);
        $this->db->from("service a");
        $this->db->join("service_price ap","a.sv_seq=ap.svp_sv_seq","left" );
        $this->db->join("members b","a.sv_mb_seq = b.mb_seq","left");
        $this->db->join("end_users c","a.sv_eu_seq = c.eu_seq","left");
        $this->db->join("company_type cc","a.sv_ct_seq = cc.ct_seq","left");
        $this->db->join("product d","a.sv_pr_seq = d.pr_seq","left");
        $this->db->join("product_category e","a.sv_pc_seq = e.pc_seq","left");
        $this->db->join("product_items ei","a.sv_pi_seq = ei.pi_seq","left");
        $this->db->join("product_div pd","a.sv_pd_seq = pd.pd_seq","left");
        $this->db->join("product_sub_div f","a.sv_ps_seq = f.ps_seq","left");
        $this->db->join("clients cl","a.sv_c_seq = cl.c_seq","left");

        $this->db->where("sv_seq",$sv_seq);

        $query = $this->db->get();
        // echo $this->db->last_query();

        return $query->row_array();
    }

    public function selectPaymentLast($sv_seq){
        $this->db->select("*, (select count(*) from payment where pm_sv_seq = '".$sv_seq."' and pm_status = 0 and date_format(NOW(),'%Y-%m-%d') >= pm_end_date) as leftCount",true);
        $this->db->from("payment");
        $this->db->where("pm_sv_seq" , $sv_seq);
        // if($sva_seq != ""){
        //     $this->db->where("pm_sva_seq" , $sva_seq);
        // }else{
        $this->db->where("(pm_sva_seq is null or pm_sva_seq = 0 )");
        // }
        $this->db->order_by("pm_seq desc");
        $this->db->limit(1);
        $query = $this->db->get();

        return $query->row_array();
    }

    public function serviceFileAllFetch($sv_seq){
        $this->db->select("*");
        $this->db->from("service_files");
        $this->db->where("sf_sv_seq",$sv_seq);

        $query = $this->db->get();

        return $query->result_array();
    }

    public function fetchServiceCode($sv_code){
        $this->db->select("*");
        $this->db->from("service a");
        $this->db->join("service_price ap","a.sv_seq=ap.svp_sv_seq","left" );
        $this->db->join("service_addoption ad","ap.svp_sva_seq = ad.sva_seq","left");
        $this->db->join("members b","a.sv_mb_seq = b.mb_seq","left");
        $this->db->join("end_users c","a.sv_eu_seq = c.eu_seq","left");
        $this->db->join("company_type cc","a.sv_ct_seq = cc.ct_seq","left");
        $this->db->join("product d","a.sv_pr_seq = d.pr_seq","left");
        $this->db->join("product_category e","a.sv_pc_seq = e.pc_seq","left");
        $this->db->join("product_items ei","a.sv_pi_seq = ei.pi_seq","left");
        $this->db->join("product_div pd","a.sv_pd_seq = pd.pd_seq","left");
        $this->db->join("product_sub_div f","a.sv_ps_seq = f.ps_seq","left");
        $this->db->join("clients cl","a.sv_c_seq = cl.c_seq","left");

        $this->db->where("sv_code like '".$sv_code."-%' ");

        $query = $this->db->get();

        return $query->result_array();
    }

    public function fetchServiceHistory($sv_code){
        $this->db->select("*");
        $this->db->from("service_history");
        $this->db->where("sh_sv_code LIKE '".$sv_code."-01' ");
        $this->db->order_by("sh_seq");
        $query = $this->db->get();

        return $query->result_array();
    }
}