mui('.mui-input-row-time').on('tap', 'input', function(e){
	var date = new Date();
	var optionsJson = '{"value":"' + (date.getFullYear() + 1) + '-' + (date.getMonth() + 1) + '-' + date.getDate() + '", "type":"date","beginYear":2016,"endYear":2020}';
	var options = JSON.parse(optionsJson);
	var picker = new mui.DtPicker(options);
	picker.show(function(rs) {
		mui('.mui-input-row-time input')[0].value = rs.text;
		picker.dispose();
	});
});

mui('body').on('tap','.mui-radio input',function(){
	if ( this.getAttribute('value') == '1')
	{
		$('input[name=max_price]').val('');
		$('input[name=max_price]').removeAttr('readonly');
	} else {
		$('input[name=max_price]').val('0');
		$('input[name=max_price]').attr("readonly","readonly");
	}
})
mui('body').on('tap','.mui-btn-primary',function(){
	var max_price = $("input[name=max_price]").val();
	var max_order_chit = $("input[name=max_order_chit]").val();
	var max_order_amount = $("input[name=max_order_amount]").val();
	var limittime = $("input[name=limittime]").val();

	if (max_price == '')
	{
		mui.toast('请输入售价');
		return false;
	} else if ( max_order_chit == '' ) {
		mui.toast('请输入可抵扣值');
		return false;
	} else if ( max_order_amount == '' ) {
		mui.toast('请输入满多少元使用');
		return false;
	} else if ( limittime == '' ) {
		mui.toast('请选择结束时间');
		return false;
	}

	$('.mui-input-group').submit();
})
