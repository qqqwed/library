<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
<!--[if lt IE 9]>
<script type="text/javascript" src="/Public/Admin/lib/html5shiv.js"></script>
<script type="text/javascript" src="/Public/Admin/lib/respond.min.js"></script>
<![endif]-->
<link rel="stylesheet" type="text/css" href="/Public/Admin/static/h-ui/css/H-ui.min.css" />
<link rel="stylesheet" type="text/css" href="/Public/Admin/static/h-ui.admin/css/H-ui.admin.css" />
<link rel="stylesheet" type="text/css" href="/Public/Admin/lib/Hui-iconfont/1.0.8/iconfont.css" />
<link rel="stylesheet" type="text/css" href="/Public/Admin/static/h-ui.admin/skin/default/skin.css" id="skin" />
<link rel="stylesheet" type="text/css" href="/Public/Admin/static/h-ui.admin/css/style.css" />

<link rel="stylesheet" type="text/css" href="/Public/Admin/lib/icomoon/fonts/icomoon.css" />

<!--[if IE 6]>
<script type="text/javascript" src="/Public/Admin/lib/DD_belatedPNG_0.0.8a-min.js" ></script>
<script>DD_belatedPNG.fix('*');</script>
<![endif]-->
<title>图书续借</title>
	<style>
		.info{text-align: center;padding:0; margin-top: 50px ;}
		.info td{width: 50px;}
		.info th{width:30px;}
		.b{
			width:300px;}
		/*.info table:nth-child(2){display: none;}*/
		#result{
			border:1px #CCCCCC solid;
			width: 248px;
			height:auto;
			position:relative;
			left:490px;
			display: none;
		}
		.entered{
			background-color: #23abf0;
		}

	</style>

</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 图书借还 <span class="c-gray en">&gt;</span> 图书续借 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
	<div class="text-c">
		<input type="text" class="input-text" style="width:250px" placeholder="读者条形码、姓名" id="key" name="key">
		<button class="btn btn-success" id="query" name=""><i class="Hui-iconfont">&#xe665;</i> 查询读者信息</button>
		<div id="result"></div>
	</div>
	<div class="info">
		<table class="table">
			<tr>
				<th class="text-r">姓名:</th>
				<td><input type="text" class="input-text radius size-M reader" name="reader"></td>
				<th class="text-r">性别:</th>
				<td><input type="text" class="input-text radius size-M gender" name="gender"></td>
				<th class="text-r">读者类型:</th>
				<td><input type="text" class="input-text radius size-M typename" name="typename"></td>
			</tr>
			<tr>
				<th class="text-r">证件类型:</th>
				<td><input type="text" class="input-text radius size-M paperType" name="paperType"></td>
				<th class="text-r">证件号码:</th>
				<td><input type="text" class="input-text radius size-M paperNumber" name="paperNumber"></td>
				<th class="text-r">可借数量:</th>
				<td><input type="text" class="input-text radius size-M borrowNumber" name="borrowNumber"></td>
			</tr>
		</table>
		<table  class="table table-bordered table-border table-bg mt-20">
			<thead>
				<tr class="text-c">
					<th>图书编号</th>
					<th>图书名称</th>
					<th>借出时间</th>
					<th>应还时间</th>
					<th>出版社</th>
					<th>书架</th>
					<th>定价(元)</th>
					<th>操作员</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody class="tb"></tbody>
		</table>
	</div>
	</div>

</div>
<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="/Public/Admin/lib/jquery/1.9.1/jquery.min.js"></script> 
<script type="text/javascript" src="/Public/Admin/lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="/Public/Admin/static/h-ui/js/H-ui.min.js"></script> 
<script type="text/javascript" src="/Public/Admin/static/h-ui.admin/js/H-ui.admin.js"></script> <!--/_footer 作为公共模版分离出去-->

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="/Public/Admin/lib/datatables/1.10.0/jquery.dataTables.min.js"></script>

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
/*管理员-还书*/
function book_back(obj,id){
	layer.confirm('确认要还书吗？',function(){
		$.ajax({
			type: 'POST',
			url : '/index.php/Admin/Borrow/backbook',
			data: 'id='+id,
			dataType: 'json',
			success: function(data){
				if(data.code ==10000){
					$(obj).parents("tr").remove();

					layer.msg('还书成功!',{icon:1,time:1000});
					$('.borrowNumber').val(Number($('.borrowNumber').val())+1);
				}else{
					layer.msg('还书失败!',{icon:2,time:2000});
				}

			}
		});
	});
}

/*管理员-续借*/
function book_renew(obj,id) {
	layer.confirm('确认要续借吗？',function(){
		$.ajax({
			type: 'POST',
			url : '/index.php/Admin/Borrow/book_renew',
			data: 'borrow_sn='+id,
			dataType: 'json',
			success: function(data){
				if(data.code ==10000){
					layer.msg(data.msg,{icon:1,time:1000});
					$(obj).parents('tr').find(".bt").text(data['backtime']);
				}else{
					layer.msg(data.msg,{icon:2,time:2000});
				}

			}
		});
	});
}
</script>
<script>
//	发送ajax查询读者信息及借阅信息
	function queryReader() {
		var data = $('#key').val();
		$.post('/index.php/Admin/Borrow/search2',{'key':data},function (msg2) {
			if(msg2.code != 10000){
				layer.msg(msg2.msg,{icon:2,time:2000});
			}else{
				$('.reader').val(msg2.reader_info.name);
				if(msg2.reader_info.sex==1){
					$('.gender').val('男');
				}else if(msg2.reader_info.sex==2){
					$('.gender').val('女');
				}else{
					$('.gender').val('未知');
				}
				$('.typename').val(msg2.reader_info.level_id);
				$('.paperType').val(msg2.reader_info.papertype);
				$('.paperNumber').val(msg2.reader_info.paperno);
				$('.borrowNumber').val(msg2.reader_info.borrownumber);
				console.log(msg2);
				var query = '';
				msg2['data'].forEach(function (v,k) {
					query += "<tr class='text-c'>";
					query += "<td>"+v.sn+"</td>";
					query += "<td>"+v.bookname+"</td>";
					query += "<td>"+v.borrowtime+"</td>";
					query += "<td class='bt'>"+v.backtime+"</td>";
					query += "<td>"+v.publish+"</td>";
					query += "<td>"+v.cid+"</td>";
					query += "<td>"+v.price+"</td>";
					query += "<td>"+v.operator+"</td>";
					query += "<td><a title='还书' href=\"javascript:;\" onclick=\"book_back(this,'"+v.id+"')\" style=\"text-decoration:none\"><b data-icon=\"&#xe900;\" style=\"font-size: 25px;\"></b></a>&nbsp;&nbsp;";
					query += "<a title='续借' href=\"javascript:;\" onclick=\"book_renew(this,'"+v.borrow_sn+"')\" style=\"text-decoration:none\"><b data-icon=\"&#xe902;\" style=\"font-size: 25px;\"></b></a> </td>";
					query += "</tr>";
//					console.log(v.borrow_sn);
				});
//                           console.log(query);
				$('.tb').html(query);
			}

		});
	}
//	搜索框改变时触发
	$('#key').on('input',function () {
		var s = $(this).val();
		if(s != ''){
			//发送ajax,查询读者信息
			$.get('/index.php/Admin/Borrow/search/key/'+s,function (msg) {
				if(msg != []){
					$('#result').css('display','block');
					$('#result')[0].innerHTML = '';
					$.each(msg['data'],function (i,v) {
						$('#result')[0].innerHTML += '<div class="res">'+ v.name + '</div>';
					});


//                    移动到选项条,改变背景颜色
					$('.res').bind('mouseenter mouseleave', function() {
						$(this).toggleClass('entered');
					});

//                    点击选项,自动填充到搜索框,
					$('.res').click(function () {

						$('#key').val($(this).html());
						//清空整个选项框
						$('.res').html('');
						$('#result').css('display','none');
						//发送ajax,查询数据
						queryReader();

					});

				}else{
					$('res').html('');
				}
			},'json')
		}else{
			$('#result').css('display','none');
			$('#result')[0].innerHTML = '';
		}
	});

//	    点击其他地方时,隐藏选项栏
	$(document).bind('click',function(){
		$('#result').hide();
	});

//点击搜索,触发
	$('#query').on('click',function () {
		if($('#key').val()){
			queryReader();
		}else{
			//搜索框为空时,刷新
			location.replace(location.href);
		}
	})
</script>
</body>
</html>