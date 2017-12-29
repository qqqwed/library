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
	<title>图书借阅</title>
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
		#result2{
			border:1px #CCCCCC solid;
			width: 248px;
			height:auto;
			position:relative;
			left:484px;
			display: none;
		}
		.entered{
			background-color: #23abf0;
		}

	</style>

</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span>
	图书借还 <span class="c-gray en">&gt;</span>图书借阅
	<a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" >
		<i class="Hui-iconfont">&#xe68f;</i>
	</a>
</nav>
<div class="page-container">
	<div class="text-c">

			<input type="text" class="input-text" style="width:250px" placeholder="读者条形码、姓名" id="key" name="key">
			<button type="submit" class="btn btn-success" id="query" name=""><i class="Hui-iconfont">&#xe665;</i> 查询读者信息</button>
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

	</div>
	<div class=" pd-5 bg-1 mt-20" style="text-align: center;">
		<div class=" skin-minimal">
			<input type="text" class="input-text" style="width:250px" placeholder="图书条形码、书名" id="book" name="book											">
			<button type="submit" class="btn btn-success" id="bk" name=""><i class="Hui-iconfont">&#xe665;</i> 查询图书信息</button>
			<div id="result2"></div>
		</div>


	</div>
</div>
<table class="table table-border table-bordered table-bg">
	<thead>
	<!--<tr>
        <th scope="col" colspan="7">权限节点</th>
    </tr>-->
	<tr class="text-c">
		<th width="150">图书条编码</th>
		<th width="200">图书名称</th>
		<th width="100">出版社</th>
		<th width="40">定价</th>
		<th width="40">书架</th>
		<th width="50">状态</th>
		<th width="50">操作</th>
	</tr>
	</thead>
	<tbody class="tb">
	</tbody>
</table>
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

	/*管理员-借书*/

	function book_borrow(obj,id,reader) {
		layer.confirm('确认要借书吗？',function(){
			$.ajax({
				type: 'POST',
				url : '/index.php/admin/Borrow/bookBorrow',
				traditional:true,
				data: {id:id,reader_id:reader},
				dataType: 'json',
				success: function(res){
					if(res.code ==10000){
//					$(obj).parents("tr").find(".td-manage").prepend('<a onClick="admin_stop(this,id)" href="javascript:;" title="停用" style="text-decoration:none"><i class="Hui-iconfont">&#xe631;</i></a>');
						$(obj).parents("tr").find(".td-status").html('<span class="label radius">已借出</span>');
						$(obj).remove();
						layer.msg('借书成功!',{icon:6,time:1000});
						$('.borrowNumber').val(Number($('.borrowNumber').val())-1);
					}else{
						layer.msg('借书失败!',{icon:2,time:2000});
					}

				}
			});
		});
	}
</script>
<script>
	/*发送ajax查询读者信息及借阅信息*/
	function queryReader() {
		var data = $('#key').val();
		$.post('/index.php/admin/borrow/search2',{'key':data},function (msg2) {
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
				$('.info').attr('reader_id',msg2.reader_info.id) ;
			}

		});
	}

	/*查询图书信息*/
	function bookInfo(key) {
		if(key != ''){
			$.get('/index.php/admin/borrow/bookInfo/key/'+key,function (msg) {
				if(msg.code != 10000){
					layer.msg(msg.msg,{icon:2,time:2000});
				}else{
//					console.log(msg);
					var query = '';
					msg['data'].forEach(function (v,k) {
						query += "<tr class='text-c'>";
						query += "<td>"+v.sn+"</td>";
						query += "<td>"+v.bookname+"</td>";
						query += "<td>"+v.publish+"</td>";
						query += "<td>"+v.price+"</td>";
						query += "<td>"+v.cid+"</td>";
						if(v.status == 1){
							query += "<td class='td-status'><span class='label label-success radius'>可借</span></td>";
							query += "<td class='td-manage'><a title='借书' href=\"javascript:;\" onclick=\"book_borrow(this,"+v.id+","+$('.info').attr('reader_id')+")\" style=\"text-decoration:none\"><b data-icon=\"&#xe901;\" style=\"font-size: 25px;\"></b></a>&nbsp;&nbsp;</td>";

						}
						else{
							query +="<td class='td-status'><span class='label radius'>已借出</span></td>";
							query += "<td></td>"
						}
						query += "</tr>";
					});
//					console.log(query);
					$('.tb').html(query);
				}
			},'json');
		}
	}
	/*点击搜索,触发*/
	$('#bk').on('click',function () {
		if($('#book').val()){
			bookInfo($('#book').val());
		}else{
			//搜索框为空时,刷新
			//location.replace(location.href);
			$('.tb').html('');
		}
	});

	/*查询读者搜索框改变时触发*/
	$('#key').on('input',function () {
		var s = $(this).val();
		if(s != ''){
			//发送ajax,查询读者信息
			$.get('/index.php/admin/borrow/search/key/'+s,function (msg) {
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

	/* 点击其他地方时,隐藏选项栏*/
	$(document).bind('click',function(){
		$('#result').hide();
	});

	/*点击搜索,触发*/
	$('#query').on('click',function () {
		if($('#key').val()){
			queryReader();
		}else{
			//搜索框为空时,刷新
			location.replace(location.href);
		}
	});


	/*	发送ajax查询图书条形码,图书名*/
	function queryBook(key) {
		$.get('/index.php/admin/borrow/querybook/key/'+key,function (msg) {
			if(msg.code == 10000){
				$('#result2').css('display','block');
				$('#result2')[0].innerHTML = '';
				$.each(msg['data'],function (i,v) {
					$('#result2')[0].innerHTML += '<div class="res">'+ v.bookname + '</div>';
				});


//                    移动到选项条,改变背景颜色
				$('.res').bind('mouseenter mouseleave', function() {
					$(this).toggleClass('entered');
				});

//                    点击选项,自动填充到搜索框,
				$('.res').click(function () {

					$('#book').val($(this).html());
					//清空整个选项框
					$('.res').html('');
					$('#result2').css('display','none');
					//发送ajax,查询数据
//					console.log($('#book').val());
					bookInfo($('#book').val());

				});

			}else{
				$('res').html('');
			}
		},'json')

	}


	/*查询图书条形码和图书名*/
	$('#book').on('input',function () {
		if($('#book').val()){
			queryBook($('#book').val());
		}else{
			$('#result2').css('display','none');
			$('#result2')[0].innerHTML = '';
		}
	});


</script>
</body>
</html>