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
			$Model = M();
			//$solutions = array();
			for ($i = 0; $i < count($storms); $i++) {
				$subjectId = $storms[$i]['subject_id'];
				
				$solutionCnt = 0;
				if ($phaseOneUsers = $Model->query("select
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
					$storms[$i]['phase_one_users'] = $phaseOneUsers;
					$solutionCnt = count($phaseOneUsers);
				}				
				
				if ($solutionCnt > 1 && !empty($storms[$i]['phase_one_users'])) {
					$commentCnt = 0;
					if ($phaseTwoUsers = $Model->query("select
															u.name,
															u.email
														from
															solution s
															join
															comment c
															on
																s.solution_id = c.solution_id
															join
															user u
															on
																c.user_id = u.user_id
														where
															s.subject_id = $subjectId
														group by
															u.name,
															u.email
														having
															count(1) >= $solutionCnt-1")) {
						$storms[$i]['phase_two_users'] = $phaseTwoUsers;
						$commentCnt = count($phaseTwoUsers);
						$storms[$i]['phase_two_finish_rate'] = round($commentCnt/$solutionCnt*100, 2);
					}				
				}
			}
			$this->assign('storms', $storms);
			$this->assign('serverName', $_SERVER["SERVER_NAME"]);
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