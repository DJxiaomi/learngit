$(function(){
  //编辑器载入
  KindEditor.ready(function(K){
    K.create('#content', {
     allowFileManager: true,
     imageTabIndex: 1,
     afterBlur: function(){this.sync();},
     items : [
     'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
     'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
     'insertunorderedlist', '|', 'emoticons', 'multiimage', 'link']
    });
  });
});
