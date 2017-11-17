$(function(){
	var ids = new Array("schoolIntro","schoolShow","pcLogo","logo","teacherIcon","uploadButton");
	$.each(ids,function(i,n){
		var self = this.toString();
		var uploadImg = new plupload.Uploader({
		    runtimes: 'html5,flash,silverlight,html4',
		    browse_button: self,
		    url: "/goods/goods_img_upload",
		    filters: {
		        max_file_size: '2048kb',
		        mime_types: [
		            {title: "files", extensions: "jpg,png,gif"}
		        ]
		    },
		    multi_selection: false,
		    
		});

		uploadImg.init();

		uploadImg.bind('FilesAdded',function(uploader,files){
			if( self == 'schoolIntro' && $("#schoolIntroPics").children(".pic").length >= 2){
				alert("学校介绍只允许上传两张图片！");
                uploadImg.removeFile(files[0]);
			}else if( (self == 'pcLogo' && $("#pcLogoPics").children(".pic").length >= 1) || (self == 'logo' && $("#logoPics").children(".pic").length >= 1) || (self == 'teacherIcon' && $("#teacherIconPics").children(".pic").length >= 1) ){
				alert("此处只允许上传一张图片！");
                uploadImg.removeFile(files[0]);
			}else{
				uploadImg.start();
			}
	    	
	    });

		uploadImg.bind('FileUploaded',function(up, file, info) {
		   var data = eval("(" + info.response + ")");
		   var str = '<li class="pic"><img style="margin:5px;opacity:1;width:150px;" src="/'+data.img+'" class="current"><br><a href="javascript:void(0)" onclick="$(this).parent().remove();">删除</a><input type="hidden" name="'+self+'[]" value="'+data.img+'" /></li>';
		   switch(self)
			{
			case 'schoolShow':
			  $('#schoolShowPics').append(str);
			  break;
			case 'schoolIntro':
			  $('#schoolIntroPics').append(str);
			  break;
			case 'pcLogo':
			  $('#pcLogoPics').append(str);
			  break;
			case 'logo':
			  $('#logoPics').append(str);
			  break;
			case 'teacherIcon':
			  $('#teacherIconPics').append(str);
			  break;
			case 'uploadButton':
				// $('#ul_pics').append(str);
			  cutPicture(data);
			  break;
			}
		})

		uploadImg.bind('Error',function(up, err) {
            alert(err.message);
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
					alert(data.info);
				}else{
					alert(data.info);
				}
			}
		})
	})

	//商品提交
	$('.alt_btn2').on('click',function(){
		var sForm = $('form[name=goodsForm]');
		var gid = sForm.children('input[name=id]').val();
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
					if( gid == 0 ){
						var str = '<li><img src="/'+data.info.img+'" ><span>'+data.info.name+'</span><em><a href="/seller/goods_edit/id/'+data.info.id+'">编辑</a></em></li>';
						$('.goodsList').append(str);
					}					
					sForm[0].reset();
					$('#goodsForm').hide();
					location.href = '#goods_list';
				}else{
					alert(data.info);
				}
			}
		})
	})

	//教师提交
	$('.alt_btn3').on('click',function(){
		var sForm = $('form[name=teacherForm]');
		var tid = sForm.children('input[name=id]').val();
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
					if( tid == 0 ){
						var str = '<li><img src="/'+data.info.icon+'" ><span>'+data.info.name+'</span><em><a href="/seller/teacher_edit/id/'+data.info.id+'">编辑</a></em></li>';
						$('.teacherList').append(str);
					}
					sForm[0].reset();
					$('#teacherForm').hide();
					location.href = '#teacher_list';
				}else{
					alert(data.info);
				}
			}
		})
	})
	
	$('#addLesson').on('click',function(){
		$('#goodsForm').slideDown();
	})

	$('#addTeacher').on('click',function(){
		$('#teacherForm').slideDown();
	})

	//编辑商品
	$(document).on('click','.goods_item',function(){		
		var id = $(this).data('id');
		$.getJSON('/seller/get_goods_data',{id:id},function(dataJson){
			if(dataJson.status == 1){
				var data = dataJson.info;
				var sForm = $('form[name=goodsForm]');
				sForm.find('input[name=id]').val(data.id);
				sForm.find('input[name=name]').val(data.name);
				sForm.find('input[name=goods_brief]').val(data.goods_brief);
				sForm.find('input[name=limit_num]').val(data.limit_num);
				sForm.find('input[name=limit_start_time]').val(data.limit_start_time);
				sForm.find('input[name=limit_end_time]').val(data.limit_end_time);
				sForm.find('input[name=is_del]').each(function(i){
					$(this).removeAttr('checked');
				})
				sForm.find('input[name=is_del][value='+data.is_del+']').click().attr('checked','checked');

				sForm.find('input[name^=attr_id_1]').each(function(i){
					var inputValue = $(this).val();
					for(var v in data.attr_id_1){
						if( inputValue == data.attr_id_1[v] ){
							$(this).click().attr('checked','checked');
						}
					}
				})
				
				sForm.find('input[name^=attr_id_2]').each(function(i){
					var inputValue = $(this).val();
					for(var v in data.attr_id_2){
						if( inputValue == data.attr_id_2[v] ){
							$(this).click().attr('checked','checked');
						}
					}
				})
				
				if(data.products){
					$('#sepc_list > tbody').empty();
					for(var v in data.products){
						var pro_str = '<tr><td><input class="small" name="specval[]" type="text" value="'+data.products[v].cusval+'" placeholder="例如：突破班"></td><td><input class="tiny" name="student[]" type="text" value="'+data.products[v].student+'"></td><td><input class="tiny" name="classnum[]" type="text" value="'+data.products[v].classnum+'"></td><td><input class="tiny" name="month[]" type="text" value="'+data.products[v].month+'"></td><td><input class="tiny market_price" tt="3" name="market_price[]" type="text" value="'+data.products[v].market_price+'"></td><td><input name="is_show[]" type="checkbox" value="'+data.products[v].is_show+'" checked=""></td><td><a href="javascript:void(0)" onclick="delProduct(this);">删除</a></td></tr>';
						$('#sepc_list > tbody').append(pro_str);
					}					
				}

				ue.setContent(data.content);

				var photo_str = '';
				for(var v in data.photo){
					photo_str += '<li class="pic"><img style="margin:5px;opacity:1;width:150px;" src="/'+data.photo[v].img+'" class="current"><br><a href="javascript:void(0)" onclick="$(this).parent().remove();">删除</a><input type="hidden" name="uploadButton[]" value="'+data.photo[v].img+'"></li>'
				}
				$('#ul_pics').html(photo_str);

				$('#goodsForm').slideDown();
			}else{
				layer.alert(dataJson.info);
			}
		})
	})


	$(document).on('click','.teacher_item',function(){
		var id = $(this).data('id');
		$.getJSON('/seller/get_teacher_data',{id:id},function(dataJson){
			if(dataJson.status == 1){
				var data = dataJson.info;
				var sForm = $('form[name=teacherForm]');
				sForm.find('input[name=id]').val(data.id);
				sForm.find('input[name=name]').val(data.name);
				sForm.find('textarea[name=description]').text(data.description);

				sForm.find('input[name=sex]').each(function(i){
					$(this).removeAttr('checked');
				})
				sForm.find('input[name=sex][value='+data.sex+']').click().attr('checked','checked');

				if(data.icon){
					var str = '<li class="pic"><img style="margin:5px;opacity:1;width:150px;" src="/'+data.icon+'" class="current"><br><a href="javascript:void(0)" onclick="$(this).parent().remove();">删除</a><input type="hidden" name="teacherIcon[]" value="'+data.icon+'"></li>';

					$('#teacherIconPics').append(str);
				}
				

				$('#teacherForm').slideDown();
			}else{
				layer.alert(dataJson.info);
			}
		})
	})
})




function cutPicture(_data){
	var $image = $('.cropper-wrapper > img');
    $image.attr('src','/'+_data.img);

    $image.cropper('destroy').cropper({
	  aspectRatio: 16/11,
	  resizable:false,
	  preview: ".preview",
	});

    var index = layer.open({
	  type: 1,
	  btn:['确定','取消'],
	  skin: 'layui-layer-rim', //加上边框
	  area: ['920px', '520px'], //宽高
	  content: $('.cropper'),
	  yes:function(){
	  	var $imgData=$image.cropper('getCroppedCanvas')
        var dataurl = $imgData.toDataURL('image/jpeg');
        var imgSrc = '<li class="pic"><img style="margin:5px;opacity:1;width:150px;" src="'+dataurl+'" class="current"><br><a href="javascript:void(0)" onclick="$(this).parent().remove();">删除</a><input type="hidden" name="uploadButton[]" value="'+dataurl+'" /></li>';
        $('#ul_pics').append(imgSrc);
        layer.close(index);
	  }
	});
}


