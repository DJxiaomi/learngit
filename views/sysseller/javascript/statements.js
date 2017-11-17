$(document).ready(function(){
  $('.tab').click(function(){
    $('.tab').removeClass('active');
    $(this).addClass('active');

    var _tt = $(this).attr('tt');
    $('.module_content').hide();
    $('.module_content_' + _tt).show();
    $('#type').val(_tt);
  })
})

function check_form()
{
  var _type = $('#type').val();
  var _bank_name = $('.module_content_' + _type + ' input[name=bank_name]').val();
  var _bank_branch_name = $('.module_content_' + _type + ' input[name=bank_branch_name]').val();
  var _bank_account = $('.module_content_' + _type + ' input[name=bank_account]').val();
  var _business_license = $('.module_content_' + _type + ' input[name=business_license]').val();
  var _statement_paper = $('.module_content_' + _type + ' input[name=statement_paper]').val();

  var msg = '';
  switch( _type )
  {
    case '1':
      msg = '开户银行名称不能为空';
      break;
    case '2':
      msg = '法人姓名不能为空';
      break;
    case '3':
      msg = '负责人账户开户银行名称';
      break;
  }
  if ( _bank_name == '')
  {
    layer.alert(msg, {icon:2} );
    return false;
  } else if ( _bank_branch_name == '')
  {
    layer.alert('开户银行支行名称不能为空', {icon:2} );
    return false;
  } else if ( _bank_account == '')
  {
    layer.alert( '银行帐号不能为空', {icon:2} );
    return false;
  } else if ( _business_license == '')
  {
    layer.alert( '工商营业执照复印件不能为空', {icon:2} );
    return false;
  } else if ( _statement_paper == '' )
  {
    layer.alert( '结算确认书不能为空', {icon:2} );
    return false;
  }

  switch( _type )
  {
    case '1':
      var _public_account = $('.module_content_' + _type + ' input[name=public_account]').val();
      if ( _public_account == '' )
      {
        layer.alert( '对公账户许可证复印件不能为空', {icon:2} );
        return false;
      }  else if ( _bank_account != _true_name )
      {
        layer.alert( '学校对公帐号与学校名称不匹配', {icon:2} );
        return false;
      } else {
        show_content(_type);
        $('#sellerForm').submit();
      }
      break;
    case '2':
      var _legal_name = $('.module_content_' + _type + ' input[name=legal_name]').val();
      var _legal_mobile = $('.module_content_' + _type + ' input[name=legal_mobile]').val();
      var _identity_card_1 = $('.module_content_' + _type + ' input[name=identity_card_1]').val();
      var _identity_card_2 = $('.module_content_' + _type + ' input[name=identity_card_2]').val();
      if ( _legal_name == '' )
      {
          layer.alert( '法人姓名不能为空', {icon:2} );
          return false;
      } else if ( _legal_mobile == '' )
      {
        layer.alert( '法人手机号码不能为空', {icon:2} );
        return false;
      } else if ( _identity_card_1 == '' )
      {
        layer.alert( '法人身份证正面不能为空', {icon:2} );
        return false;
      } else if ( _identity_card_2 == '' )
      {
        layer.alert( '法人身份证反面不能为空', {icon:2} );
        return false;
      } else {
        show_content(_type);
        $('#sellerForm').submit();
      }
      break;
    case '3':
      var _legal_name = $('.module_content_' + _type + ' input[name=legal_name]').val();
      var _identity_card_1 = $('.module_content_' + _type + ' input[name=identity_card_1]').val();
      var _identity_card_2 = $('.module_content_' + _type + ' input[name=identity_card_2]').val();
      var _position_certificate = $('.module_content_' + _type + ' input[name=position_certificate]').val();
      var _attorney_paper = $('.module_content_' + _type + ' input[name=attorney_paper]').val();

      if ( _legal_name == '' )
      {
          layer.alert( '负责人姓名不能为空', {icon:2} );
          return false;
      } else if ( _identity_card_1 == '')
      {
        layer.alert( '负责人身份证正面不能为空', {icon:2} );
        return false;
      } else if ( _identity_card_2 == '' )
      {
        layer.alert( '负责人身份证反面不能为空', {icon:2} );
        return false;
      } else if ( _position_certificate == '' )
      {
        layer.alert( '负责人职位证明不能为空', {icon:2} );
        return false;
      } else if ( _attorney_paper == '' )
      {
        layer.alert( '授权委托书不能为空', {icon:2} );
        return false;
      } else {
        show_content(_type);
        $('#sellerForm').submit();
      }
      break;
  }
  return false;
}

function show_content(type)
{
  $('.module_content').each(function(){
    var _type = $(this).attr('type');
    if ( _type != type )
    {
      $(this).html('');
    }
  })
}
