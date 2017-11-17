$(document).ready(function(){
  cell_ready();
})

function cell_ready()
{
  $('.mui-table-view-cell').on('click',function(){
    var _id = parseInt($(this).attr('id'));
    if (_id > 0 )
    {
      var url = dqk_detail_url.replace('@id@', _id);
      location.href = url;
    }
  })
}

var userPicker = new mui.PopPicker({
  layer: 1
});
userPicker.setData(catdata);
var showUserPickerButton = document.getElementById('choose_category');
showUserPickerButton.addEventListener('tap', function(event) {
  userPicker.show(function(items) {
    $('#choose_category').html(items[0].text);
    $('#cat_id').val(items[0].value);
    $('#type').val('0');
    refresh();
  });
}, false);

function check_search()
{
  var _keyword = $('#keyword').val();
  if ( _keyword == '')
  {
    mui.toast('请输入关键词');
    return false;
  } else {
    $('#type').val('0');
    refresh();
  }
  return false;
}

function filter_result(_num)
{
  $('#type').val(_num);
  refresh();
}

function refresh()
{
  layer.open({type: 2});
  page = 1;
  var cat_id = $('#cat_id').val();
  var keyword = document.getElementById('keyword').value;
  var type = document.getElementById('type').value;
  var params = 'page=' + page + '&cat_id=' + cat_id + '&keyword=' + keyword + '&type=' + type;
  mui.get(SITE_URL + 'site/get_dqk_seller_list_ajax', params, function(json){
    if (json.done)
    {
      var result = json.retval;
      var html = '';
      mui.each(result,function(index,item){
        var url = dqk_detail_url.replace('@id@',item.seller_id);
        var cls = (parseInt(item.commission) > 0) ? 'type-discount' : '';
        html += '<a href="' + url + '"><div class="mui-card" id="' + item.seller_id + '">' +
                         '<div class="mui-card-header mui-card-media">' +
                           '<img src="/' + item.logo + '" />' +
                           '<div class="mui-manual-type ' + cls + '"></div>' +
                           '<div class="mui-card-bg"></div>' +
                           '<div class="mui-card-info">' +
                           '<div class="t-left">已售：' + item.c_sale + '</div>' +
                           '<div class="t-right"><span>原价：' + item.max_order_chit + '</span><i>&yen;</i>' + item.max_price + '</div>' +
                           '</div>' +
                         '</div>' +
                         '<div class="mui-card-content">' +
                            '<div class="t-left"><img src="/' + item.b_logo + '" /></div>' +
                            '<div class="t-right">' +
                              '<div class="goods-name">' + item.seller_name + '短期课-' + item.use_times + '课时</div>' +
                              '<div class="goods-addr">' + item.address + '</div>' +
                              '<div class="goods-content">' + item.brief + '</div>' +
                            '</div>' +
                         '</div>' +
                       '</div></a>';
      $('.dqk_list').html(html);
      cell_ready();
      });

      location.href = "#result";
    }
    layer.closeAll();
  },'json');
}
