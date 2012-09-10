<?php
class IndexAction extends Action {
	function __construct() {
		parent::__construct();
		if (!isLogin()) {
			redirect(__APP__.'/User/login/');
		}
	}

    public function index(){
		$userId = $_SESSION['user_id'];
		$Subject = M('Subject');
		if ($storms = $Subject->where("user_id = $userId and is_active = 1")
							->order('create_at desc')
							->select()) {
			$this->assign('storms', $storms);
			$this->assign('serverName', $_SERVER["SERVER_NAME"]);
			
			$Model = M();
			$solutions = array();
			foreach($storms as $s) {
				$subjectId = $s['subject_id'];
				if ($sol = $Model->query("select
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
					$solutions[$subjectId] = $sol;
				}
			}
			$this->assign('solutions', $solutions);
		}

		$this->assign('user_id', $userId);
		$this->assign('user_name', $_SESSION['user_name']);
		$this->display();
    }
	
	public function inactive(){
		if ($this->isPost()){
			$subjectId = $_POST['subjectId'];
			$userId = $_SESSION['user_id'];
			$data['is_active'] = 0;
			$Subject = M('Subject');
			if ($Subject->where("subject_id = $subjectId and user_id = $userId")
						->save($data)){
				$this->success('subject_'.$subjectId);
			} else {
				$this->error('未能隐藏该风暴');
			}
		}
	}
}
?>