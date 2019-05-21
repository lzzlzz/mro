<?php
namespace app\index\controller;
use think\Controller;
class Supplier extends Controller
{
    public function add()
    {
        $cateRes=db('cate')->where('pid','=','0')->select();
        //dump($cateRes);die();
        $this->assign([
            'cateRes'=>$cateRes,
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
