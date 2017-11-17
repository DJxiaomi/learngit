function active_category(manual_id,cat_id)
{
  layer.open({
    type: 1,
    title:'请选择要激活的分类',
    style:'width:90%;overflow:hidden;',
    btn:['激活','关闭'],
    content: $('.choose_category').html(),
    yes:function(index){
      var select = $('.layui-m-layercont select[name=category_id]');
      var _category_id = select.val();
      var cat_arr = cat_id.split(',');
      var is_exists = false;
      for( var i = 0; i < cat_arr.length; i++ )
      {
        if ( cat_arr[i] == _category_id )
          is_exists = true;
      }

      layer.close(index);
      if ( is_exists )
      {
        mui.alert('该分类已经激活，请选择其他分类');
        return false;
      } else {
          location.href = creatUrl('/simple/cart2n/id/1981/num/1/type/goods/manual_id/' + manual_id + '/category_id/' + _category_id);
      }
    }
  });
}
