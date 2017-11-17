mui('body').on('tap','.mui-btn-primary',function(){
  location.href = SITE_URL + 'seller/chit_edit';
})
function del(id)
{
	var btnArray = ['取消', '删除'];
	mui.confirm('您确定要删除该代金券吗？', '提示信息', btnArray, function(e) {
			if (e.index == 1) {
					location.href = chit_del + '/' + id;
			}
	})
}
