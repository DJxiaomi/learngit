$(function(){
	var target = $('.signUp');
	var str = '<form action="site/signUp" name="signUp">';
		str += '<p><label for="name">培训机构：</label><input id="name" type="text" name="name"/></p>';
		str += '<p><label for="linkman">负责人：</label><input id="linkman" type="text" name="linkman"/></p>';
		str += '<p><label for="phone">联系方式：</label><input id="phone" type="text" name="phone"/></p>';
		str += '<p><input class="btn_sign" type="submit" value="立即报名"/></p>';
		str += '</form>';
	target.append(str);

})

$(document).on('click','.btn_sign',function(){
	$(this).parents('form').submit(function(){
		return false;
	})

	var name = $('#name').val();
	var linkman = $('#linkman').val();
	var phone = $('#phone').val();
	
	if(name == ''){
		layer.alert('请填写培训机构！');
		return false;
	}
	if(linkman == ''){
		layer.alert('请填写负责人！');
		return false;
	}
	if(phone == ''){
		layer.alert('请填写联系方式！');
		return false;
	}
	
	$.getJSON('/site/signUp',{name:name,linkman:linkman,phone:phone,typeid:pid},function(data){
		if(data.status == 1){
			layer.alert(data.info,{icon:1},function(){
				location.reload();
			});
			
		}else{
			layer.alert(data.info,{icon:2});
		}
	})

	
})