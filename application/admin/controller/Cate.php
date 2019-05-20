<?php
namespace app\admin\controller;
use think\Controller;
class Cate extends Controller
{
    public function add(){
        $cateRes=model('Cate')->cateTree();
       //dump($cateRes);die();
        $this->assign([
            'cateRes'=>$cateRes,
        ]);
        if(request()->isPost()){
            $data=input('post.');
            
            $res=db('cate')->insert($data);
            if($res){
                $this->success('商品分类新增成功',url('lst'));
            }else{
                $this->error('商品分类新增失败');
            }
        }
        return view();
    }
    public function lst()
    {
    	   $cateRes=model('Cate')->cateTree();//分类展示后不能分页了 
              //dump($cateRes);die();
           $this->assign([
               'cateRes'=>$cateRes,
           ]);
       return view();
    }
    public function edit($id){

        $cated=db('cate')->find($id);
    	
    	$cateRes=model('Cate')->cateTree();
                     //dump($cateRes);die();
        $this->assign([
            'cated'=>$cated,
            'cateRes'=>$cateRes,
        ]);
    	if(request()->isPost()){
    		$data=input('post.');
    		$res=db('cate')->update($data);
    		if($res){
    			$this->success('商品分类信息修改成功',url('lst'));
    		}else{
    			$this->error('商品分类信息修改失败');
    		}
    	}
    	return view();
    }

    public function del($id){
    	$cateChild=model('Cate')->getChildIds($id);
        $cateChild[]=$id;
        $res=db('cate')->delete($cateChild);
        if($res){
            $this->success('删除商品类别成功',url('lst'));
        }else{
            $this->error('删除商品类别失败');
        }
    }
  
}
