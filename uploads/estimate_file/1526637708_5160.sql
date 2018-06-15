-- 회원정보 sql
CREATE TABLE `member` (
  `mb_no` int(11) NOT NULL auto_increment,
  `mb_pw` varchar(20) NOT NULL default '',
  `mb_name` varchar(20) NOT NULL default '',
  `mb_email` varchar(50) NOT NULL default '',
  `mb_ph` varchar(50) NOT NULL default '',
  `mb_time` datetime NOT NULL default '',
  PRIMARY KEY  (`mb_no`),
  UNIQUE KEY `mb_email` (`mb_email`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- 예약정보 sql
CREATE TABLE `reservation` (
  `reser_person` int(11) NOT NULL, --예약인원수
  `reser_chk_in` datetime NOT NULL,  --예약시작날짜
  `reser_chk_out` datetime NOT NULL, --예약종료날짜
  `reser_name` varchar(20) NOT NULL, --예약자명
  `reser_ph` varchar(20) NOT NULL, --예약자 전화번호
  `reser_pay` varchar(20) NOT NULL, --결제수단선택
  `reser_charge` int(11) NOT NULL, --결제요금
  `reser_num` varchar(30) NOT NULL, --예약고유번호
  `reser_status` varchar(20) NOT NULL, --예약상태코드
  `reser_mem_yn` char(1) NOT NULL, --회원/비회원구분 y:회원 n:비회원
  `mb_no` int(11), --회원번호
 PRIMARY KEY (`reser_ num`),
 FOREIGN KEY (`mb_no`) REFERENCES `member`(`mb_no`)
  ON DELETE CASCADE
  ON UPDATE CASCADE
) ENGINE=INNODB DEFAULT CHARSET=utf8;

-- 코드테이블
CREATE TABLE `code`(
    `status_code` varchar(100) NOT NULL --예약상태코드
    `status_information`  varchar(5) NOT NULL, --예약상태
    PRIMARY KEY  (`status_code`)
)ENGINE=INNODB DEFAULT CHARSET=utf8;

-- 상태코드값 입력
INSERT INTO `st_code` (`status_code`, `status_information`) VALUES ('reservation_1', '결제대기');
INSERT INTO `st_code` (`status_code`, `status_information`) VALUES ('reservation_2', '결제완료');
INSERT INTO `st_code` (`status_code`, `status_information`) VALUES ('reservation_3', '예약완료');
INSERT INTO `st_code` (`status_code`, `status_information`) VALUES ('reservation_4', '예약취소');

CREATE TABLE `bbs` (
  `bbs_no` int(11) NOT NULL auto_increment,
  `bbs_gru` int(11) NOT NULL,
  `bbs_step` int(11) NOT NULL,
  `bbs_name` varchar(20) NOT NULL,
  `bbs_pwd` varchar(20) NOT NULL,
  `bbs_title` varchar(50) NOT NULL,
  `bbs_content` text(1500),
  `bbs_date` datetime NOT NULL,
  `mb_no` int(11),
 PRIMARY KEY (`bbs_no`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

CREATE TABLE `bbs_file` (
  `file_no` int(11) NOT NULL auto_increment,
  `bbs_no` int(11) NOT NULL,
  `file_name` varchar(20) NOT NULL,
  `file_path` varchar(100) NOT NULL,
 PRIMARY KEY (`file_no`),
 FOREIGN KEY (`bbs_no`) REFERENCES `bbs`(`bbs_no`)
  ON DELETE CASCADE
  ON UPDATE CASCADE
) ENGINE=INNODB DEFAULT CHARSET=utf8;