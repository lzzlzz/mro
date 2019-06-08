<?php
namespace app\index\validate;
use think\Validate;
class Cus extends Validate
{
    protected $rule =   [
        'cus_name'  => 'require|unique:customer|min:2',//这个cate是数据库的表明 
    ];
    
    protected $message  =   [
        'cus_name.require' => '名称必须，不得为空',
        'cus_name.unique' => '名称不得重复',
        'cus_name.min' => '名称过短',
       
        
           
    ];

    
    

}



