<?php
namespace Admin\Controller;
use Think\Controller;
class LoginController extends Controller {
    /**
     * 显示后台登录页
     */
    public function login(){
        $this -> display();
    }
    /**
     * ajax验证登录
     */
    public function loginHandle() {
        //接受数据
        $data = I('post.');
        //验证码校验 使用验证码类中的check方法
        $verify = new \Think\Verify();
        $check = $verify -> check($data['captcha']);
       if (!$check) {
            //验证码错误
            $return = array(
                'status' => 1,
                'msg' => '验证码不正确'
            );
            $this -> ajaxReturn($return);
        }
        //根据登录名匹配数据
        $model = D('Manager');
        $res =$model -> where( ['username' => $data['admin_name']] ) -> find();
        if ( $res && encrypt_password($data['admin_password']) == $res['password']) {
            if ($res['status'] == 2) {
                //验证码错误
                $return = array(
                    'status' => 1,
                    'msg' => '账号已被禁用'
                );
                $this -> ajaxReturn($return);
            }
            //登录成功 设置session
            session('manager_info', $res);
            $return = array(
                'status' => 0,
                'msg' => '登录成功'
            );
        } else {
            //密码错误
            $return = array(
                'status' => 2,
                'msg' => '用户名或者密码错误'
            );
        }
        $this -> ajaxReturn($return);
    }
    /**
     * 退出登录
     */
    public function logout() {
        //清空session
        session(null);
        //跳转登录页面
        $this -> redirect( 'Admin/Login/login' );
    }
    /**
     * 生成一张验证码图片
     */
    public function captcha() {
        //自定义配置
        $config = array(
            'useCurve' => false,
            'useNoise' => false,
            'length'   => 4
        );
        //实例化Verify类
        $verify = new \Think\Verify($config);
        //调用entry方法生成并输出验证码图片
        $verify -> entry();
    }
}