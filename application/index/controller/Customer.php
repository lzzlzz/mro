<?php
namespace app\index\controller;
use think\Controller;
class Customer extends Controller
{
    public function add()
    {
    	if(request()->isPost()){
    		$data=input('post.');
    	    $data['cus_num']='C'.time();
    	    $data['cus_addtime']=time();
    	    $res=db('customer')->insert($data);
    	    if($res){
    	    	$this->success('用户信息填写成功',url('add'));
    	    }else{
    	    	$this->error('用户信息填写失败');
    	    }
    	}
    	
        return view();
    }
}
