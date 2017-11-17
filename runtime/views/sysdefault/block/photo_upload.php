<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/jquery/jquery-1.12.4.min.js"></script>
<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artdialog/artDialog.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artdialog/plugins/iframeTools.js"></script><link rel="stylesheet" type="text/css" href="/runtime/_systemjs/artdialog/skins/aero.css" />
</head>
<body class="__upload">
<section class="__upload_form">
	<form action="#" method='post' enctype='multipart/form-data' id="uploadForm">
	<div>
		<span>选择图片文件</span>
		<label>
			<input type='file' class='__file' name='attach' />
			<p>点击上传文件<em class="__name"></em></p>
		</label>
	</div>
	</form>
</section>
<style>
.__upload,.__upload * {margin: 0;padding: 0;list-style: none;}
.__upload .__upload_form {padding: 20px;}
.__upload .__upload_form div {position: relative;}
.__upload .__upload_form div span {
	position: absolute;height: 10px;line-height: 10px;background: #fff;top: -7px;padding: 0 10px;left: 5px;
	color: #999;font-size: 11px;z-index: 1;
}
.__upload .__upload_form div label{
	display: block;width: 100%;height: 36px;line-height: 36px;border-radius: 0;border: none;
	background: #fafafa;box-shadow: 0 0 0 1px #ddd;cursor: pointer;
}
.__upload .__upload_form div label input {display: none;}
.__upload .__upload_form div label p {text-indent: 10px;font-size: 14px;}
.__upload .__upload_form div label p .__name {margin-left: 10px;color: red;}
</style>
<script type="text/javascript">
$(function(){
	var urlVal = "<?php echo IFilter::addSlash( IReq::get('callback') );?>";
	$('#uploadForm').attr('action',urlVal);
	$(".__file").on("change", function() {
		var arr=$(this).val().split('\\');
        var fileName=arr[arr.length-1];
        $(".__name").html(fileName);
	})
});
</script>
</body>
</html>
