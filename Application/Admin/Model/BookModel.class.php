<?php
namespace Admin\Model;


use Think\Model;

class BookModel extends Model
{
    public function queryBook($key){
        $res = $this -> where("sn like '{$key}%' or bookname like '{$key}%'") -> select();
        if($res){
            $return = ['code' => 10000, 'msg' => 'success', 'data' => $res];
        }else{
            $return = ['code' => 10005, 'msg' => '暂无数据'];
        }
        return $return;
    }
    protected $_validate = array(
		array('name','require','书名不能为空'),
		array('author','require','作者不能为空'),
		array('price','require','价格不能为空'),
		array('sn','require','编码不能为空'),
		array('from','require','国籍不能为空'),
		array('publish','require','出版社不能为空'),
		array('price','currency','价格格式不正确'),
	);

}
