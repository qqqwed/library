<?php
namespace Admin\Controller;
use Admin\Controller\CommonController;
class IndexController extends CommonController {
    public function index(){
        // if (session('manager_info')['username']==''){
        //     $this->error('请登录',U('Admin/Login/login'));
        // }
        $id = session('manager_info.role_id');
        $res = M('Role')->where(['id'=>$id])->find();
        $this->assign('res',$res);
        $this -> display();
    }

    public function welcome(){
        $Model = new \Think\Model();
        $res =  $Model->query("SELECT * FROM (SELECT book_id,count(book_id) AS degree FROM tb_borrow GROUP BY book_id) AS borr
JOIN tb_book b ON b.id=borr.book_id ORDER BY degree desc LIMIT 10");
//        dump($res);
        //借的数量
        $data = [];
        //借的书名
        $book = [];
        foreach($res as $v){
            $data[] = (int)$v['degree'];
            $book[] = $v['bookname'];
        }
//        dump($data);dump($book);die;
        $data = json_encode($data);
        $book = json_encode($book);
        $this -> assign('data', $data);
        $this -> assign('book', $book);
        $this ->display();
    }

}