<?php
class CommentModel extends Model {
	protected $_validate = array(
		array('solution_id', 'require', '信息缺失，无法保存评论', 1),
		array('user_id', 'require', '信息缺失，无法保存评论', 1),
		array('benefit', 'require', '请填写1～2个优点', 1),
		array('drawback', 'require', '请填写1～2个缺点', 1),
	);
	
	protected $_auto = array(
		array('create_at', 'date("Y-m-d H:i:s")', 1, 'function'),
	);
}
?>