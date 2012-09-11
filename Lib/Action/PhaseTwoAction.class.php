<?php
class PhaseTwoAction extends Action {
	function __construct() {
		parent::__construct();
		if (!isLogin()) {
			redirect(__APP__.'/User/login/');
		}
	}
	
	function sendMail() {
		if ($this->isPost()) {
			$subjectId = $_POST['subjectId'];			
			$Model = M();
			if ($users = $Model->query("select
											s.solution_id,
											u.name,
											u.email
										from
											solution s
											join
											user u
											on
												s.user_id = u.user_id
										where
											s.subject_id = $subjectId")) {
				$hostId = $_SESSION['user_id'];
				$User = M('User');
				$host = $User->where("user_id = $hostId")
							->field("name, email")
							->find();
											
				$subject = '[头脑风暴鸡] 百家争鸣邀请';
				require_once COMMON_PATH.'/Mail/mail.php';
				for ($i = 0; $i < count($users); $i++) {
					$userName = $users[$i]['name'];
					$userMail = $users[$i]['email'];
					$token = encryptId($users[$i]['solution_id']);
					
					$body = $this->prepareEmailBody($host['name'], 
													$host['email'], 
													$userName,
													$token);
				}							
				$this->success('sendMail');
			} else {
				$this->error("第一阶段无参与者，故无法发送邮件");
			}			
		} else {
			$this->error();
		}
	}
	
	private function prepareEmailBody($hostName, $hostMail, $userName, $token) {
		$serverName = $_SERVER["SERVER_NAME"];
		$index_page_link = "http://$serverName".__APP__;
		$phase_two_link = "http://$serverName".__URL__."/attend/token/$token/";
		
		$body = file_get_contents(TMPL_PATH.'/User/newPasswordEmail.html');
		$body = mb_eregi_replace('{index_page}', $index_page_link, $body);
		$body = mb_eregi_replace('{user_name}', $userName, $body);		
		$body = mb_eregi_replace('{reset_password_link}', $reset_password_link, $body);
		
		return $body;
	}	
}
?>