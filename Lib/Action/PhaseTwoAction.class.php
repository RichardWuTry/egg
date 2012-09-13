<?php
class PhaseTwoAction extends Action {
	function attend(){
		if (empty($_GET['token'])) {
			$this->error();
		} else {
			$token = $_GET['token'];
			if ($iPos = strpos($token, 'I')) {
				$userToken = substr($token, 0, $iPos);
				$subjectToken = substr($token, $iPos+1);
				$userId = decryptToken($userToken);
				$subjectId = decryptToken($subjectToken);
				//$this->error('userId:'.$userId.'subjectId:'.$subjectId);
				if ($userId && $subjectId) {
					$User = M('User');
					if ($currUser = $User->where("user_id = $userId")
										->field("name")
										->find()) {						
						$Subject = M('Subject');
						if ($currSubject = $Subject->where("subject_id = $subjectId")
													->find()) {
							$Model = M();
							if ($comments = $Model->query("select
															s.solution_id,
															s.content,
															c.comment_id,
															c.benefit,
															c.drawback
														from
															solution s
															left join
															(select
																comment_id,
																solution_id,
																benefit,
																drawback
															from
																comment
															where
																user_id = $userId) as c
															on
																s.solution_id = c.solution_id
														where
															s.subject_id = $subjectId")){
								$this->assign('user_id', $userId);
								$this->assign('user_name', $currUser['name']);								
								$this->assign('subject', $currSubject);
								$this->assign('comments', $comments);
								$this->display();								
							} else {
								$this->error('5');
							}						
						} else {
							$this->error('4');
						}						
					} else {
						$this->error('3');
					}					
				} else {
					$this->error('2');
				}
			} else {
				$this->error('1');
			} 
		}
	}

	function sendMail() {
		if ($this->isPost()) {
			$subjectId = $_POST['subjectId'];			
			$Model = M();
			if ($users = $Model->query("select
											u.user_id,
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
				//获取风暴发布者信息
				$hostId = $_SESSION['user_id'];
				$User = M('User');
				$host = $User->where("user_id = $hostId")
							->field("name, email")
							->find();
				
				//保存第二阶段链接
				$phaseTwoToken = encryptId($subjectId).'I'.substr(sha1(time()),0,10);
				$Subject = M('Subject');
				$data['subject_id'] = $subjectId;
				$data['phase_two_token'] = $phaseTwoToken;
				$Subject->save($data);
				
				//发送邮件
				$subject = '[头脑风暴机] 百家争鸣邀请';
				$failList = array();
				require_once COMMON_PATH.'/Mail/mail.php';
				for ($i = 0; $i < count($users); $i++) {
					$userName = $users[$i]['name'];
					$userMail = $users[$i]['email'];
					$token = encryptId($users[$i]['user_id']).'I'.encryptId($subjectId);
					
					$body = $this->prepareEmailBody($host['name'], 
													$host['email'], 
													$userName,
													$token);
					if (!sendMail(array($userMail), $subject, $body)) {
						array_push($failList, $userName);
					}
				}				
				if (count($failList) > 0) {
					$this->ajaxReturn($data, '发送给'.implode(',',failList).'失败', 0);
				} else {
					$this->ajaxReturn($data, '百家争鸣邀请邮件已发送', 1);
				}				
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
		$host_name = $hostName.'('.$hostMail.')';
		
		$body = file_get_contents(TMPL_PATH.'/PhaseTwo/phaseTwoEmail.html');
		$body = mb_eregi_replace('{index_page}', $index_page_link, $body);
		$body = mb_eregi_replace('{host_name}', $host_name, $body );
		$body = mb_eregi_replace('{user_name}', $userName, $body);				
		$body = mb_eregi_replace('{phase_two_link}', $phase_two_link, $body);
		
		return $body;
	}	
}
?>