<?php
namespace Admin\Controller;
use Think\Controller;
class BookController extends Controller{
	//图书列表
	public function index(){
		//查询所有
		// $res = D('book')->select();
		// $this->assign('res',$res);
		if(IS_POST){
			$data = I("post.name");
			if($data){
				$where = array(
						"name"=>array('like',"%".$data."%"),
					);
				$this->assign("name",$data);
			}
			// $starttime=I('post.type1');
			// $endtime=I('post.type2');
			// if($starttime){
			// }
		}else{
			$where="1=1";
		}

		//查询分类
		$res = D('book')->alias('b')->field('b.*,c.cate_name')->where($where)->join('left join tb_category as c on b.cid = c.cid ')->select();
		
		$this->assign('res',$res);


		//查询总数
		$count = D('Book')->where($where)->count('id');
		$this->assign('count',$count);
		$this->display();
	}

	//图书添加
	public function add(){
		if(IS_POST){
			$data = I("post.");
			$book = D('Book');

			if(!$book->create($data)){
				$this->error($book->getError());
			}
			$res = D('Book')->add($data);
			if($res){
				$this->success('添加成功',U('/Admin/Book/index'));
			}else{
				$this->error('添加失败');
			}
		}else{
			$cate = M('category')->select();
			$this->assign('cate',$cate);
			$this->display();
		}
	}

	//修改详情
	public function bianji(){
		if(IS_POST){
			$data = I("post.");
			$book = D('Book');

			if(!$book->create($data)){
				$this->error($book->getError());
			}
			$res = D('Book')->save();
			if($res){
				$this->success('修改成功',U('/Admin/Book/index'));
			}else{
				$this->error('修改失败');
			}
		}else{
			$id = I('get.id');
			$res = D('Book')->where(['id' => $id])->find();
			$this->assign('book',$res);
			$this->display();
		}
	}

	//详情页
	public function detail(){
		$id = I("get.id");
		$res = M('book')->find($id);
		if($res){
			$this->assign('res',$res);
			$this->display();
		}else{
			$this->error('没有此书');
		}
	}

	public function del(){
		$id = I("get.id");
		$res = M('book')->delete($id);
		if($res !== false){
			$this->success("删除成功",U('/Admin/Book/index'));
		}else{
			$this->error('删除失败');
		}
		
	}
}