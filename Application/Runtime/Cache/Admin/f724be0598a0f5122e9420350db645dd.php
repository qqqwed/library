<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
<!--[if lt IE 9]>
<script type="text/javascript" src="lib/html5shiv.js"></script>
<script type="text/javascript" src="lib/respond.min.js"></script>
<![endif]-->
<link rel="stylesheet" type="text/css" href="static/h-ui/css/H-ui.min.css" />
<link rel="stylesheet" type="text/css" href="static/h-ui.admin/css/H-ui.admin.css" />
<link rel="stylesheet" type="text/css" href="lib/Hui-iconfont/1.0.8/iconfont.css" />
<link rel="stylesheet" type="text/css" href="static/h-ui.admin/skin/default/skin.css" id="skin" />
<link rel="stylesheet" type="text/css" href="static/h-ui.admin/css/style.css" />
<!--[if IE 6]>
<script type="text/javascript" src="lib/DD_belatedPNG_0.0.8a-min.js" ></script>
<script>DD_belatedPNG.fix('*');</script>
<![endif]-->
<title>权限新增</title>
</head>
<body>

<div class="content">
    <div class="header">
        <h1 class="page-title">权限新增</h1>
    </div>

    <div class="well">
        <!-- add form -->
        <form id="tab" action="/index.php/Admin/Auth/add" method="post">
            <label>权限名称：</label>
            <input type="text" name="auth_name" value="" class="input-xlarge">
            <label>上级权限</label>
            <select name="pid" class="input-xlarge">
                <option value="0">作为顶级权限</option>
                <?php if(is_array($top)): $i = 0; $__LIST__ = $top;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><option value="<?php echo ($v["id"]); ?>"><?php echo ($v["auth_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
            <div>
                <label>控制器：</label>
                <input type="text" name="auth_c" value="" class="input-xlarge">
            </div>
            <div>
                <label>方法：</label>
                <input type="text" name="auth_a" value="" class="input-xlarge">
            </div>
            <label>是否菜单项</label>
            <select name="is_nav" class="input-xlarge">
                <option value="1">是</option>
                <option value="0">否</option>
            </select>
            
            <label></label>
            <button class="btn btn-primary" type="submit">保存</button>
        </form>
    </div>
    <!-- footer -->
    <footer>
        <hr>
        <p>© 2017 <a href="javascript:void(0);" target="_blank">ADMIN</a></p>
    </footer>
</div>
</body>
<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<!-- <script src="/Public/Admin/js/jquery-1.8.1.min.js"></script>
<script src="/Public/Admin/js/bootstrap.min.js"></script>
<script>
$(function(){
    $("input[name=auth_c]").parent().hide();
    $("input[name=auth_a]").parent().hide();
    $("select[name=pid]").on('change', function(){
        if($(this).val() != 0){
            $("input[name=auth_c]").parent().show();
            $("input[name=auth_a]").parent().show();
        }else{
            $("input[name=auth_c]").parent().hide();
            $("input[name=auth_a]").parent().hide();
        }
    });
})
</script> -->
</html>
<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="lib/jquery/1.9.1/jquery.min.js"></script> 
<script type="text/javascript" src="lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="static/h-ui/js/H-ui.min.js"></script> 
<script type="text/javascript" src="static/h-ui.admin/js/H-ui.admin.js"></script> <!--/_footer 作为公共模版分离出去-->

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="lib/datatables/1.10.0/jquery.dataTables.min.js"></script> 
<script type="text/javascript">
/*
	参数解释：
	title	标题
	url		请求的url
	id		需要操作的数据id
	w		弹出层宽度（缺省调默认值）
	h		弹出层高度（缺省调默认值）
*/
/*管理员-权限-添加*/
function admin_permission_add(title,url,w,h){
	layer_show(title,url,w,h);
}
/*管理员-权限-编辑*/
function admin_permission_edit(title,url,id,w,h){
	layer_show(title,url,w,h);
}

/*管理员-权限-删除*/
function admin_permission_del(obj,id){
	layer.confirm('确认要删除吗？',function(index){
		$.ajax({
			type: 'POST',
			url: '',
			dataType: 'json',
			success: function(data){
				$(obj).parents("tr").remove();
				layer.msg('已删除!',{icon:1,time:1000});
			},
			error:function(data) {
				console.log(data.msg);
			},
		});		
	});
}
</script>
</body>
</html>