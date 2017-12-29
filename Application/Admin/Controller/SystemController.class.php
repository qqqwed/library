<?php

namespace Admin\Controller;

use Admin\Controller\CommonController;

class SystemController extends CommonController{

	public function category(){

		if (IS_POST) {
			
			$data = I('post.sousuo');

			$res = M('system')->where(['name' => ['like', "%$data%"]])->select();

			dump($res);die;

		} else {


        $cate = M('system') -> select();
        $cate = getTree($cate);
        $this -> assign('cate', $cate);
        $this -> display();
			
		}
    }

	//添加分类
	public function add(){

		if (IS_POST) {
			
			$data = I('post.');

			//判断是哪一级分类
			// if($data['three'] != 0){
   //              $data['pid'] = $data['three'];
            
   //          }elseif($data['two'] != 0){
   //              $data['pid'] = $data['two'];
            
   //          }elseif($data['one'] != 0){
   //              $data['pid'] = $data['one'];
            
   //          }else{
   //              $data['pid'] = 0;
   //          }
			
			$model = D('system');

			$model->create($data);

			$res = $model->add();

			if ($res) {
				$this->success('添加成功', U('Admin/System/category'));
			} else {
				$this->error('添加失败');
			}

		} else {

			//获取顶级分类
			$top = M('system')-> select();
			$this->assign('top', $top);
			$this->display();
		}
	
	}

	//删除分类
	public function delete(){

		$id = I('get.id');

		if (!is_numeric($id)) {
			$this->error('非法参数');
		
		} else {
			$count = M('system')->where("pid = $id")->count();

			if ($count > 0) {
				$this->error('只能删除空分类');
			
			} else {
				
				$res = M('system') -> delete($id);
               
                if($res != false){
                    $this -> success('删除成功', U('Admin/System/category'));
                }else{
                    $this -> error('删除失败');
                }
			
			}
			
		}
		
	}

	//修改分类
	public function edit(){

		 if(IS_POST){
            
            $data = I('post.');
//           
            //判断是否顶级分类
            //if($data['three'] != 0){
                //$data['pid'] = $data['three'];
            
           // }elseif($data['two'] != 0){
               // $data['pid'] = $data['two'];
            
           // }elseif($data['one'] != 0){
                //$data['pid'] = $data['one'];
            
           //}else{
                //$data['pid'] = 0;
           // }
//            
            $model = D('system');
            
            $model -> create($data);
            
            $res = $model -> save();
            
            if($res != false){
                $this -> success('修改成功!', U('Admin/System/index'));
            
            }else{
                $this -> error('修改失败!');
            }


        }else{

            $id = I('get.id');
            
            $cate = M('system') -> find($id);


            if($cate['pid'] == 0){
                $cate['one'] = $id;
            
            }else{
                
                //二级分类
                $cate_two = M('system') ->where("id = {$cate['pid']}") -> find();
                
                if($cate_two['pid'] == 0){
                    $cate['one'] = $cate['pid'];
                    $cate['two'] = $id;

                }else{
                    //三级分类
                    $cate_two = M('system') ->where("id = {$cate['pid']}") -> find();
                    $cate['one'] = $two['pid'];
                    $cate['two'] = $two['id'];
                    $cate['three'] = $id;

                    //获取一级分类相同的所有二级分类
                    $c_tongji = M('system') ->where("pid = {$cate['one']}") -> select();
                    
                    $this -> assign('tongji', $tongji);
                
                }
            }

            $this -> assign('cate', $cate);
            
            $top = M('system') ->where('pid = 0') -> select();
            $this -> assign('top', $top);
            $this -> display();
        }

	}


    //批量删除
    public function deleteAll(){

        $id = I('get.id');

        
    }

}