<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

    /**
     * Api 컨트롤러
     * 데이터 셀렉트, 인서트, 업데이트, 삭제 등 쿼리
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model("api_model");
        $this->load->library('PHPExcel');
    }

    // 회원 아이디 중복체크 - get
    public function memberIdCheck()
    {
        $result = $this->api_model->memberIdCheck();
        $arr = array('result'=>$result);
        echo json_encode($arr);
    }

    // 회원 사업자 or 생년월일 중복체크 - get
    public function memberNumberCheck()
    {
        $result = $this->api_model->memberNumberCheck();
        $arr = array('result'=>$result);
        echo json_encode($arr);
    }

    // 회원 입력 - post
    public function memberAdd()
    {
        $result = $this->api_model->memberAdd();
        $arr = array('result'=>$result);
        echo json_encode($arr);
    }

    // 회원 리스트 - get
    public function memberList($start,$end)
    {
        $total = $this->api_model->countMember();
        $list = $this->api_model->fetchMember($start,$end);
        $result = [
            "total" => $total,
            "list" => $list
        ];

        echo json_encode($result);
    }

    // 회원 상세 - get
    public function memberView($mb_seq)
    {
        $info = $this->api_model->selectMember($mb_seq);
        echo json_encode($info);
    }

    // 회원 수정 - post
    public function memberUpdate($mb_seq)
    {
        $result = $this->api_model->memberUpdate($mb_seq);
        $arr = array('result'=>$result);
        echo json_encode($arr);
    }

    // 회원 삭제 - get
    public function memberDelete()
    {
        $mb_seq = $this->input->get("mb_seq");
        $mb_seq_array = explode(",",$mb_seq);

        $result = $this->api_model->memberDelete($mb_seq_array);
        $arr = array('result'=>$result);
        echo json_encode($arr);
    }

    //회원 excel
    public function memberExport(){
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle('회원');
        $objPHPExcel->getActiveSheet()->setCellValue('A1', '아이디');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', '회원구분');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', '상호명');
        $objPHPExcel->getActiveSheet()->setCellValue('D1', '사업자등록번호/생년월일');
        $objPHPExcel->getActiveSheet()->setCellValue('E1', '대표자');
        $objPHPExcel->getActiveSheet()->setCellValue('F1', '우편번호');
        $objPHPExcel->getActiveSheet()->setCellValue('G1', '주소');
        $objPHPExcel->getActiveSheet()->setCellValue('H1', '상세주소');
        $objPHPExcel->getActiveSheet()->setCellValue('I1', '전화번호');
        $objPHPExcel->getActiveSheet()->setCellValue('J1', '휴대폰번호');
        $objPHPExcel->getActiveSheet()->setCellValue('K1', '이메일');
        $objPHPExcel->getActiveSheet()->setCellValue('L1', '팩스');
        $objPHPExcel->getActiveSheet()->setCellValue('M1', '업태');
        $objPHPExcel->getActiveSheet()->setCellValue('N1', '종목');
        $objPHPExcel->getActiveSheet()->setCellValue('O1', '계약 담당자명');
        $objPHPExcel->getActiveSheet()->setCellValue('P1', '계약 이메일');
        $objPHPExcel->getActiveSheet()->setCellValue('Q1', '계약 전화번호');
        $objPHPExcel->getActiveSheet()->setCellValue('R1', '계약 휴대폰번호');
        $objPHPExcel->getActiveSheet()->setCellValue('S1', '요금 담당자명');
        $objPHPExcel->getActiveSheet()->setCellValue('T1', '요금 이메일');
        $objPHPExcel->getActiveSheet()->setCellValue('U1', '요금 전화번호');
        $objPHPExcel->getActiveSheet()->setCellValue('V1', '요금 휴대폰번호');
        $objPHPExcel->getActiveSheet()->setCellValue('W1', '회원 계좌 은행명');
        $objPHPExcel->getActiveSheet()->setCellValue('X1', '회원 계좌 번호');
        $objPHPExcel->getActiveSheet()->setCellValue('Y1', '회원 계좌 예금주');
        $objPHPExcel->getActiveSheet()->setCellValue('Z1', '회원 계좌 관계');
        $objPHPExcel->getActiveSheet()->setCellValue('AA1', '회원 계좌 사업자번호/생년월일');
        $objPHPExcel->getActiveSheet()->setCellValue('AB1', '청구 기준');
        $objPHPExcel->getActiveSheet()->setCellValue('AC1', '자동 청구일');
        $objPHPExcel->getActiveSheet()->setCellValue('AD1', '계산서 발행');
        $objPHPExcel->getActiveSheet()->setCellValue('AE1', '결제일');


        $member_list = $this->api_model->memberExport();

        for($i = 0;$i<count($member_list);$i++){
            $objPHPExcel->getActiveSheet()->setCellValue('A'.($i+2), $member_list[$i]['mb_id']);

            if($member_list[$i]['mb_type'] == "0"){
                $objPHPExcel->getActiveSheet()->setCellValue('B'.($i+2), "사업자");
            }else{
                $objPHPExcel->getActiveSheet()->setCellValue('B'.($i+2), "개인");
            }
            $objPHPExcel->getActiveSheet()->setCellValue('C'.($i+2), $member_list[$i]['mb_name']);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.($i+2), $member_list[$i]['mb_number']);
            $objPHPExcel->getActiveSheet()->setCellValue('E'.($i+2), $member_list[$i]['mb_ceo']);
            $objPHPExcel->getActiveSheet()->setCellValue('F'.($i+2), $member_list[$i]['mb_zipcode']);
            $objPHPExcel->getActiveSheet()->setCellValue('G'.($i+2), $member_list[$i]['mb_address']);
            $objPHPExcel->getActiveSheet()->setCellValue('H'.($i+2), $member_list[$i]['mb_detail_address']);
            $objPHPExcel->getActiveSheet()->setCellValue('I'.($i+2), $member_list[$i]['mb_tel']);
            $objPHPExcel->getActiveSheet()->setCellValue('J'.($i+2), $member_list[$i]['mb_phone']);
            $objPHPExcel->getActiveSheet()->setCellValue('K'.($i+2), $member_list[$i]['mb_email']);
            $objPHPExcel->getActiveSheet()->setCellValue('L'.($i+2), $member_list[$i]['mb_fax']);
            $objPHPExcel->getActiveSheet()->setCellValue('M'.($i+2), $member_list[$i]['mb_business_conditions']);
            $objPHPExcel->getActiveSheet()->setCellValue('N'.($i+2), $member_list[$i]['mb_business_type']);
            $objPHPExcel->getActiveSheet()->setCellValue('O'.($i+2), $member_list[$i]['mb_contract_name']);
            $objPHPExcel->getActiveSheet()->setCellValue('P'.($i+2), $member_list[$i]['mb_contract_email']);
            $objPHPExcel->getActiveSheet()->setCellValue('Q'.($i+2), $member_list[$i]['mb_contract_tel']);
            $objPHPExcel->getActiveSheet()->setCellValue('R'.($i+2), $member_list[$i]['mb_contract_phone']);
            $objPHPExcel->getActiveSheet()->setCellValue('S'.($i+2), $member_list[$i]['mb_payment_name']);
            $objPHPExcel->getActiveSheet()->setCellValue('T'.($i+2), $member_list[$i]['mb_payment_email']);
            $objPHPExcel->getActiveSheet()->setCellValue('U'.($i+2), $member_list[$i]['mb_payment_tel']);
            $objPHPExcel->getActiveSheet()->setCellValue('V'.($i+2), $member_list[$i]['mb_payment_phone']);
            $objPHPExcel->getActiveSheet()->setCellValue('W'.($i+2), $member_list[$i]['mb_bank']);
            $objPHPExcel->getActiveSheet()->setCellValue('X'.($i+2), $member_list[$i]['mb_bank_input_number']);
            $objPHPExcel->getActiveSheet()->setCellValue('Y'.($i+2), $member_list[$i]['mb_bank_name']);
            $objPHPExcel->getActiveSheet()->setCellValue('Z'.($i+2), $member_list[$i]['mb_bank_name_relationship']);
            $objPHPExcel->getActiveSheet()->setCellValue('AA'.($i+2), $member_list[$i]['mb_bank_number']);
            if($member_list[$i]['mb_payment_type'] == "0"){
                $objPHPExcel->getActiveSheet()->setCellValue('AB'.($i+2), "전월");
            }else if($member_list[$i]['mb_payment_type'] == "1"){
                $objPHPExcel->getActiveSheet()->setCellValue('AB'.($i+2), "당월");
            }else if($member_list[$i]['mb_payment_type'] == "2"){
                $objPHPExcel->getActiveSheet()->setCellValue('AB'.($i+2), "익월");
            }
            if($member_list[$i]['mb_auto_payment'] == "32"){
                $objPHPExcel->getActiveSheet()->setCellValue('AC'.($i+2), "말일");
            }else{
                $objPHPExcel->getActiveSheet()->setCellValue('AC'.($i+2), $member_list[$i]['mb_auto_payment']."일");
            }

            if($member_list[$i]['mb_payment_publish'] == "0"){
                $mb_payment_publish = "발행";
            }else if($member_list[$i]['mb_payment_publish'] == "1"){
                $mb_payment_publish = "미발행";
            }

            if($member_list[$i]['mb_payment_publish_type'] == "0"){
                $mb_payment_publish_type = "영수 발행";
            }else if($member_list[$i]['mb_payment_publish_type'] == "1"){
                $mb_payment_publish_type = "청구 발행";
            }

            $objPHPExcel->getActiveSheet()->setCellValue('AD'.($i+2), $mb_payment_publish.$mb_payment_publish_type);
            $objPHPExcel->getActiveSheet()->setCellValue('AE'.($i+2), $member_list[$i]['mb_payment_day']."일");
        }

        $filename='회원_'.date('Y_m_d').'.xlsx'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.iconv("UTF-8","EUC-KR//IGNORE",$filename).'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache

        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save('php://output');
    }
}
