function update_pics()
{
	var _str = '';
	for( i in _course_imgs_arr )
	{
		_str = ( _str == '' ) ? _course_imgs_arr[i] : _str + ',' + _course_imgs_arr[i];
	}
	$('#course_imgs').val( _str );

	var _str = '';
	for( i in _students_imgs_arr )
	{
		_str = ( _str == '' ) ? _students_imgs_arr[i] : _str + ',' + _students_imgs_arr[i];
	}
	$('#students_imgs').val( _str );
}

function initProductTable()
{
	/*var goodsHeadHtml = template.render('goodsHeadTemplate',{'templateData':[]});
	$('#goodsBaseHead').html(goodsHeadHtml);
	var goodsRowHtml = template.render('goodsRowTemplate',{'templateData':[[]]});
	$('#goodsBaseBody').html(goodsRowHtml);*/
}

function delProduct(_self)
{
	$(_self).parent().parent().remove();
	if($('#goodsBaseBody tr').length == 0)
	{
		initProductTable();
	}
}

function checkForm()
{
	var goodsPhoto = [];
	$('#thumbnails img').each(function(){
		goodsPhoto.push(this.alt);
	});

	if(goodsPhoto.length > 0)
	{
		$('input[name="_imgList"]').val(goodsPhoto.join(','));
		$('input[name="img"]').val($('#thumbnails img[class="current"]').attr('alt'));
	} else {
		alert('请上传课程相册');
		return false;
	}

	var _fanli_bili = $('#fanli_bili').val();
	var _fanli_bili = parseFloat( _fanli_bili );

	if ( _fanli_bili < 0.1 )
	{
		alert('课程的返利比例不能小于0.1');
		$('#fanli_bili').focus();
		return false;
	}
	return true;
}

function select_tab(curr_tab)
{
	$("form[name='goodsForm'] > div").hide();
	$("#table_box_"+curr_tab).show();
	$("ul[name=menu1] > li").removeClass('selected');
	$('#li_'+curr_tab).addClass('selected');
}

/**
 *
 * @param obj
 */
function memberPrice(obj)
{
	var sellPrice = $(obj).siblings('input[name^="_sell_price"]')[0].value;
	if($.isNumeric(sellPrice) == false)
	{
		alert('请设置课程的价格');
		return;
	}

	var groupPriceValue = $(obj).siblings('input[name^="_groupPrice"]');
	art.dialog.data('groupPrice',groupPriceValue.val());
	var tempUrl = '{url:/goods/member_price/sell_price/@sell_price@}';
	tempUrl = tempUrl.replace('@sell_price@',sellPrice);
	art.dialog.open(tempUrl,{
		id:'memberPriceWindow',
	    title: '特殊会员组价格',
	    ok:function(iframeWin, topWin)
	    {
	    	var formObject = iframeWin.document.forms['groupPriceForm'];
	    	var groupPriceObject = {};
	    	$(formObject).find('input[name^="groupPrice"]').each(function(){
	    		if(this.value != '')
	    		{
		    		var groupId = this.name.replace('groupPrice','');
		    		groupPriceObject[groupId] = this.value;
	    		}
	    	});

    		var temp = [];
    		for(var gid in groupPriceObject)
    		{
    			temp.push('"'+gid+'":"'+groupPriceObject[gid]+'"');
    		}
    		groupPriceValue.val('{'+temp.join(',')+'}');
    		return true;
		}
	});
}

function addSpec_no()
{
	var tempUrl  = $('input:hidden[name^="_spec_array"]').length > 0 ? '{url:/goods/search_spec}' : '{url:/goods/search_spec/model_id/@model_id@/goods_id/@goods_id@}';
	var model_id = $('[name="model_id"]').val();
	var goods_id = $('[name="id"]').val();
	tempUrl = tempUrl.replace('@model_id@',model_id);
	tempUrl = tempUrl.replace('@goods_id@',goods_id);
	tempUrl = '/index.php?controller=goods&action=select_spec';
	art.dialog.open(tempUrl, {
		title:'添加属性2',
		okVal:'保存',
		ok:function(iframeWin,topWin)
		{
			var addSpecObject = $(iframeWin.document).find('#specs');
			if ( typeof(addSpecObject) != 'object')
			{
				return;
			} else {
				var specIsHere    = getIsHereSpec();
				var specValueData = specIsHere.specValueData;
				var specData      = specIsHere.specData;

				addSpecObject.find('.current input').each(function(){
					var json = $.parseJSON($(this).val());
					eval("var json_value ="+json.value);

					// 字符串处理，兼容原始不规范的规则
					var json_value_temp = new Array();
					for( i in json_value )
					{
						var temp_arr = new Array();
						temp_arr = json_value[i].split(',');
						for( j in temp_arr )
						{
							json_value_temp.push( temp_arr[j] );
						}
					}

					json_value = json_value_temp;
					for( i in json_value )
					{
						var json_temp = json;
						json_temp.value = json_value[i];
						specData[json_temp.id]      = json;

						if ( !specValueData[json_temp.id] )
							specValueData[json_temp.id] = [];
						if ( $.inArray(json_temp.value, specValueData[json_temp.id] ) == -1 )
							specValueData[json_temp.id].push(json_temp.value);
					}

				});

				createProductList(specData,specValueData);
			}
		}
	});
}

function selSpec()
{
	var tempUrl  = $('input:hidden[name^="_spec_array"]').length > 0 ? '{url:/goods/search_spec}' : '{url:/goods/search_spec/model_id/@model_id@/goods_id/@goods_id@}';
	var model_id = $('[name="model_id"]').val();
	var goods_id = $('[name="id"]').val();
	tempUrl = tempUrl.replace('@model_id@',model_id);
	tempUrl = tempUrl.replace('@goods_id@',goods_id);
	art.dialog.open(tempUrl,{
		title:'设置扩展属性',
		okVal:'保存',
		ok:function(iframeWin, topWin)
		{
			var addSpecObject = $(iframeWin.document).find('[id^="vertical_"]');
			if(addSpecObject.length == 0)
			{
				return;
			}

			var specIsHere    = getIsHereSpec();
			var specValueData = specIsHere.specValueData;
			var specData      = specIsHere.specData;
			addSpecObject.each(function()
			{
				$(this).find('input:hidden[name="specJson"]').each(function()
				{
					var json = $.parseJSON(this.value);
					if(!specValueData[json.id])
					{
						specData[json.id]      = json;
						specValueData[json.id] = [];
					}
					specValueData[json.id].push(json['value']);
				});
			});
			createProductList(specData,specValueData);
		}
	});
}

function descartes(list,specData)
{
	var point  = {};
	var result = [];
	var pIndex = null;
	var tempCount = 0;
	var temp   = [];
	for(var index in list)
	{
		if(typeof list[index] == 'object')
		{
			point[index] = {'parent':pIndex,'count':0}
			pIndex = index;
		}
	}

	if(pIndex == null)
	{
		return list;
	}

	while(true)
	{
		for(var index in list)
		{
			tempCount = point[index]['count'];
			temp.push({"id":specData[index].id,"type":specData[index].type,"name":specData[index].name,"value":list[index][tempCount]});
		}

		result.push(temp);
		temp = [];
		while(true)
		{
			if(point[index]['count']+1 >= list[index].length)
			{
				point[index]['count'] = 0;
				pIndex = point[index]['parent'];
				if(pIndex == null)
				{
					return result;
				}
				index = pIndex;
			} else {
				point[index]['count']++;
				break;
			}
		}
	}
}

/**
 * @param picJson => {'flag','img','list','show'}
 **/
function uploadPicCallback(picJson)
{
	var picHtml = template.render('picTemplate',{'picRoot':picJson.img});
	$('#thumbnails').append(picHtml);
	if($('#thumbnails img[class="current"]').length == 0)
	{
		$('#thumbnails img:first').addClass('current');
	}
}

//running running upload img 处理课堂照片的图片上传
function uploadPicCallback2(id, picJson)
{
	if ( picJson.flag == -1 )
	{
		return false;
	}

	var _div = 'thumbnails' + id;
	var picHtml = template.render('picTemplate2',{'picRoot':picJson.img});
	$('#' + _div).append(picHtml);
	if($('#' + _div + ' img[class="current"]').length == 0)
	{
		$('#' + _div + ' img:first').addClass('current');
	}

	var _img_arr = ( id == 2 ) ? _course_imgs_arr : _students_imgs_arr;
	_img_arr.push( picJson.img );

	update_pics();
}

/**
 *
 */
function defaultImage(_self)
{
	$('#thumbnails img').removeClass('current');
	$(_self).addClass('current');
}

/**
 *
 */
function wordsPart()
{
	var goodsName = $('input[name="name"]').val();
	if(goodsName)
	{
		$.getJSON("{url:/goods/goods_tags_words}",{"content":goodsName},function(json)
		{
			if(json.result == 'success')
			{
				$('input[name="search_words"]').val(json.data);
			}
		});
	}
}

function collectAct()
{
	var collectUrl  = $('#collectUrl').val();
	if(!collectUrl)
	{
		alert("请选择采集器并且填写完整的课程详情页URL网址");
		return;
	}
	$.getJSON("{url:/goods/collect_goods_detail}",{"collectUrl":collectUrl},function(json)
	{
		if(json.result == 'success')
		{
			KindEditorObj.html(json.data);
			KindEditorObj.sync();
		}	else {
			alert(json.msg);
		}
	});
}

function getIsHereSpec()
{
	var specValueData = {};
	var specData      = {};
	if($('input:hidden[name^="_spec_array"]').length > 0)
	{
		$('input:hidden[name^="_spec_array"]').each(function()
		{
			var json = $.parseJSON(this.value);
			if(!specValueData[json.id])
			{
				specData[json.id]      = json;
				specValueData[json.id] = [];
			}

			if(jQuery.inArray(json['value'],specValueData[json.id]) == -1)
			{
				specValueData[json.id].push(json['value']);
			}
		});
	}

	return {"specData":specData,"specValueData":specValueData};
}

/**
 * @brief
 * @param object specData
 * @param object specValueData
 **/
function createProductList(specData,specValueData)
{

	var specMaxData = descartes(specValueData,specData);
	var productJson = {};
	$('#goodsBaseBody tr:first').find('input[type="text"]').each(function(){
		productJson[this.name.replace(/^_(\w+)\[\d+\]/g,"$1")] = this.value;
	});

	var productList = [];
	for(var i = 0;i < specMaxData.length;i++)
	{
		var productItem = {};
		for(var index in productJson)
		{
			if(index == 'goods_no')
			{
				if(productJson[index] == '')
				{
					productJson[index] = defaultProductNo;
				}

				if(productJson[index].match(/(?:\-\d*)$/) == null)
				{
					productItem['goods_no'] = productJson[index]+'-'+(i+1);
				} else {
					productItem['goods_no'] = productJson[index].replace(/(?:\-\d*)$/,'-'+(i+1));
				}
			} else {
				productItem[index] = productJson[index];
			}
		}
		productItem['spec_array'] = specMaxData[i];
		productList.push(productItem);
	}

	var goodsHeadHtml = template.render('goodsHeadTemplate',{'templateData':specData});
	$('#goodsBaseHead').html(goodsHeadHtml);
	var goodsRowHtml = template.render('goodsRowTemplate',{'templateData':productList});
	$('#goodsBaseBody').html(goodsRowHtml);
	if($('#goodsBaseBody tr').length == 0)
	{
		initProductTable();
	}

	if ( $("input[name=statement]:checked").val() == '1')
	{
		$('.statement_td').hide();
	}
}

function delSpec(specId)
{
	$('input:hidden[name^="_spec_array"]').each(function()
	{
		var json = $.parseJSON(this.value);
		if(json.id == specId)
		{
			$(this).remove();
		}
	});

	var specIsHere = getIsHereSpec();
	createProductList(specIsHere.specData,specIsHere.specValueData);
}

//alert('dd');
