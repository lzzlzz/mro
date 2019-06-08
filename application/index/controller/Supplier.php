<?php
namespace app\index\controller;
use think\Controller;
use think\Session;
class Supplier extends Controller
{
    public function add()
    {
         $cusRes['username']='';
        if (Session::has('username')) {
            $cusRes['username']=Session::get('username');
           // dump(Session::get('username'));die();
        }
        $cateRes=db('cate')->where('pid','=','0')->select();
        //dump($cateRes);die();
        $this->assign([
            'cateRes'=>$cateRes,
             'cusRes'=>$cusRes,
        ]);
    	if(request()->isPost()){
    		$data=input('post.');
    	    $data['sp_num']='SP'.time();
    	    $data['sp_addtime']=time();
    	    $res=db('supplier')->insert($data);
    	    if($res){
    	    	$this->success('申请提交成功',url('add'));
    	    }else{
    	    	$this->error('申请提交失败');
    	    }
    	}
    	
        return view();
    }
}
