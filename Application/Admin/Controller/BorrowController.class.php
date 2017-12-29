<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-12-08
 * Time: 19:24
 */

namespace Admin\Controller;


use Admin\Controller\CommonController;

class BorrowController extends CommonController
{
//    图书借阅
    public function bookBorrow(){
        if(IS_POST){
            $data = I('post.');
            $re = D('Reader') -> queryReader($data['reader_id']);
            if($re['reader_info']['borrownumber']){
                //如果有借数量就借书
                $model = D('Borrow');
                $da = ['reader_id'=>$data['reader_id'], 'book_id' => $data['id']];
                $model -> create($da);
                $r = $model->add();
                if($r){
                    $res = D('Book') -> where("id = {$data['id']}") -> setField('status', 0);

                    if($res !== false){
                        $return=['code'=>10000, 'msg' => 'success'];
                    }else{
                        $return = ['code' => 10001, 'msg' => '借书失败'];
                    }
                }else{
                    $return = ['code'=>10004, 'msg' => '创建借书单失败'];
                }

            }else{
                $return = ['code' => 10002, 'msg' => '超出可借数量'];
            }

            $this -> ajaxReturn($return);
        }else{
            $this -> display();
        }
    }

//    图书续借
    public function bookRenew(){

        $this -> display();
    }

//    查询读者信息
    public function readerInfo(){
        $key = I('post.key');

        $return = D('Reader') -> queryReader($key);
        $this -> ajaxReturn($return);
    }
//    ajax查询读者或编号
    public function search(){
        $key = I('get.key');
//        $key = '李';
//        dump($key);die;
        $res = M('reader') -> where("code_id like '{$key}%' or name like '{$key}%'") -> select();
//        dump($res);die;
        if($res){
            $return = ['code' => 10000, 'msg' => 'success', 'data' => $res];
        }else{
            $return = ['code' => 10005, 'msg' => '暂无数据'];
        }
        $this -> ajaxReturn($return);
    }


//    ajax查询读者信息及借阅信息
    public function search2(){
        $key = I('post.key');

       // $key = '12454332';
        $return =D('Reader') -> queryReader($key);

        $this -> ajaxReturn($return);

    }

//    ajax查询图书条形码或图书名
    public function querybook(){
        $key = I('get.key');
        $res = M('Book') -> where("sn like '{$key}%' or bookname like '{$key}%'") -> select();
        if($res){
            $return = ['code' => 10000, 'msg' => 'success', 'data' => $res];
        }else{
            $return = ['code' => 10005, 'msg' => '暂无数据'];
        }
        $this -> ajaxReturn($return);
    }
//    ajax查询图书信息
    public function bookInfo(){
        $key = I('get.key');
        $res = M('Book') -> where("sn = '{$key}' or bookname = '{$key}'") -> select();
        if($res){
            $return = ['code' => 10000, 'msg' => 'success', 'data' => $res];
        }else{
            $return = ['code' => 10005, 'msg' => '暂无数据'];
        }
        $this -> ajaxReturn($return);
    }
//    还书
    public function backbook(){
        $id = I('post.id');
//        $id = 21241;
        //改变借还状态
        $res = D('Borrow') -> where(['book_id'=>"{$id}"]) -> setField('status', 2);

//        $res = M('Borrow') -> where(['borrow_sn'=>'{$id}']) -> delete();

        if($res){
            D('Book') -> where(['id' => "{$id}"]) -> setField('status', 1);
            $return = ['code' => 10000, 'msg' => 'success'];
        }else{
            $return = ['code' => 10001, 'msg' => '还书失败'];
        }
        $this -> ajaxReturn($return);
    }

//    续借
    public function book_renew(){
        $id = I('post.borrow_sn');
        //修改还书日期
        $date =  D('Borrow') ->  where(['borrow_sn'=>"{$id}"]) -> field('borrowtime')-> find();
        $n_time = date('Y-m-d',strtotime($date['borrowtime'])+3600*24*60);
        $res = D('Borrow') ->  where(['borrow_sn'=>"{$id}"]) -> setField('backTime', $n_time);;
        if($res !==false){
            if ($res == 0){
                $return = ['code' => 10003, 'msg' => '超过可续借次数'];
            }else{
                //获取新的应还时间
                $bt =  D('Borrow') ->  where(['borrow_sn'=>"{$id}"]) -> field('backTime')-> find();
                $return = ['code' => 10000, 'msg' => '续借成功', 'backtime' => $bt['backtime']];
            }
        }else{
            $return = ['code' => 10002, 'msg' => '续借失败'];
        }
        $this -> ajaxReturn($return);
    }

//    图书借阅查询
    public function borrowQuery(){
        if(IS_POST){
            $data = I('post.');
//            dump($data);
            if($data['datemin'] && $data['datemax'] && $data['key']){
               $res= D('Borrow') -> bQuery($data['key'],$data['datemin'],$data['datemax']);

            }elseif($data['datemin'] && $data['datemax']){
                $res= D('Borrow') -> bQuery2($data['datemin'],$data['datemax']);
            }elseif($data['key']){
                $res= D('Borrow') -> bQuery3($data['key']);
            }else{
                $res = ['code'=>'10007','msg'=>'参数不合法'];
            }
            $this -> ajaxReturn($res);
        }else{
            $this -> display();
        }
    }
}