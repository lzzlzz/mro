<?php
namespace app\admin\model;
use think\Model;
class Cate extends Model
{
    //建立分类与产品一对多的关系一种类别对应多个产品
    public function product(){
        return $this->hasMany('Product','pdt_cate_id','id');
    }
    public function getPdtById($id){
        return self::with('product')->find($id);
    }
    
    //建立分类与供应商一对多的关系一种类别对应多个供应商
    public function supplier(){
        return $this->hasMany('Supplier','sp_cate_id','id');
    }
    public function getSpById($id){
        return self::with('supplier')->find($id);
    }

    //建立分类与补货单一对多的关系一种类别对应多个补货单
    public function replenish(){
        return $this->hasMany('Replenish','rep_cate_id','id');
    }

    
    //过滤前台发过来的多于字段
    protected $field=true;

    public function coach(){
        return $this->hasMany('Coach','cate_id','id');
    }
    // 无限极栏目
    public function cateTree(){
        $data=$this->order('id desc')->select();
        return $this->sortcate($data);
    }

    public function sortcate($data,$pid=0,$level=0){
        static $arr=[];
        foreach ($data as $k => $v) { //找顶级栏目  v是他的值
            if ($v['pid']==$pid) {//如果是顶级栏目就将其放进数组里
                $v['level']=$level;
                $arr[]=$v;
                $this->sortcate($data,$v['id'],$level+1);//找到顶级栏目后找其他栏目
            }
        }
        return $arr;
    }


    //无限极删除
    //获取子栏目id
    public function getChildIds($id){//$id为传递过来的栏目id
        $data=$this->select();//得到所有栏目的信息
        return $this->_getChildIds($data,$id);//运行下面私有方法 传参 所有栏目信息 和 传参栏目id
    }

    private function _getChildIds($data,$id){//接受一下
        static $arr=array();//创建静态数组
        foreach ($data as $k => $v) {
            if ($v['pid']==$id) {//所有栏目的pid 等于当前栏目id 则为子栏目
                $arr[]=$v['id'];//获取其子栏目id 放到静态数组里面
                $this->_getChildIds($data,$v['id']);//继续往下找  寻找子栏目的子栏目
            }
        }
        return $arr;

    }
//根据产品的类别id 找到一级分类id
    public function getFather($id){
        $res=self::field('pid')->find($id);
        $pid=$res['pid'];
        if($pid==0){
            return $id;
        }else{
            return $this->getFather($pid);
        }
    }

}