<?php
class PhaseOneAction extends Action {
	function __construct() {
		parent::__construct();
		if (!isLogin()) {
			redirect(__APP__.'/User/login/');
		}
	}

	public function attend(){
		if (empty($_GET['token'])) {
			$this->error();
		} else {
			$token = $_GET['token'];
			if ($subjectId = decryptToken($token)){
				$Model = M('Subject');
				if ($subject = $Model->where("subject_id = $subjectId")
									->find()) {
					$userId = $_SESSION['user_id'];

						if (date("Y-m-d H:i:s") >= $subject['close_datetime']) {
							$this->error("头脑风暴 之 '一家之言' 阶段已结束");				
						} else {
							
							$Solution = M('Solution');
							if ($hisSolution = $Solution->where("subject_id = $subjectId and user_id = $userId")
														->find()){
								$this->assign('hisSolution', $hisSolution);
							}
							$this->assign('subject', $subject);
							$this->assign('user_id', $userId);
							$this->assign('user_name', $_SESSION['user_name']);
							$this->display();	
						}

				} else {
					$this->error();
				}
			} else {
				$this->error();
			}			
		}
	}
	
	public function addSolution(){
		if ($this->isPost()) {
			$Solution = D('Solution');
			if ($Solution->create()) {
				if (empty($Solution->solution_id)){
					if ($solution_id = $Solution->add()) {
						$this->error("太棒了，您的一家之言提交成功 :-)");
					} else {
						$this->error("抱歉，页面出错了 :-(");
					}
				} else {
					if ($Solution->save()) {
						$this->error("一家之言更新成功");
					} else {
						$this->error("一家之言未更新");
					}
				}
			} else {
				$this->error("抱歉，页面出错了 :-(");
			}
		} else {
			$this->error();
		}
	}
}
?>