<?php

/**

 支持手机端的上传插件
 
 by molimin

 */

class Newupload

{

	//插件路径

	public $path;



	//提交地址

	public $submit;



	/**

	 * @brief 构造函数

	 * @param string $submit 处理地址

	 */

	public function __construct($submit = '')

	{

		$this->path   = IUrl::creatUrl().'plugins/newupload/';

		$this->submit = $submit ? $submit : '/goods/goods_img_upload';



echo <<< OEF

	<script type="text/javascript" src="{$this->path}plupload.full.min.js"></script>

OEF;

	}



	/**

	 * @brief 展示插件

	 * @param string $name 用户名

	 * @param string $pwd  密码

	 */

	public function show($name,$pwd)

	{

		$sessionName = ISafe::name();

		$sessionId   = ISafe::id();

		$uploadUrl   = IUrl::creatUrl($this->submit);

		$admin_name  = $name;

		$admin_pwd   = $pwd;



echo <<< OEF

		  <script type="text/javascript">
            var uploader = new plupload.Uploader({
                runtimes: 'html5,flash,silverlight,html4', 
                browse_button: 'uploadButton', 
                url: "ajax.php", 
                flash_swf_url: 'plupload/Moxie.swf',
                silverlight_xap_url: 'plupload/Moxie.xap', 
                filters: {
                    max_file_size: '500kb', 
                    mime_types: [
                        {title: "files", extensions: "jpg,png,gif"}
                    ]
                },
                multi_selection: true, 
                init: {
                    FilesAdded: function(up, files) { 
                        if ($("#ul_pics").children("li").length > 3) {
                            alert("您最多可以上传三张图片！");
                            uploader.destroy();
                        } else {
                            var li = '';
                            plupload.each(files, function(file) { 
                                li += "<li id='" + file['id'] + "'><div class='progress'><span class='bar'></span><span class='percent'>0%</span></div></li>";
                            });
                            $("#ul_pics").append(li);
                            uploader.start();
                        }
                    },
                    UploadProgress: function(up, file) { 
                 var percent = file.percent;
                        $("#" + file.id).find('.bar').css({"width": percent + "%"});
                        $("#" + file.id).find(".percent").text(percent + "%");
                    },
                    FileUploaded: function(up, file, info) { 
                       var data = eval("(" + info.response + ")");
                        $("#" + file.id).html("<div class='img'><img src='" + data.pic + "'/></div><p>" + data.name + "</p>");
                    },
                    Error: function(up, err) { 
                        alert(err.message);
                    }
                }
            });
            uploader.init();
        </script>

OEF;

	}

}