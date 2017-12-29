<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport"
          content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <!--[if lt IE 9]>
    <script type="text/javascript" src="/Public/Admin/lib/html5shiv.js"></script>
    <script type="text/javascript" src="/Public/Admin/lib/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="/Public/Admin/static/h-ui/css/H-ui.min.css"/>
    <link rel="stylesheet" type="text/css" href="/Public/Admin/static/h-ui.admin/css/H-ui.admin.css"/>
    <link rel="stylesheet" type="text/css" href="/Public/Admin/lib/Hui-iconfont/1.0.8/iconfont.css"/>
    <link rel="stylesheet" type="text/css" href="/Public/Admin/static/h-ui.admin/skin/default/skin.css" id="skin"/>
    <link rel="stylesheet" type="text/css" href="/Public/Admin/static/h-ui.admin/css/style.css"/>
    <!--[if IE 6]>
    <script type="text/javascript" src="/Public/Admin/lib/DD_belatedPNG_0.0.8a-min.js"></script>
    <script>DD_belatedPNG.fix('*');</script>
    <![endif]-->
    <title>用户管理</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 用户中心 <span
        class="c-gray en">&gt;</span> 用户管理 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px"
                                              href="javascript:location.replace(location.href);" title="刷新"><i
        class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="pd-20">
    <div class="text-c"> 日期范围：
        <input type="text" onfocus="" id="datemin" class="input-text Wdate" style="width:120px;">
        -
        <input type="text" onfocus="WdatePicker({minDate:'#F<?php echo ($dp["$D('datemin')"]); ?>',maxDate:'%y-%M-%d'})" id="datemax"
               class="input-text Wdate" style="width:120px;">
        <input type="text" class="input-text" style="width:250px" placeholder="输入会员名称、电话、邮箱" id="" name="">
        <button type="submit" class="btn btn-success" id="" name=""><i class="icon-search"></i> 搜用户</button>

    </div>
    <div class="cl pd-5 bg-1 bk-gray mt-20">
    <span class="l"><a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="icon-trash"></i> 批量删除</a>
    <a href="javascript:;" onclick="location.href='/index.php/Admin/Reader/add'" class="btn btn-primary radius"><i
            class="icon-plus"></i> 添加用户</a></span>
        <span class="r">共有数据：<strong><?php echo ($count); ?></strong> 条</span>
    </div>
    <table class="table table-border table-bordered table-hover table-bg table-sort">
        <thead>
        <tr class="text-c">
            <th width="25"><input type="checkbox" name="" value=""></th>
            <th width="80">ID</th>
            <th width="100">用户名</th>
            <th width="40">性别</th>
            <th width="90">手机</th>
            <th width="150">邮箱</th>
            <th width="130">加入时间</th>
            <th width="70">状态</th>
            <th width="100">操作</th>
        </tr>
        </thead>
        <tbody>
        <?php if(is_array($reader)): $k = 0; $__LIST__ = $reader;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vol): $mod = ($k % 2 );++$k;?><tr class="text-c">
                <td><input type="checkbox" value="1" name=""></td>
                <td><?php echo ($vol["id"]); ?></td>

                <td><u style="cursor:pointer" class="text-primary"
                       onclick="location.href='/index.php/Admin/Reader/detail/id/<?php echo ($vol["id"]); ?>'"><?php echo ($vol["name"]); ?></u></td>
                <td>
                    <?php if($vol["sex"] == 1): ?>男<?php else: ?>女<?php endif; ?>

                </td>
                <td><?php echo ($vol["tel"]); ?></td>
                <td><?php echo ($vol["email"]); ?></td>

                <td><?php echo ($vol["create_time"]); ?></td>
                <td class="user-status" id="user_status<?php echo ($k); ?>" >
                    <?php if( $vol["status"] == 1 ): ?><span class="label label-success">已启用</span>
                        <?php else: ?>
                        <span class="label label-failed">未启用</span><?php endif; ?>
                </td>
                <td class="f-14 user-manage">
                    <?php if($vol["status"] == 1 ): ?><a style="text-decoration:none" onClick="user_stop(this)" userid="<?php echo ($vol["id"]); ?>" userkey="<?php echo ($k); ?>" href="javascript:;" >
                        <i class="icon-hand-down"></i>停用</a>
                        <?php else: ?>
                        <a style="text-decoration:none" onClick="user_start(this)" userid="<?php echo ($vol["id"]); ?>" userkey="<?php echo ($k); ?>" href="javascript:;">
                            <i class="icon-hand-down"></i>启用</a><?php endif; ?>
                    <a title="编辑" href="javascript:;" onclick="location.href='/index.php/Admin/Reader/detail/id/<?php echo ($vol["id"]); ?>'"
                       class="ml-5" style="text-decoration:none"><i class="icon-edit"></i>编辑</a>
                    <a style="text-decoration:none" class="ml-5"
                       onClick="location.href='/index.php/Admin/Reader/edit/id/<?php echo ($vol["id"]); ?>'"
                       href="javascript:;" title="修改密码"><i class="icon-key"></i>修改密码</a>
                    <a title="删除" href="javascript:;" onclick="location.href='/index.php/Admin/Reader/del/id/<?php echo ($vol["id"]); ?>'" class="ml-5"
                       style="text-decoration:none"><i class="icon-trash"></i>删除</a>
                </td>
            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        </tbody>
    </table>
    <div id="pageNav" class="pageNav"></div>
</div>
<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="/Public/Admin/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="/Public/Admin/lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="/Public/Admin/static/h-ui/js/H-ui.min.js"></script>
<script type="text/javascript" src="/Public/Admin/static/h-ui.admin/js/H-ui.admin.js"></script>
<!--/_footer 作为公共模版分离出去-->

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="/Public/Admin/lib/My97DatePicker/4.8/WdatePicker.js"></script>
<script type="text/javascript" src="/Public/Admin/lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/Public/Admin/lib/laypage/1.2/laypage.js"></script>
<script type="text/javascript">
//    window.onload = (
//        function () {
//        // optional set
//        pageNav.pre = "&lt;上一页";
//        pageNav.next = "下一页&gt;";
//        // p,当前页码,pn,总页面
//        pageNav.fn = function (p, pn) {
//            $("#pageinfo").text("当前页:" + p + " 总页: " + pn);
//        };
//        //重写分页状态,跳到第三页,总页33页
//        pageNav.fn(1, 13);
//    });
//    $('.table-sort').dataTable({
//        "lengthMenu": false,//显示数量选择
//        "bFilter": false,//过滤功能
//        "bPaginate": false,//翻页信息
//        "bInfo": false,//数量信息
//        "aaSorting": [[1, "desc"]],//默认第几个排序
//        "bStateSave": true,//状态保存
//        "aoColumnDefs": [
//            //{"bVisible": false, "aTargets": [ 3 ]} //控制列的隐藏显示
//            {"orderable": false, "aTargets": [0, 8, 9]}// 制定列不参与排序
//        ]
//    });
    function user_start(_this){
        var id = $(_this).attr('userid');
        var k = $(_this).attr('userkey');
        $.ajax({
            url:"/index.php/Admin/Reader/status",
            success:function(data){
                if(data['code'] == 10000){
                    var a = " <a style='text-decoration:none' onClick='user_stop(this)' userid='"+data['id']+"'userkey="+data['key']+" href='javascript:;' >\n" +
                        "                        <i class='icon-hand-down'></i>停用</a>";
                    $(_this).replaceWith(a);
                    var b = "<span class='label label-success'>已启用</span>";
                    $($(".user-status")[k-1]).html(b);



                }
            },
            data:'id='+id+'&status='+1+'&userkey='+k,
            datatype:'json',
        });
    }
    function user_stop(_this)
    {
        var id = $(_this).attr('userid');
        var k = $(_this).attr('userkey');
        $.ajax({
            url:"/index.php/Admin/Reader/status",
            success:function(data){
                if(data['code'] == 10000){
                    var c = " <a style='text-decoration:none' onClick='user_start(this)' userid='"+data['id']+"' userkey="+data['key']+" href='javascript:;' >\n" +
                        "                        <i class='icon-hand-down'></i>启用</a>";
                    $(_this).replaceWith(c);
                    var d = "<span class='label label-failed'>未启用</span>";
                    $($(".user-status")[k-1]).html(d);
                }
            },
            data:'id='+id+'&status='+1+'&userkey='+k,
            datatype:'json',
        });
    }
</script>
</body>
</html>