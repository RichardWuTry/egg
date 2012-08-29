<?php
class IndexAction extends Action {
    public function index(){
		$this->assign('user_name', 'Richard');
		$this->display();
    }
}
?>