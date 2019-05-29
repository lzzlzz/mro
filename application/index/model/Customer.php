<?php
namespace app\index\model;
use think\Model;
class Customer extends Model
{
	public function login($data){
		$res=db('customer')->where('cus_name','=',$data['username'])->find();
		if($res){//如果有这个人就验证密码
			if($res['cus_password']==$data['password']){//如果密码正确
				session('username',$res['cus_name']);//设置session
				session('uid',$res['id']);
				return 1;
			}else{
				return -1;
			}
		}else{//没有这个人就返回没有人的信息
			return 0;
		}
	}
}