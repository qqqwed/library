<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
<!--[if lt IE 9]>

<![endif]-->
<link type="text/css" rel="stylesheet" href="./Public/Admin/static/css/H-ui.css"/>
<link type="text/css" rel="stylesheet" href="./Public/Admin/static/css/H-ui.admin.css"/>
<!--<link type="text/css" rel="stylesheet" href="font/font-awesome.min.css"/>-->
<!--[if IE 7]>
<![endif]-->
<title>修改密码</title>
</head>
<body>
<div class="pd-20">
  <form class="Huiform" action="/index.php/Admin/Reader/edit" method="post">
    <table class="table">
      <tbody>
        <tr>
          <th width="100" class="text-r"><span class="c-red">*</span>新密码：</th>
          <td><input type="password" style="width:200px" class="input-text" value="" id="new-password" name="password"></td>
        </tr>
        <tr>
          <th class="text-r"><span class="c-red">*</span> 确认密码：</th>
          <td><input type="password" style="width:200px" class="input-text" value="" id="new-repassword" name="repassword"></td>
        </tr>
        <tr>
          <td><input type="hidden" style="width:200px" class="input-text" value="<?php echo ($_GET['id']); ?>" id="reader_id" name="reader_id"></td>
        </tr>
        <tr>
          <th></th>
          <td><button class="btn btn-success radius" type="submit"><i class="icon-ok"></i>确定 </button></td>
        </tr>
      </tbody>
    </table>
  </form>
</div>

<!--<script type="text/javascript" src="./Public/Admin/static/js/H-ui.js"></script>-->
<!--<script type="text/javascript" src="./Public/Admin/static/js/H-ui.admin.js"></script>-->
<script>
  var btn = document.getElementsByClassName('btn-success')[0];
  btn.onclick = function(){
      var new_v = document.getElementById('new-password').value;
      var new_re = document.getElementById('new-repassword').value;
      if(new_v !== new_re){
          alert('两次密码不一致');
          return false;
      }

  }


</script>
</body>
</html>