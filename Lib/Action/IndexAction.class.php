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
		}

		$this->assign('user_id', $userId);
		$this->assign('user_name', $_SESSION['user_name']);
		$this->display();
    }
}
?>