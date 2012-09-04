<?php
class SubjectAction extends Action {
    public function create(){
		$this->assign('user_name', 'Richard');
		$this->display();
    }
	
	public function add(){
		if ($this->isPost()) {
			$Subject = D('Subject');
			if ($Subject->create()){
				if ($id = $Subject->add()){
					redirect(__APP__);
				} else {
					$this->error('风暴信息无法保存');
				}
			}
		} else {
			$this->error();
		}
	}
}
?>