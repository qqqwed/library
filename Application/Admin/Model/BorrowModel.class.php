<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-12-15
 * Time: 21:54
 */

namespace Admin\Model;


use Think\Model;

class BorrowModel extends  Model
{
    protected $_auto = array(
        //完成字段1,完成规则,[完成条件,附加规则]),
        array('borrow_sn','uniqid',1,'function'),
        array('borrowTime',"date",1,'callback'),
        array('backTime',"back",1,'callback'),
    );
    public function date(){
        return date('Y-m-d');
    }
    public function back(){
       return date('Y-m-d',time()+86400*30);
    }


//    查询借阅信息
    public function bQuery($key,$start,$end){

        $map['b.borrowTime'] = array('between',"$start,$end");
        $data = $this -> alias('b') -> join("LEFT JOIN tb_book i ON i.id=b.book_id")
            -> join("LEFT JOIN tb_reader r ON b.reader_id = r.id")
            -> where("i.sn like '{$key}' or i.bookname = '{$key}'")
            -> where($map)
            -> field('i.sn,i.bookname,r.code_id,r.name,b.borrowTime,b.backTime,b.status')
            -> order('b.borrowTime desc')
            ->select();
//       $data = $this -> alias('b') -> join('tb_bookinfo i ON i.id=b.book_id')
//           ->where("i.bookname='{$key}'")-> select();
        if($data){
            $return = ['code' => 10000, 'msg' => 'success', 'data' => $data];
        }
        else{
            $return = ['code'=>10001, 'msg'=>'暂无数据'];
        }
        return $return;
    }

    public function bQuery2($start,$end){

        $map['b.borrowTime'] = array('between',"$start,$end");
        $data = $this -> alias('b') -> join("LEFT JOIN tb_book i ON i.id=b.book_id")
            -> join("LEFT JOIN tb_reader r ON b.reader_id = r.id")
            -> where($map)
            -> field('i.sn,i.bookname,r.code_id,r.name,b.borrowTime,b.backTime,b.status')
            -> order('b.borrowTime desc')
            ->select();
//       $data = $this -> alias('b') -> join('tb_bookinfo i ON i.id=b.book_id')
//           ->where("i.bookname='{$key}'")-> select();
        if($data){
            $return = ['code' => 10000, 'msg' => 'success', 'data' => $data];
        }
        else{
            $return = ['code'=>10001, 'msg'=>'暂无数据'];
        }
        return $return;
    }

    public function bQuery3($key){

        $data = $this -> alias('b') -> join("LEFT JOIN tb_book i ON i.id=b.book_id")
            -> join("LEFT JOIN tb_reader r ON b.reader_id = r.id")
            -> where("i.sn like '{$key}' or i.bookname = '{$key}'")
            -> field('i.sn,i.bookname,r.code_id,r.name,b.borrowTime,b.backTime,b.status')
            -> order('b.borrowTime desc')
            ->select();
        if($data){
            $return = ['code' => 10000, 'msg' => 'success', 'data' => $data];
        }
        else{
            $return = ['code'=>10001, 'msg'=>'暂无数据'];
        }
        return $return;
    }
}