<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model;
class Product extends Base
{
  public function test(){
    return view();
  }
    public function add(){
         $cateRes=model('Cate')->cateTree();
        //dump($cateRes);die();
         $this->assign([
             'cateRes'=>$cateRes,
         ]);
         if(request()->isPost()){
            $data=input('post.');
            $data['pdt_num']='P'.time();
          //  dump($_FILES);die();
            if($_FILES['pdt_pic']['tmp_name']){
                       $data['pdt_pic']=$this->upload();
                   }
           // dump($data);die();
            $res=db('product')->insert($data);
            if($res){
                $this->success('商品基本信息添加成功',url('lst'));
            }else{/*这里还有一个问题 当添加信息失败后 图片已经上传到服务器了但是信息没插进去产生了垃圾数据*/
                $this->error('商品基本信息添加失败');
            }
         }

        return view();
    }

     //图片上传
   public function upload(){
       // 获取表单上传文件 例如上传了001.jpg
       $file = request()->file('pdt_pic');
       
       // 移动到框架应用根目录/public/uploads/ 目录下
       if($file){
           $info = $file->move(ROOT_PATH . 'public' . DS .'static'. DS . 'uploads');
           if($info){
               // 成功上传后 获取上传信息
               // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
               return $info->getSaveName();
           }else{
               // 上传失败获取错误信息
               echo $file->getError();
               die();
           }
       }
   }
    public function lst()
    {   
        //根据列表中的分类id找分类名称 这种方法比较繁琐 //通过ORM建立参照关系进行关联查询简单
        // $cateRes=db('cate')->field(['id','cate_name'])->select();
        // static $arr=[];
        // foreach ($cateRes as $k => $v) {
        //     $arr[$v['id']]=$v['cate_name'];
        // }
       // dump($cateRes);die();
      $pdt=new model\Product;
      $pdtRes=$pdt::with('cate')->paginate(5);
      //dump($pdtRes[0]);die();
    	$this->assign([
    		'pdtRes'=>$pdtRes,
    	]);
       return view();
    }
    public function edit($id){

    	$pdtRes=db('product')->find($id);

        $cateRes=model('Cate')->cateTree();
        
    	$this->assign([
    		'pdtRes'=>$pdtRes,
            'cateRes'=>$cateRes,
    	]);
    	if(request()->isPost()){
    		$data=input('post.');
      //  dump($data);die();
        if($_FILES['pdt_pic']['tmp_name']){
                       $data['pdt_pic']=$this->upload();
                   }
    		$res=db('product')->update($data);
    		if($res){
    			$this->success('用户信息修改成功',url('lst'));
    		}else{
    			$this->error('用户信息修改失败');
    		}
    	}
    	return view();
    }

    public function del($id){
        //find()返回的是一个数组 select（）返回的是数组中还有数组
        $pdt_pic=db('product')->field('pdt_pic')->find($id);
        
    	$res=db('product')->delete($id);
		if($res){
            $picSrc=IMG_UPLOADS.$pdt_pic['pdt_pic'];
            if (file_exists($picSrc)) {//监测是否有图片
                @unlink($picSrc);
            }
			$this->success('用户信息删除成功',url('lst'));
		}else{
			$this->error('用户信息删除失败');
		}
    }

}
