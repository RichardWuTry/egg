<?php
class PhaseOneAction extends Action {
	public function attend(){
		if (empty($_GET['token'])) {
			$this->error();
		} else {
			$token = $_GET['token'];
			if ($subjectId = decryptToken($token)){
				$Model = M('Subject');
				if ($subject = $Model->where("subject_id = $subjectId")
									->find()) {
					$this->assign('subject', $subject);
					$this->display();					
				} else {
					$this->error();
				}
			} else {
				$this->error();
			}			
		}
	}
}
?>