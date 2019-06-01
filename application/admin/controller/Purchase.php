<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Exception;
use app\admin\model;
class Purchase extends Base
{

    public function replenish()
    {
        $repModel=new model\Replenish;

        $repRes=$repModel->getCateRep();
         //  dump($repRes[0]);die();
        $this->assign([
        	'repRes'=>$repRes,
        ]);
           return view();
    }
    public function lsted(){
        $insModel=new model\InStorage;
        $insRes=$insModel::with('SupplyList')->paginate(4);
       // dump($insRes[0]['supply_list']);die();
       // 根据入库单中关联的供货单中的供应商id找到供应商姓名 //不知道如何嵌套关联所以现在只能这么写
        $sprRes=db('supplier')->field(['id','sp_name'])->select();
        static $arr=[];
        foreach ($sprRes as $key => $value) {
            $arr[$value['id']]=$value['sp_name'];
        }
        $this->assign([
            'insRes'=>$insRes,
            'spArr'=>$arr,
        ]);
        return view();
    }
    public function edit($id){
       
        $skoRes=model('Replenish')->getSkoRep($id);

    //   dump($skoRes);die();
    	$pdtRes=db('product')->field(['id','pdt_name'])->select();
        static $pdtArr=[];
        foreach ($pdtRes as $k => $v) {
            $pdtArr[$v['id']]=$v['pdt_name'];
        }
        //dump($pdtRes);die();
        //volist的循环可以嵌套 
        $spRequire=[
            'sp_cate_id' => $skoRes['rep_cate_id'],
            'sp_checked' => 1,
        ];
        $spRes=db('supplier')->where($spRequire)->field(['id','sp_name'])->select();
       // dump($spRes);
    	$this->assign([
    		'skoRes'=>$skoRes['stockout'],
            'pdtArr'=>$pdtArr,
            'spRes'=>$spRes,
    	]);
         //dump($skoRes);die();
    	if(request()->isPost()){
    		$data=input('post.');
         //  dump($data);die();
            static $arr=[];//把前端提交过来的变量转化为合适的数组形式
            foreach ($data as $key => $value) {
                if($key!='rept_rep_id'){
                    $i=0;
                    foreach ($value as $k => $v) {
                        $arr[$i++][$key]=intval($v);
                    }
                    
                }
                   
            }
            foreach ($arr as $key => $value) {
                $arr[$key]['rept_rep_id']=intval($data['rept_rep_id']);
            }
           // dump($arr);die();
        try{
            Db::startTrans();
            static $res=[];
            //向分表中插入补货item
            $res[]=db('replenish_item')->insertAll($arr);
            //更新补货单状态
            $res[]=db('replenish')->where('id',$id)->update(['rep_finish'=>1]);
            if(in_array(0, $res)){
                throw new Exception('补货单生成失败，请再试一次');
                
            }
            Db::commit();
            $this->success('补货单已生成，请及时下载',url('replenish'));
        }catch (Exception $e){
            Db::rollback();
            $this->error('补货单生成失败，请再试一次');
        }
            
   }
    return view();
    
}

    public function del($id){
    	$res=db('supplier')->delete($id);
		if($res){
			$this->success('用户信息删除成功',url('lst'));
		}else{
			$this->error('用户信息删除失败');
		}
    }
/**
 * [price description]根据库存中已有的价格和数量 计算总价 然后计算新增总价
 * 最后加和取均值 取新旧产品的均值 按所占比例
 * @param  [type] $q0 [description]已有的数量
 * @param  [type] $p0 [description]原来的单价
 * @param  [type] $q1 [description]新增的数量
 * @param  [type] $p1 [description]新增的单价
 * @return [type]     [description]
 */
    public function price($p0,$q0,$p1,$q1){
        $q0=intval($q0);
        $p0=doubleval($p0);
        $q1=intval($q1);
        $p1=doubleval($p1);
       
        return ($q0*$p0+$q1*$p1)/($q0+$q1);
    }
//导出补货单 
     public function daochu($id){
         $list=model('Replenish')->getReplenish($id);
        $pdt=db('product')->select();
        $sp=db('supplier')->select();
        static $pdtRes=[];
        foreach ($pdt as $key => $value) {
            $pdtRes[$value['id']]['pdt_num']=$value['pdt_num'];
            $pdtRes[$value['id']]['pdt_name']=$value['pdt_name'];
        }
        static $spRes=[];
        foreach ($sp as $key => $value) {
            $spRes[$value['id']]['sp_num']=$value['sp_num'];
            $spRes[$value['id']]['sp_name']=$value['sp_name'];
        }

       // dump($spRes);die();
        vendor("PHPExcel176.PHPExcel");
        $objPHPExcel = new \PHPExcel();

        $objPHPExcel->getProperties()->setCreator("ctos")
            ->setLastModifiedBy("ctos")
            ->setTitle("Office 2007 XLSX Test Document")
            ->setSubject("Office 2007 XLSX Test Document")
            ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Test result file");

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(8);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);

        //设置行高度
        $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(20);

        $objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(20);

        //set font size bold
        $objPHPExcel->getActiveSheet()->getDefaultStyle()->getFont()->setSize(10);
        $objPHPExcel->getActiveSheet()->getStyle('A2:E2')->getFont()->setBold(true);

        $objPHPExcel->getActiveSheet()->getStyle('A2:E2')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A2:E2')->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);

        //设置水平居中
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('B')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('D')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('E')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        //合并cell
        $objPHPExcel->getActiveSheet()->mergeCells('A1:F1');
        $objPHPExcel->getActiveSheet()->mergeCells('A2:F2');
        $objPHPExcel->getActiveSheet()->mergeCells('A3:F3');

        // set table header content
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', '补货单')
            ->setCellValue('A2', '补货单  生成时间:'.date('Y-m-d H:i:s'))
            ->setCellValue('A3', '补货单  编号:'.$list['rep_num'])
            ->setCellValue('A4', '补货单  类型:'.$list['rep_cate_id'])
            ->setCellValue('A5', '序号')
            ->setCellValue('B5', '产品编号')
            ->setCellValue('C5', '产品名称')
            ->setCellValue('D5', '补货数量')
            ->setCellValue('E5', '供应商编号')
            ->setCellValue('F5', '供应商名称');


        // Miscellaneous glyphs, UTF-8
        for($i=0;$i<count($list['replenish_item'])-1;$i++){
            $objPHPExcel->getActiveSheet(0)->setCellValue('A'.($i+6), $list['replenish_item'][$i]['id']);
            $objPHPExcel->getActiveSheet(0)->setCellValue('B'.($i+6), $pdtRes[$list['replenish_item'][$i]['rept_pdt_id']]['pdt_num']);
            $objPHPExcel->getActiveSheet(0)->setCellValue('C'.($i+6), $pdtRes[$list['replenish_item'][$i]['rept_pdt_id']]['pdt_name']);
            $objPHPExcel->getActiveSheet(0)->setCellValue('D'.($i+6), $list['replenish_item'][$i]['rept_quantity']);
            $objPHPExcel->getActiveSheet(0)->setCellValue('E'.($i+6), $spRes[$list['replenish_item'][$i]['rept_sp_id']]['sp_num']);
            $objPHPExcel->getActiveSheet(0)->setCellValue('F'.($i+6), $spRes[$list['replenish_item'][$i]['rept_sp_id']]['sp_name']);
            //$objPHPExcel->getActiveSheet()->getStyle('A'.($i+3).':J'.($i+3))->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
            //$objPHPExcel->getActiveSheet()->getStyle('A'.($i+3).':J'.($i+3))->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
            $objPHPExcel->getActiveSheet()->getRowDimension($i+6)->setRowHeight(16);
        }


        //  sheet命名
        $objPHPExcel->getActiveSheet()->setTitle('补货单');


        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);


        // excel头参数
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="补货单('.date('Ymd-His').').xls"');  //日期为文件名后缀
        header('Cache-Control: max-age=0');

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  //excel5为xls格式，excel2007为xlsx格式

        $objWriter->save('php://output');

    }
  
}
