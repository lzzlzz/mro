<?php
namespace app\index\controller;
use think\Controller;
use think\Session;
class Customer extends Controller
{
    public function add()
    {

         $cusRes['username']='';
        if (Session::has('username')) {
            $cusRes['username']=Session::get('username');
           // dump(Session::get('username'));die();
        }
        $this->assign([
            'cusRes'=>$cusRes,
        ]);
    	if(request()->isPost()){
    		$data=input('post.');
            $validate=validate('Cus');
            $res=$validate->check($data);
            if($res!=true){
                $this->error($validate->getError());
            }
            $data['cus_password']=md5($data['cus_password']);
         //   dump($data['cus_password']);die();
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
