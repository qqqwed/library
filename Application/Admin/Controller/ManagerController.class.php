<?php
namespace Admin\Controller;
use Admin\Controller\CommonController;
class ManagerController extends CommonController{
    /**
     * 管理员管理
     */
    //默认显示管理员列表
    public function index(){
        $data = D('Manager') ->alias('t1') ->field('t1.*,t2.role_name')-> join("left join tb_role as t2 on t1.role_id = t2.id") -> select();
        $this -> assign('data',$data);
        $this -> display();
    }

    //添加管理员
    public function add(){
        if(IS_POST){
            $model = D('Manager');
            //接受表单提交的数据
            $data = I('post.');
            $data['password']= encrypt_password($data['password']);
            $data['create_time'];
            //echo json_encode($data ),die;
            //添加接受到的数据到数据表
            if(!$model -> create($data)){
                //获取错误信息
                $error = $model -> getError();
                $this -> error($error);
            }
            //添加成功返回主键id
            $res = D('Manager') ->add();
            if($res){
                $return = array(
                    'code' => 10000,
                    'msg' => 'success',
                    'data' => $data
                );
                echo  json_encode($return );
            }else{
                $return = array(
                    'code' => 10001,
                    'msg' => '管理员添加失败'
                );
                echo  json_encode($return );
            }

        }else{
            //get请求使展现表单  并将角色信息在页面显示
            $manager = D('Role') -> select();
            $this -> assign('manager',$manager);
            $this ->display();
        }
    }
   
   //模糊查询
    public function search()
    {
        $search = I('post.');
        if(!empty($search['searchName'])&& !empty($search['time1']) && !empty($search['time1'])){
            $time1 = strtotime($search['time1']);
            $time2 = strtotime($search['time2']);
            $data = D('Manager') ->alias('t1') ->field('t1.*,t2.role_name')
                -> join("left join vshop_role as t2 on t1.role_id = t2.role_id")
                ->where("t1.username like '%{$search}%' and  t1.create_time BETWEEN {$time1} and {$time2}")->select();
            $this ->ajaxReturn($data);
        }elseif(empty($search['searchName']) && !empty($search['time1']) && !empty($search['time2'])){
            $time1 = strtotime($search['time1']);
            $time2 = strtotime($search['time2']);
            $data = D('Manager') ->alias('t1') ->field('t1.*,t2.role_name')
                -> join("left join vshop_role as t2 on t1.role_id = t2.role_id")
                ->where("t1.create_time BETWEEN {$time1} and {$time2}")->select();
            $this ->ajaxReturn($data);;
        }elseif(empty($search['time1']) || empty($search['time2']) && !empty($search['searchName'])){
            $data = D('Manager') ->alias('t1') ->field('t1.*,t2.role_name')
                -> join("left join vshop_role as t2 on t1.role_id = t2.role_id")
                ->where("t1.username like '%{$search['searchName']}%' ")->select();
            $this ->ajaxReturn($data);
        }else{
            $data = array();
            $this ->ajaxReturn($data);
        }

    }

    public function passwordEdit(){
        if(IS_POST){
            $data = I('post.');
            $model = D('Manager');
            $result = D('Manager') -> find($data['id']);
            if(encrypt_password($data['old'])!=$result['password']){
                $return = array(
                    'code' =>10001,
                    'msg' => '旧密码错误'
                );
                $this -> ajaxReturn($return);
            };
            $result['password'] = encrypt_password($data['password']);
            $res = $model  ->save($result);
            if($res!==false){
                $return = array(
                    'code' =>10000,
                    'msg' => 'success'
                );
                $this -> ajaxReturn($return);
            }else{
                $return = array(
                    'code' =>10001,
                    'msg' => '密码修改失败'
                );
                $this -> ajaxReturn($return);
            }
        }else{
            $id = I('get.id');
            $data = D('Manager') -> where("id = $id") -> find();
            $this -> assign('data',$data);
            $this -> display();
        }

    }
    //修改是否启用的状态
    public function changeStatus(){
        $data= I('get.');
        D('Manager') -> save($data);
    }


    public function del(){
        $id = I('post.id');
        $res = D('Manager') -> delete($id);
        if($res!==false){
            $return = array(
                'code' =>10000,
                'msg' => 'success'
            );
            $this -> ajaxReturn($return);
        }else{
            $return = array(
                'code' =>10001,
                'msg' => '删除失败!!'
            );
            $this -> ajaxReturn($return);
        }
    }

    //权限的展式方法
    public function auth(){
        $auth = D('Auth')->select();
        $auth = getTree($auth);
        $this->assign('auth',$auth);
        $this->display();
    }
    //权限的添加方法
    public function authAdd(){
        if(IS_POST){
            $data = I('post.');
            //dump($data);die;
            $res = D('Auth') -> add($data);
            if($res!==false){
                $return = array(
                    'code' =>10000,
                    'msg' => 'success'
                );
                $this -> ajaxReturn($return);
            }else{
                $return = array(
                    'code' =>10001,
                    'msg' => '添加失败!!'
                );
                $this -> ajaxReturn($return);
            }
        }else{
            //查询权限表中所有定级权限，用于下拉列表的展示
            $top_all = D('Auth') ->where('pid = 0') -> select();
            $this -> assign('top_all',$top_all);
            $this -> display();
        }

    }
    public function authEdit(){
        if(IS_POST){
            $data = I('post.');
            //dump($data);die;
            if(empty($data['auth_name'])){
                $return = array(
                    'code' =>10001,
                    'msg' => '权限名称不能为空'
                );
                $this -> ajaxReturn($return);
            }
            //如果要将该权限 改为二级权限 , 且旗下还有其他权限则不可修改
            if($data['pid'] != 0 && D('Auth') ->where(['pid' => $data['id']]) ->find()){
                $return = array(
                    'code' =>10001,
                    'msg' => '当前权限下有其他权限不可修改!!'
                );
                $this -> ajaxReturn($return);
            }
            $res = D('Auth') -> save($data);
            if($res!==false){
                $return = array(
                    'code' =>10000,
                    'msg' => 'success'
                );
                $this -> ajaxReturn($return);
            }else{
                $return = array(
                    'code' =>10001,
                    'msg' => '修改失败!!'
                );
                $this -> ajaxReturn($return);
            }

        }else{
            $id = I('get.id');
            $auth = D('Auth') ->where(['id' => $id]) ->find();
            $this -> assign('auth',$auth);
            $top_all = D('Auth') ->where('pid = 0') -> select();
            $this -> assign('top_all',$top_all);
            $this -> display();
        }
    }

    public function authDel(){
        $id = I('get.id',0,'intval');
        if($id <=0){
            $return = array(
                'code' =>10001,
                'msg' => '参数错误!!'
            );
            $this -> ajaxReturn($return);
        }
        $info =D('Auth') -> where(['pid' => $id]) ->find();
        if($info){
            $return = array(
                'code' =>10001,
                'msg' => '当前权限下有子权限,无法删除!!'
            );
            $this -> ajaxReturn($return);
        }
        $res = D('Auth') -> delete($id);
        if($res!==false){
            $return = array(
                'code' =>10000,
                'msg' => 'success'
            );
            $this -> ajaxReturn($return);
        }else{
            $return = array(
                'code' =>10001,
                'msg' => '删除失败!!'
            );
            $this -> ajaxReturn($return);
        }

    }

    /**
     * 个人信息
     */
    public function managerInfo(){
        $username = $_SESSION['manager_info']['username'];
        $data = D('Manager') -> where(['username' => $username]) -> find();
        $this -> assign('data', $data);

        $this -> display();
    }

}