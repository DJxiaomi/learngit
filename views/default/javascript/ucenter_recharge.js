function check_form()
{
  if($('[name="payment_id"]:checked').length == 0)
  {
    alert('请选择支付方式');
    return false;
  }

  if($('[name="recharge"]').val() <= 0)
  {
    alert('要充值的金额必须大于0元');
    return false;
  }
}
