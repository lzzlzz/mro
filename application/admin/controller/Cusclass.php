<?php
namespace app\admin\controller;
use think\Controller;
class Cusclass extends Base
{
    public function add(){
        if(request()->isPost()){
            $data=input('post.');
            //dump($data);die();
            $res=db('customer_class')->insert($data);
            if($res){
                $this->success('用户等级新增成功',url('lst'));
            }else{
                $this->error('用户等级新增失败');
            }
        }
        return view();
    }
    public function lst()
    {
    	$clsRes=db('customer_class')->paginate(6);
    	$this->assign([
    		'clsRes'=>$clsRes,
    	]);
       return view();
    }
    public function edit($id){
    	$clsRes=db('customer_class')->find($id);
    	$this->assign([
    		'clsRes'=>$clsRes,
    	]);
    	if(request()->isPost()){
    		$data=input('post.');
    		$res=db('customer_class')->update($data);
    		if($res){
    			$this->success('等级信息修改成功',url('lst'));
    		}else{
    			$this->error('等级信息修改失败');
    		}
    	}
    	return view();
    }

    public function del($id){
    	$res=db('customer_class')->delete($id);
		if($res){
			$this->success('等级信息删除成功',url('lst'));
		}else{
			$this->error('等级信息删除失败');
		}
    }
   

}
