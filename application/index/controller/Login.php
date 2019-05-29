<?php
namespace app\index\controller;
use think\Controller;
use app\index\model\Customer;
class Login extends Controller
{
    public function index()
    {
    	if(request()->ispost()){
    		$data=input('post.');
    		//var_dump($data);die();
    		$cusModel=new Customer;
    		$res=$cusModel->login($data);
    		if($res==1){
    			$this->success('登录成功！',url('Customer/add'));
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
