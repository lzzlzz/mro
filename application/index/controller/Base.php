<?php
namespace app\index\controller;
use think\Controller;
use think\Session;
class Base extends Controller {
    public function _initialize()
    {
        if (Session::has('username')) {
            //已登陆，不做任何操作
           // dump(Session::get('username'));die();
        }else{
            // $this->redirect('Login/login');
            $this->error('请先登录!',url('Login/index'));
        }
    }
    
}