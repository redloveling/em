<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/8/9
 * Time: 17:31
 */
namespace Com\Excel;

class ReadExcel {
    private $objPHPExcel;

    public function __construct()
    {
        //引入PHPExcel
        vendor('PHPExcel.PHPExcel');
        $this->objPHPExcel = new \PHPExcel();

        $this->objPHPExcel->getProperties()->setCreator("administrator");
        $this->objPHPExcel->getProperties()->setLastModifiedBy("administrator");
        $this->objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");
        $this->objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
        $this->objPHPExcel->getProperties()->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.");
        $this->objPHPExcel->getProperties()->setKeywords("office 2007 openxml php");
        $this->objPHPExcel->getProperties()->setCategory("Test result file");
    }

    /**
     * 读取excel文件数据
     * lyj
     * @date 2016年8月8日09:40:47
     * @param string $filename 文件url+文件名
     * @param string $exts excel文件类型
     * @return array excel数据
     * @throws \PHPExcel_Exception
     */
    public function read($filename, $exts = 'xls') {
        if($exts == 'xls') {
            $PHPReader = new \PHPExcel_Reader_Excel5();
        } else if ($exts == 'xlsx') {
            $PHPReader = new \PHPExcel_Reader_Excel2007();
        } else {
            die('文件类型错误');
        }

        //载入文件
        $PHPExcel       = $PHPReader->load($filename);

        //获取表中的第一个工作表，如果要获取第二个，把0改为1，依次类推
        $currentSheet   = $PHPExcel->getSheet(0);

        //获取总列数
        $allColumn      = $currentSheet->getHighestColumn();

        //获取总行数
        $allRow         = $currentSheet->getHighestRow();
        $data           = array();
        //循环获取表中的数据，$currentRow表示当前行，从哪行开始读取数据，索引值从0开始
        for($currentRow = 2; $currentRow <= $allRow; $currentRow++){
            //从哪列开始，A表示第一列
            for($currentColumn='A';$currentColumn<=$allColumn;$currentColumn++){
                //数据坐标
                $address = $currentColumn . $currentRow;
                //读取到的数据，保存到数组$arr中
                $cell = $currentSheet->getCell($address)->getValue();

                $data[$currentRow][$currentColumn] = $cell;
            }
        }

        return $data;
    }
}