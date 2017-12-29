<?php 
namespace Admin\Controller;
use Think\Controller;
class CommonController extends Controller{
	public function __construct(){
		//先调用父类控制器,防止被覆盖
		parent::__construct();
		//登录判断
		if (!session('?manager_info')) {
			//没有登录,跳转到登录页面
			$this ->redirect('Admin/Login/login');
		}
		//调用getnav方法获取左侧菜单权限
		$this->getnav();
		//调用checkauth进行权限检测
		$this -> checkauth();
	}

	//获取左侧菜单权限
	public function getnav(){
		//优化:先判断session中有没有菜单权限信息
		if(session('?top')&&session('?second')){
			//不需要查询数据表
			return;
		}
		//从session获取id 进行登录的管理员信息  role_id
		$role_id = session('manager_info.role_id');

		// dump($role_id);
		//根据role_id进行判断:超级管理员和普通管理员
		if ($role_id == 1) {
			//超级管理员  直接查询权限表 分别查询顶级和二级权限
			$top = M('Auth') -> where("pid=0 and is_nav = '1'") -> select();
			//dump($top);
			$second = M('Auth') -> where("pid>0 and is_nav = '1'") -> select();
			//dump($second);
		}else{
			//普通管理员  根据role_id查询角色表
			$role = M('Role') ->where("id = $role_id") ->find();
			//根据角色role_auth_ids字段查询权限表  分别查询顶级和二级权限
			$role_auth_ids = $role['role_auth_ids'];
			
			$top = M('Auth')->where(['pid' => 0,'is_nav' => '1','id'=>['in',$role_auth_ids]] ) ->select();
			$second = M('Auth')->where(['pid' =>['gt',0],'is_nav' => '1',['id'=>['in',$role_auth_ids]]])->select();
		}
		//将查询的权限放到session中,页面上直接读取session即可
		
		session('top',$top);
		session('second',$second);

		// dump(session('top'));
		// dump(session('second'));
	}
	//权限检测
	public function checkauth(){
		//获取角色ID
		$role_id = session('manager_info.role_id');
		// dump($role_id);
		if ($role_id ==1 ) {
			//超级管理员不需要检测
			return;
		}
		//获取当前访问的页面   控制器名和方法名
		$c = CONTROLLER_NAME;
		$a = ACTION_NAME;

		$ac = $c. '-' .$a;
		//首页  不需要检测权限, 所有人都可以访问
		if ($ac == 'Index-welcome'||$ac == 'Index-index') {
			return;
		}
		//根据role_id查询角色信息,判断$ac是否在role_auth_ac字段串
		$role = M('Role')-> where(['id' => $role_id])->find();
		$role_auth_ac = explode(',',$role['role_auth_ac']);
		// dump($role);
		// dump($ac);
		// dump($role_auth_ac);die;
		if (!in_array($ac,$role_auth_ac)) {
			//没有权限
			//echo"没有权限";die;
			$this->error('没有权限',U('Admin/Index/welcome'));
		}
	}
}
