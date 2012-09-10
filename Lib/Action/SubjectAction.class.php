<?php
class SubjectAction extends Action {
	function __construct() {
		parent::__construct();
		if (!isLogin()) {
			redirect(__APP__.'/User/login/');
		}
	}

    public function create(){
		$this->assign('user_id', $_SESSION['user_id']);
		$this->assign('user_name', $_SESSION['user_name']);
		$this->display();
    }
	
	public function add(){
		if ($this->isPost()) {
			$Subject = D('Subject');
			if ($Subject->create()){				
				if ($subjectId = $Subject->add()){
					$token = encryptId($subjectId);
					$data['subject_id'] = $subjectId;
					$data['token'] = $token;
					$Subject->save($data);
					redirect(__APP__);
				} else {
					$this->error('风暴信息无法保存');
				}
			} else {
				redirect(__APP__);
			}
		} else {
			$this->error();
		}
	}
	
	public function edit(){
		if (empty($_GET['id'])) {
			$this->error();
		} else {
			$subjectId = $_GET['id'];
			$userId = $_SESSION['user_id'];
			$Model = M('Subject');
			if ($subject = $Model->where("subject_id = $subjectId and user_id = $userId")
								->find()) {
				$this->assign('subject', $subject);
				$this->display();
			} else {
				$this->error();
			}
		}
	}
	
	public function save(){
		if ($this->isPost()) {
			$Subject = D('Subject');
			if ($Subject->create()){				
				$subjectId = $Subject->save();
				redirect(__APP__);
			} else {
				redirect(__APP__);
			}
		} else {
			$this->error();
		}		
	}
}
?>