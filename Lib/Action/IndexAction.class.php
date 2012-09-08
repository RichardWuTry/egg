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
		if ($storms = $Subject->where("user_id = $userId")
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
}
?>