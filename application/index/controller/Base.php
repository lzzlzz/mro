<?php
namespace app\index\controller;
use think\Controller;
use think\Session;
class Base extends Controller {
 
    public function _initialize()
    {
        $cusRes['username']='';
        if (Session::has('username')) {
            $cusRes['username']=Session::get('username');
           // dump(Session::get('username'));die();
        }else{
            // $this->redirect('Login/login');
            $this->error('请先登录!',url('Login/index'));
        }

        $this->assign([
            'cusRes'=>$cusRes,
        ]);
    }
    
}