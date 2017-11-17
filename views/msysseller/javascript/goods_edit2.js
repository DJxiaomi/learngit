$(function(){
	var ids = new Array("schoolIntro","schoolShow","pc_logo","logo","uploadButton");
	$.each(ids,function(i,n){
		var self = this.toString();
		var uploadImg = new plupload.Uploader({
		    runtimes: 'html5,flash,silverlight,html4',
		    browse_button: self,
		    url: "/seller/goods_img_upload",
		    multi_selection: false,
		    resize:{width:800,quality:80}

		});

		uploadImg.init();

		uploadImg.bind('FilesAdded',function(uploader,files){
			if( self == 'schoolIntro' && $("#schoolIntroPics").children(".image-item").length >= 3){
				mui.toast("学校介绍只允许上传两张图片！");
                uploadImg.removeFile(files[0]);
			}else if( (self == 'pc_logo' && $("#pc_logoPics").children(".image-item").length >= 2) || (self == 'logo' && $("#logoPics").children(".image-item").length >= 2)  ){
				mui.toast("商家logo只能上传一张图片！");
                uploadImg.removeFile(files[0]);
			}else{
				$('#loading').show().children('.progress_text').text("上传中 0%");
				uploadImg.start();
			}

	    });

	    uploadImg.bind('UploadProgress',function(up, file) {
	    	var percent = file.percent;
	    	$('#loading').children('.progress').css({"width": percent + "%"});
	    	$('#loading').children('.progress_text').text("上传中 "+percent + "%");
		});

		uploadImg.bind('FileUploaded',function(up, file, info) {
			$('#loading').hide().children('.progress').css({"width": "1%"});
		   var data = eval("(" + info.response + ")");
		   var str = '<div class="image-item space"><img src="/'+data.img+'"/><div class="image-close">删除</div><input type="hidden" name="'+self+'[]" value="'+data.img+'" /></div>';
		   switch(self)
			{
			case 'schoolShow':
			  $('#schoolShowPics').append(str);
			  break;
			case 'schoolIntro':
			  $('#schoolIntroPics').append(str);
			  break;
			case 'pc_logo':
			  $('#pc_logoPics').append(str);
			  break;
			case 'logo':
			  $('#logoPics').append(str);
			  break;
			case 'uploadButton':
			  cutPicture(data);
			  break;
			}
		})

		uploadImg.bind('Error',function(up, err) {
            mui.alert(err.message);
        })
	})


	//商家信息提交
	$('.alt_btn1').on('click',function(){
		var sForm = $('form[name=sellerForm]');
		sForm.submit(function(){
			return false;
		})

		$.ajax({
			type:'post',
			data:sForm.serialize(),
			dataType:'json',
			url:sForm.attr('action'),
			success:function(data){
				if(data.status == 1){
					mui.alert(data.info);
				}else{
					mui.alert(data.info);
				}
			}
		})
	})

	$(document).on('click','.image-close',function(){
		$(this).parent().remove();
	})

})




function cutPicture(_data){
	var $image = $('.cropper-wrapper > img');
    $image.attr('src','/'+_data.img);

    var conWidth = $('.cropper_flag').width();
    var conHeight = $('.cropper-wrapper').height();

    $image.cropper('destroy').cropper({
	  aspectRatio: 16/11,
	  resizable:false,
	  minContainerWidth:conWidth,
	  minContainerHeight:conHeight,
	});

    var index = layer.open({
	  type: 1,
	  title:'裁剪',
	  btn:['确定','取消'],
	  content: $('.cropper'),
	  area: ['98%', '350px'],
	  yes:function(){
	  	var $imgData=$image.cropper('getCroppedCanvas')
        var dataurl = $imgData.toDataURL('image/jpeg');

        var imgSrc = '<div class="image-item space"><img src="'+dataurl+'"/><div class="image-close">删除</div><input type="hidden" name="uploadButton[]" value="'+dataurl+'" /></div>';

        $('#image-list').append(imgSrc);
        layer.close(index);
	  }
	});
}
