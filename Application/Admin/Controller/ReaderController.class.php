<?php
namespace Admin\Controller;
use Admin\Controller\CommonController;
class ReaderController extends CommonController{
	//读者列表
	public function index(){

	    //查询所有数据
	    $reader = D('Reader')->select();
	    $this->assign('reader',$reader);


	    //查询总数
        $count = D('Reader')->where(['is_show' => 1])->count('is_show');
        $this->assign('count',$count);


		$this->display();
	}

	//读者添加
	public function add(){
		if(IS_POST){
			$data = I('post.');
            $data['password'] = md5($data['password']);
			$model = D("Reader");
			$model->create($data);
			$res = $model->add();
			if($res){
                $this->success('添加成功',U('/Admin/Reader/index'));
			}else{
			    $this->error('添加失败');
            }
		}else{
		  $this->display();
        }
	}

	//读者详情
    public function detail(){
	    $id = I('get.id');
	    $row = D('Reader')->where(['id'=>$id])->find();
	    $this->assign('row',$row);
	    $this->display();
    }

    //密码修改
    public function edit(){
        if(IS_POST){
            $data = I('post.');

            if(md5($data['password']) !== md5($data['repassword'])){
                $this->error("两次密码不一致");
            }
            $data['password'] = md5($data['password']);
            $res = D('Reader')->save($data);
            if($res !== false){
                $this->success('修改成功');
            }else{
                $this->error('修改失败');
            }
        }else{
            $this->display();
        }
    }

    //读者删除
    public function del (){
        $id = I("get.id");
        $res = D("Reader")->delete($id);
        if($res !== false){
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
    }

    //读者状态修改
    public function status(){
        $data = I("get.");
        $res = D('Reader')->where(['id' =>$data['id']])->save($data);

        if($res == false){
            $return = array(
                'code' => 10000,
                'id' => $data['id'],
                'key' => $data['userkey'],
                'msg' =>'修改成功',
            );
            $this->ajaxReturn($return);
        }else{
            $return = array(
                'code' => 10001,
                'msg' => '修改失败',
            );
            $this->ajaxReturn($return);
        }

    }
}