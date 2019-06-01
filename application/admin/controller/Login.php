<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\Admin;
class Login extends Controller
{
    public function index()
    {
    	if(request()->ispost()){
    		$data=input('post.');
    		//var_dump($data);die();
    		$adModel=new Admin;
    		$res=$adModel->login($data);
    		if($res==1){
    			$this->success('登录成功！',url('index/index'));
    		}elseif($res==0){
    			$this->error('此用户不存在！');
    		}else{
    			$this->error('密码输入错误！');
    		}
    	}
       return view();
    }

    public function logout(){
    	session('username',null);
    	$this->redirect(url('index'));
    }
}
