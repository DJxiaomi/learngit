var userPicker = new mui.PopPicker({
  layer: 1
});
userPicker.setData(catdata);
var showUserPickerButton = document.getElementById('category');
showUserPickerButton.addEventListener('tap', function(event) {
  userPicker.show(function(items) {
    $('#category span').html(items[0].text);
    $('input[name=category_id]').val(items[0].value);
  });
}, false);


$.jUploader({
    button: 'uppic',
    action: _upload_url,
    allowedExtensions: ['jpg', 'png', 'gif', 'jpeg', 'JPG', 'JPEG'],
    onComplete: function(fileName, response){
      	if(response.success){
      		$('#icon').val(response.fileurl);
          $('#uppic').css('background-image','url(/' + response.fileurl + ')');
      	}else{
        	mui.toast('上传失败');
      	}
    }
});

document.getElementById('confirm').addEventListener('tap',function(event){
  var _parents_name = $('input[name=parents_name]').val();
  var _parents_tel = $('input[name=parents_tel]').val();
  var _name = $('input[name=name]').val();
  var _birthday = $('input[name=birthday]').val();
  var _sex = $('input[name=sex]:checked').val();
  var _guardian = $('input[name=guardian]:checked').val();
  var _category_id = $('input[name=category_id]').val();
  var _icon = $('#icon').val();
  _category_id = parseInt(_category_id);
  var _is_agree = $('input[name=is_agree]').is(":checked");

  if ( _parents_name == '')
  {
    mui.toast('家长姓名不能为空');
    return false;
  } else if ( _parents_tel == '') {
    mui.toast('家长电话不能为空');
    return false;
  } else if ( _name == '') {
    mui.toast('宝宝姓名不能为空');
    return false;
  } else if ( _birthday == '') {
    mui.toast('宝宝生日不能为空');
    return false;
  // } else if ( _category_id <= 0 ) {
  //   mui.toast('请选择课程分类');
  //   return false;
  } else if ( _icon == '') {
    mui.toast('请上传宝宝的照片');
    return false;
  } else if (!_is_agree) {
    mui.toast('请勾选阅读申明');
    return false;
  } else {
    $('.mui-input-group').submit();
  }
})


mui('.mui-input-birthday').on('tap', 'input', function(e){
	var date = new Date();
	var optionsJson = '{"value":"' + (date.getFullYear() + 1) + '-' + (date.getMonth() + 1) + '-' + date.getDate() + '", "type":"date","beginYear":1990,"endYear":2020}';
	var options = JSON.parse(optionsJson);
	var picker = new mui.DtPicker(options);
	picker.show(function(rs) {
		mui('.mui-input-birthday input')[0].value = rs.text;
		picker.dispose();
	});
});
