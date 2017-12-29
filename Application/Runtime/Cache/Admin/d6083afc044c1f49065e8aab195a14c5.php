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

<link rel="stylesheet" type="text/css" href="/Public/Admin/page/page.css" />
<!--[if IE 6]>
<script type="text/javascript" src="/Public/Admin/lib/DD_belatedPNG_0.0.8a-min.js" ></script>
<script>DD_belatedPNG.fix('*');</script>
<![endif]-->
<title>用户管理</title>
<style>
	#result{
		border:1px #CCCCCC solid;
		width: 248px;
		height:auto;
		position:relative;
		left:684px;
		display: none;
	}
	.entered{
		background-color: #23abf0;
	}
</style>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 图书借还 <span class="c-gray en">&gt;</span> 图书借阅查询 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
	<form action="" method="post">
		<div class="text-c"> 日期范围：
			<input type="text" onfocus="Wdate1()" id="datemin" class="input-text Wdate" name="datemin" style="width:120px;">
			-
			<input type="text" onfocus="Wdate2()" id="datemax" class="input-text Wdate" name="datemax" style="width:120px;">
			<input type="text" class="input-text" style="width:250px" placeholder="输入图书名称、条形码" id="key" name="key">
			<button type="button" class="btn btn-success radius" id="query" name=""><i class="Hui-iconfont">&#xe665;</i> 查询</button>
			<div id="result"></div>
		</div>
	</form>
	<div class="mt-40">
	<table class="table table-border table-bordered table-hover table-bg table-sort">
		<thead>
		<tr class="text-c">
			<th>图书条形码</th>
			<th>图书名称</th>
			<th>读者条形码</th>
			<th>读者名称</th>
			<th>借阅时间</th>
			<th>归还时间</th>
			<th>是否归还</th>
			<!--<th>操作</th>-->
		</tr>
		</thead>
		<tbody class="re">
		</tbody>
	</table>
		<div class="page" id="page"></div>
	</div>
</div>
<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="/Public/Admin/lib/jquery/1.9.1/jquery.min.js"></script> 
<script type="text/javascript" src="/Public/Admin/lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="/Public/Admin/static/h-ui/js/H-ui.min.js"></script> 
<script type="text/javascript" src="/Public/Admin/static/h-ui.admin/js/H-ui.admin.js"></script> <!--/_footer 作为公共模版分离出去-->

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="/Public/Admin/lib/My97DatePicker/4.8/WdatePicker.js"></script> 
<script type="text/javascript" src="/Public/Admin/lib/datatables/1.10.0/jquery.dataTables.min.js"></script> 
<script type="text/javascript" src="/Public/Admin/lib/laypage/1.2/laypage.js"></script>

<script type="text/javascript" src="/Public/Admin/page/page.js"></script>
<script type="text/javascript">
/*$(function(){
	$('.table-sort').dataTable({
		//开启服务器端模式
		"aaSorting": [[ 4, "desc" ]],//默认第几个排序
		"bStateSave": true,//状态保存
		"bRetrieve": true,
		"aoColumnDefs": [
		  //{"bVisible": false, "aTargets": [ 3 ]} //控制列的隐藏显示
		  {"orderable":false,"aTargets":[0,1,2,3,5,6]}// 制定列不参与排序
		]
	});

});*/
function Wdate1() {
	WdatePicker({ maxDate:"%y-%M-%d" });
}
function Wdate2() {
	var st = $('#datemin').val();
	WdatePicker({ minDate:st,maxDate:'%y-%M-%d' });
}


/*用户-添加*/
function member_add(title,url,w,h){
	layer_show(title,url,w,h);
}
/*用户-查看*/
function member_show(title,url,id,w,h){
	layer_show(title,url,w,h);
}
/*用户-停用*/
function member_stop(obj,id){
	layer.confirm('确认要停用吗？',function(index){
		$.ajax({
			type: 'POST',
			url: '',
			dataType: 'json',
			success: function(data){
				$(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" onClick="member_start(this,id)" href="javascript:;" title="启用"><i class="Hui-iconfont">&#xe6e1;</i></a>');
				$(obj).parents("tr").find(".td-status").html('<span class="label label-defaunt radius">已停用</span>');
				$(obj).remove();
				layer.msg('已停用!',{icon: 5,time:1000});
			},
			error:function(data) {
				console.log(data.msg);
			},
		});		
	});
}

/*用户-启用*/
function member_start(obj,id){
	layer.confirm('确认要启用吗？',function(index){
		$.ajax({
			type: 'POST',
			url: '',
			dataType: 'json',
			success: function(data){
				$(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" onClick="member_stop(this,id)" href="javascript:;" title="停用"><i class="Hui-iconfont">&#xe631;</i></a>');
				$(obj).parents("tr").find(".td-status").html('<span class="label label-success radius">已启用</span>');
				$(obj).remove();
				layer.msg('已启用!',{icon: 6,time:1000});
			},
			error:function(data) {
				console.log(data.msg);
			},
		});
	});
}
/*用户-编辑*/
function member_edit(title,url,id,w,h){
	layer_show(title,url,w,h);
}
/*密码-修改*/
function change_password(title,url,id,w,h){
	layer_show(title,url,w,h);	
}
/*用户-删除*/
function member_del(obj,id){
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
			}
		});		
	});
}

//	搜索框改变时触发
$('#key').on('input',function () {
	var s = $(this).val();
	if(s != ''){
		//发送ajax,查询书本名
		$.get('/index.php/admin/borrow/querybook/key/'+s,function (msg) {
			if(msg.code ==10000 ){
				$('#result').css('display','block');
				$('#result')[0].innerHTML = '';
				$.each(msg['data'],function (i,v) {
					$('#result')[0].innerHTML += '<div class="res">'+ v.bookname + '</div>';
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
//					//发送ajax,查询数据
//					queryReader();

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
	var st = new Date($('#datemin').val()).getTime();
	var ed = new Date($('#datemax').val()).getTime();
//	if(st && ed){
//		if(ed < st){
//			layer.msg('时间不合法!',{icon: 2,time:1000})
//		}
//	}
	if(st && ed && $('#key').val()){
		if(ed < st){
			layer.msg('时间不合法!',{icon: 2,time:1000});
		}else{
			$.post('/index.php/admin/borrow/borrowQuery',{'datemin':$('#datemin').val(),'datemax':$('#datemax').val(),'key':$('#key').val()},function(msg){
				if(msg.code ==10000 ){
//				$('.re')[0].innerHTML = '';
//				$('.re')[0].innerHTML = '';
					console.log(msg);
					datas = msg.data;
					options = {
						"id": "page",//显示页码的元素
						"data": datas,//显示数据
						"maxshowpageitem": 5,//最多显示的页码个数
						"pagelistcount": 10,//每页显示数据个数
						"callBack": function (result) {
							var query = '';
							for(var i=0;i<result.length;i++){
								query += "<tr class='text-c'>";
								query += "<td>" + result[i].sn + "</td>";
								query += "<td>" + result[i].bookname + "</td>";
								query += "<td>" + result[i].code_id + "</td>";
								query += "<td>" + result[i].name + "</td>";
								query += "<td>" + result[i].borrowtime + "</td>";
								query += "<td>" + result[i].backtime + "</td>";
								if (result[i].status == '0') {
									query += "<td><span class='label label-warning radius'>未还</span></td>";
								} else {
									query += "<td><span class='label label-success radius'>已还</span></td>";
								}
								query += "</tr>";
							}

							$('.re').html(query);
						}
//				console.log(query);
					};
					page.init(datas.length, 1, options);
				}
			},'json');
		}

	}else if(st && ed &&st<ed){
		$.post('/index.php/admin/borrow/borrowQuery',{'datemin':$('#datemin').val(),'datemax':$('#datemax').val()},function(msg){
			if(msg.code ==10000 ){
//				$('.re')[0].innerHTML = '';
//				$('.re')[0].innerHTML = '';
				console.log(msg);
				datas = msg.data;
				options = {
					"id": "page",//显示页码的元素
					"data": datas,//显示数据
					"maxshowpageitem": 5,//最多显示的页码个数
					"pagelistcount": 10,//每页显示数据个数
					"callBack": function (result) {
						var query = '';
						for(var i=0;i<result.length;i++){
							query += "<tr class='text-c'>";
							query += "<td>" + result[i].sn + "</td>";
							query += "<td>" + result[i].bookname + "</td>";
							query += "<td>" + result[i].code_id + "</td>";
							query += "<td>" + result[i].name + "</td>";
							query += "<td>" + result[i].borrowtime + "</td>";
							query += "<td>" + result[i].backtime + "</td>";
							if (result[i].status == '0') {
								query += "<td><span class='label label-warning radius'>未还</span></td>";
							} else {
								query += "<td><span class='label label-success radius'>已还</span></td>";
							}
							query += "</tr>";
						}

						$('.re').html(query);
					}
//				console.log(query);
				};
				page.init(datas.length, 1, options);

				console.log(query);
			}
		},'json');
	}else if($('#key').val()){
		$.post('/index.php/admin/borrow/borrowQuery',{'key':$('#key').val()},function(msg) {
			if (msg.code == 10000) {
//				console.log(msg);
				datas = msg.data;
				options = {
					"id": "page",//显示页码的元素
					"data": datas,//显示数据
					"maxshowpageitem": 5,//最多显示的页码个数
					"pagelistcount": 10,//每页显示数据个数
					"callBack": function (result) {
						var query = '';
						for(var i=0;i<result.length;i++){
							query += "<tr class='text-c'>";
							query += "<td>" + result[i].sn + "</td>";
							query += "<td>" + result[i].bookname + "</td>";
							query += "<td>" + result[i].code_id + "</td>";
							query += "<td>" + result[i].name + "</td>";
							query += "<td>" + result[i].borrowtime + "</td>";
							query += "<td>" + result[i].backtime + "</td>";
							if (result[i].status == '0') {
								query += "<td><span class='label label-warning radius'>未还</span></td>";
							} else {
								query += "<td><span class='label label-success radius'>已还</span></td>";
							}
							query += "</tr>";
						}
						$('.re').html(query);
					}
//				console.log(query);
				};
				page.init(datas.length, 1, options);
			}
		},'json')
	}


})

</script> 
</body>
</html>