<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
<!--[if lt IE 9]>
<script type="text/javascript" src="http://libs.useso.com/js/html5shiv/3.7/html5shiv.min.js"></script>
<script type="text/javascript" src="http://libs.useso.com/js/respond.js/1.4.2/respond.min.js"></script>
<script type="text/javascript" src="http://cdn.bootcss.com/css3pie/2.0beta1/PIE_IE678.js"></script>
<![endif]-->
<link type="text/css" rel="stylesheet" href="/Public/Admin/static/h-ui/css/H-ui.css"/>
<link type="text/css" rel="stylesheet" href="/Public/Admin/static/h-ui.admin/css/H-ui.admin.css"/>
<link type="text/css" rel="stylesheet" href="/Public/Admin/css/font-awesome.min.css"/>
<!--[if IE 7]>
<link href="http://www.bootcss.com/p/font-awesome/assets/css/font-awesome-ie7.min.css" rel="stylesheet" type="text/css" />
<![endif]-->
<title>修改密码</title>
</head>
<body>
<div class="pd-20">
  <form class="Huiform" id="loginform" >
    <input type="hidden" name="id" id='UID' value="<?php echo ($data["id"]); ?>">
    <table class="table table-border table-bordered table-bg">
      <thead>
        <tr>
          <th >修改密码</th>
          <td><?php echo ($data["username"]); ?></td>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th class="text-r" width="30%">旧密码：</th>
          <td><input name="oldpassword" id="oldpassword" class="input-text" type="password" autocomplete="off" placeholder="密码" tabindex="1" datatype="*6-16" nullmsg="请输入旧密码！" errormsg="4~16个字符，区分大小写！"> 
          </td>
        </tr>
        <tr>
          <th class="text-r">新密码：</th>
          <td><input name="newpassword" id="newpassword" class="input-text" type="password" autocomplete="off" placeholder="设置密码" tabindex="2" datatype="*6-16"  nullmsg="请输入您的新密码！" errormsg="4~16个字符，区分大小写！" > 
          </td>
        </tr>
        <tr>
          <th class="text-r">再次输入新密码：</th>
          <td><input name="newpassword2" id="newpassword2" class="input-text" type="password" autocomplete="off" placeholder="确认新密码" tabindex="3" datatype="*" recheck="newpassword" nullmsg="请再输入一次新密码！" errormsg="您两次输入的新密码不一致！"> 
          </td>
        </tr>
        <tr>
          <th></th>
          <td>
            <button type="button" class="btn btn-success radius" id="admin-password-save" name="admin-password-save"><i class="icon-ok"></i> 确定</button>
          </td>
        </tr>
      </tbody>
    </table>
  </form>
</div>
<!--<script type="text/javascript" src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
<script type="text/javascript" src="/Public/Admin/js/Validform_v5.3.2_min.js"></script>
<script type="text/javascript" src="/Public/Admin/layer/layer.min.js"></script>
<script type="text/javascript" src="/Public/Admin/static/js/H-ui.js"></script>
<script type="text/javascript" src="/Public/Admin/static/js/H-ui.admin.js"></script>-->

<script type="text/javascript" src="/Public/Admin/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="/Public/Admin/lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="/Public/Admin/static/h-ui/js/H-ui.min.js"></script>
<script type="text/javascript" src="/Public/Admin/static/h-ui.admin/js/H-ui.admin.js"></script> <!--/_footer 作为公共模版分离出去-->

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="/Public/Admin/lib/jquery.validation/1.14.0/jquery.validate.js"></script>
<script type="text/javascript" src="/Public/Admin/lib/jquery.validation/1.14.0/validate-methods.js"></script>
<script type="text/javascript" src="/Public/Admin/lib/jquery.validation/1.14.0/messages_zh.js"></script>

<script type="text/javascript">
//$(".Huiform").Validform();

$(function () {

    $('#admin-password-save').click(
        function () {
            //layer.msg('修改成功!', {icon:1, time: 2000});
            var id = $('#UID').val();
            var oldpassword = $('#oldpassword').val();
            var newpassword = $('#newpassword').val();
            var newpassword2 = $('#newpassword2').val();
            if (newpassword != newpassword2) {
                layer.msg('两次密码输入不正确!', {time: 2000});
                return;
            }
            $.ajax({
                'type': 'post',
                'dataType': 'json',
                'data': 'id=' + id + "&old=" + oldpassword + "&password=" + newpassword,
                'url': "/index.php/Admin/Manager/passwordEdit",
                'success': function (data) {

                    if (data.code == 10000) {
                        layer.msg('修改成功!', {time: 2000});
                    } else {
                        layer.msg(data.msg, {time: 2000});
                    }
                }

            });
            function tanchuang() {
                parent.layer.close(index)
            }
            var index = parent.layer.getFrameIndex(window.name);
            //parent.$('.btn-refresh').click();
            setTimeout(tanchuang,2000);
        }
    );

});



</script>

<script>
/*
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "//hm.baidu.com/hm.js?080836300300be57b7f34f4b3e97d911";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3F080836300300be57b7f34f4b3e97d911' type='text/javascript'%3E%3C/script%3E"));
*/
</script>
</body>
</html>