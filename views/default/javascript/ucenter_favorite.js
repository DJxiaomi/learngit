//修改备注信息
function edit_summary(idVal)
{
	var summary = $("#summary_val_"+idVal).val();
	if($.trim(summary))
	{
		$.getJSON( _edit_summary_url,{id:idVal,summary:summary},function(content){
			if(content.isError == false)
			{
				$('#summary_show_'+idVal).html(summary);
				$("#summary_box_"+idVal).hide();$("#summary_button_box_"+idVal).show();
				$('#summary_val_'+idVal).val('');
			}
			else
			{
				alert(content.message);
			}
		});
	}
	else
	{
		alert('请填写备注信息');
	}
}

//统计总数
$('#favoriteSum').html('{$favoriteSum}');

//[ajax]加入购物车
function joinCart_ajax(id,type)
{
	$.getJSON( _join_cart_url,{goods_id:id,type:type},function(content){
		if(content.isError == false)
		{
			var count = parseInt($('[name="mycart_count"]').html()) + 1;
			$('[name="mycart_count"]').html(count);
			alert(content.message);
		}
		else
		{
			alert(content.message);
		}
	});
}

//列表页加入购物车统一接口
function joinCart_list(id)
{
	$.getJSON( _get_products_url,{"id":id},function(content){
		if(!content)
		{
			joinCart_ajax(id,'goods');
		}
		else
		{
			var url = _product_url;
			url = url.replace('@goods_id@',id);
			artDialog.open(url,{
				id:'selectProduct',
				title:'选择货品到购物车',
				okVal:'加入购物车',
				ok:function(iframeWin, topWin)
				{
					var goodsList = $(iframeWin.document).find('input[name="id[]"]:checked');

					//添加选中的课程
					if(goodsList.length == 0)
					{
						alert('请选择要加入购物车的课程');
						return false;
					}
					var temp = $.parseJSON(goodsList.attr('data'));

					//执行处理回调
					joinCart_ajax(temp.product_id,'product');
					return true;
				}
			})
		}
	});
}
