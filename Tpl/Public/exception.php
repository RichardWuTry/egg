<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>头脑风暴鸡</title>
	<style>
		h1 {
			font-family:"Microsoft Yahei","微软雅黑","Helvetica Neue",Arial,"Liberation Sans",FreeSans,sans-serif;
		}
	</style>
</head>
<body>
	<div style="margin:60px auto;text-align:center;">
		<div><img src="__PUBLIC__/images/logo1.png" alt="头脑风暴鸡" /></div>
		<h1 id="msg" style="margin-top:130px;">
		<?php 
			if(isset($error) && is_string($error)) {
				echo $error;
			} else {
				echo "抱歉，您访问的页面不存在 :-(";
			}
		?>
		</h1>
	</div>
</body>
</html>