<?php
namespace Admin\Controller;
use Think\Controller;
class AuthController extends Controller{

	public function index(){
		$auth = M("Auth")->select();
		$auth = getTree($auth);
		$this->assign('auth',$auth);

		$count = M("Auth")->count();
		$this->assign('count',$count);
		$this->display();
	}

	//权限新增
	public function add(){
		//一个方法两个逻辑
		if(IS_POST){
			//接收表单提交
			$data = I('post.');
			// dump($data);
			//添加到数据表
			$res = M('Auth') -> add($data);
			if($res){
				$this -> success('添加成功', U('Admin/Auth/index'));
			}else{
				$this -> error('添加失败');
			}
		}else{
			//查询所有的顶级权限
			$top = M('Auth') -> where("pid = 0") -> select();
			$this -> assign('top', $top);
			$this -> display();
		}
		
	}
	public function del(){
		$id = I("get.id");
		$res = M('auth')->delete($id);
		if($res !== false){
			$this->success("删除成功",U('/Admin/Auth/index'));
		}else{
			$this->error('删除失败');
		}
	}	
}