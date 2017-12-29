<?php
namespace Admin\Model;
use Think\Model;
class ReaderModel extends Model {
	//自动验证
	protected $_validate = array(
		array('reader_name','require','用户名不能为空'),
		array('sex','require','性别不能为空'),
		array('address','require','性别不能为空'),
		array('introduce','require','性别不能为空'),



		array('phone','require','手机号不能为空'),
		array('email','email','邮箱格式不正确'),

	);

	//自动完成
	protected $_auto = array(
		array('create_time','time',1,'function'),
        array('status',1),
        array('is_show',1),
	);

//    查询读者信息及借阅信息
    public function queryReader($key){
        //查询匹配记录条数
        $count = M('reader') ->  where("id = '{$key}' or code_id ='{$key}' or name = '{$key}'") -> count();
        if($count == 0){
            $return = ['code' => 10004, 'msg' => '未查到读者信息'];
        }elseif($count > 1) {
            $return = ['code' > 10003, 'msg' => '查询结果较多，请填写完整条形码或姓名'];
        }else{
            //存在1条匹配的数据,就查询读者信息及借阅信息
            $reader = M('reader') -> where("code_id ='{$key}' or id = '{$key}'or name = '{$key}'") -> find();   //查询读者信息

            $level = M('readerLevel') -> where(['level_id'=>"{$reader['level_id']}"]) -> find();    //查该读者的级别信息
            $number = M('borrow') ->where("reader_id = {$reader['id']}  AND status = 0 ") -> count();   //查该读者的未还书数量
            $kejienumber = $level['borrow_number'] - $number;   //读者可借数量
            // dump($kejienumber);die;
            if($number){
                //如果借书未还数量>0,查借书信息
                $res =  M('borrow') -> alias('b')
                    -> join("LEFT JOIN tb_book i ON b.book_id = i.id")
                    -> where("b.reader_id = {$reader['id']}  AND b.status = 0")
                    -> field('i.id,i.sn,i.bookname,i.price,i.publish,i.cid,b.borrowTime,b.borrow_sn,b.backTime,b.operator')
                    -> select();
                $reader['borrownumber'] = $kejienumber; //可借书数量
            }else{
                $res = array();
                $reader['borrownumber'] = $level['borrow_number'];  //可借书数量
            }
            $return = ['code' => 10000, 'msg' => 'success', 'data' => $res,'reader_info' =>$reader];
        }

//        dump($reader);
//        dump($res);die;

       return $return;
    }
}