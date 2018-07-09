<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2009 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

namespace Com\Excel;
/**
 * Excel操作类
 * @category   Com
 * @package  Com
 * @subpackage  Excel
 * @author    luo yj
 * @version   $Id: MyExcel.class.php 2016年8月8日09:50:59
 */
class OutExcel {
    //文件名
    private $filename;
    //excel对象
    private $objPHPExcel;
    private $objWriter;
    //sheet对象
    private $objActSheet;

    /**
     * OutExcel constructor.
     * @param $filename
     */
    public function __construct($filename) {
        $this->filename = $filename;

        //引入PHPExcel
        vendor('PHPExcel.PHPExcel');
        $this->objPHPExcel = new \PHPExcel();
        $this->objWriter = new \PHPExcel_Writer_Excel5($this->objPHPExcel);
        $this->objActSheet = $this->create_sheet(0, $this->filename);

        $this->objPHPExcel->getProperties()->setCreator("administrator");
        $this->objPHPExcel->getProperties()->setLastModifiedBy("administrator");
        $this->objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");
        $this->objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
        $this->objPHPExcel->getProperties()->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.");
        $this->objPHPExcel->getProperties()->setKeywords("office 2007 openxml php");
        $this->objPHPExcel->getProperties()->setCategory("Test result file");
    }

    /**
     * 创建sheet页
     * @param $i
     * @param $title
     * @return \PHPExcel_Worksheet
     * @throws \PHPExcel_Exception
     */
    public function create_sheet($i, $title) {
        $this->objPHPExcel->createSheet();
        $this->objPHPExcel->getSheet($i)->setTitle($title);
        $this->objPHPExcel->setActiveSheetIndex($i);
        $objActSheet = $this->objPHPExcel->getActiveSheet();
        return $objActSheet;
    }

    /**
     * excel导出
     * lyj
     * @param $fileName 下载的文件名
     * @param $headArr 字段数组
     * @param $data 要导出的excel数组
     * @throws \PHPExcel_Exception
     * @throws \PHPExcel_Reader_Exception
     */
    public function out($headArr, $data) {
        //对数据进行检验
        if(empty($data) || !is_array($data)){
            die("data must be a array");
        }

        $objProps = $this->objPHPExcel->getProperties();

        //设置表格样式
        //self::setCellStyle(count($headArr), count($data));

        //设置表头
        $key = ord("A");
        foreach ($headArr as $v) {
            $colum = chr($key);
            $this->objPHPExcel->setActiveSheetIndex(0)->setCellValue($colum.'1', $v);
            $key++;
        }

        $column = 2;
        $objActSheet = $this->objPHPExcel->getActiveSheet();
        foreach ($data as $key => $rows) { //行写入
            $span = ord("A");
            foreach ($rows as $keyName=>$value) {// 列写入
                $j = chr($span);
                $objActSheet->setCellValue($j . $column, $value);
                $span++;
            }
            $column++;
        }
    }

    private function setCellStyle($fieldNum, $dataNum) {
        if (!$fieldNum or !$dataNum) {
            exit;
        }

        $start = ord('A');
        $start_clu = ord('A');

        //先最多52列，超过52列再说吧
        if ($fieldNum <= 26) {
            $columnChar = $fieldNum;
        } elseif ($fieldNum > 26 and $fieldNum <= 52) {
            $columnChar = 'A' . chr($start + $fieldNum - 27);
        }

        for ($i = 0; $i <= $dataNum; $i++) {
            //边框
            $this->objPHPExcel->getActiveSheet()->getStyle(chr($start) . ($i+1) . ':' . $columnChar . ($i+1))->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);

            for ($j = 1; $j <= $fieldNum; $j++) {
                if ($start_clu < ord('Z')) {
                    $start_clu_char = chr($start_clu);
                } elseif ($start_clu > ord('Z') and $start_clu <= 2 * ord('Z')) {
                    $start_clu_char = 'A' . chr($start_clu + $fieldNum - 27);
                }
                //居中
                $this->objPHPExcel->getActiveSheet()->getStyle($start_clu_char . $j)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->objPHPExcel->getActiveSheet()->getStyle($start_clu_char . $j)->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
            }
            $start_clu++;
        }
    }

    /**
     * 设置单元格样式
     * @param $begin_col
     * @param $end_col
     * @param $begin_row
     * @param $end_row
     * @param $title
     * @param int $font_size
     * @param int $wd
     * @param int $height
     * @param bool $bold
     * @param string $font_color
     * @param string $fontName
     * @param bool $wrap
     * @param bool $border
     * @param string $horizontal
     * @throws \PHPExcel_Exception
     */
    public function make_merge_column($begin_col, $end_col, $begin_row, $end_row, $title, $font_size = 10, $wd = 10, $height = 28, $bold = false, $font_color = '000000', $fontName = '宋体', $wrap = false, $border = true, $horizontal = 'center')
    {
        $cel_begin = $begin_col . $begin_row;
        $cel_end = $end_col . $end_row;
        //宽度
        $this->objActSheet->getColumnDimension($begin_col)->setWidth($wd);
        //高度
        $this->objActSheet->getDefaultRowDimension($begin_col)->setRowHeight($height);
        //合并单元格
        $this->objActSheet->mergeCells($cel_begin . ':' . $cel_end);
        //表格值
        $this->objActSheet->setCellValue($cel_begin ,$this->convertUTF8($title));
        $objStyle = $this->objActSheet->getStyle($cel_begin);
        //水平垂直居中
        $objStyle->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objStyle->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        if($horizontal=='left'){
            $objStyle->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objStyle->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        }
        //字体、字体大小、字体粗细、颜色
        $objFont = $objStyle->getFont();
        $objFont->setName($fontName);
        $objFont->setSize($font_size);
        $objFont->setBold($bold);
        $objFont->getColor($font_color);
        $objStyle->getAlignment()->setWrapText($wrap);//自动换行
        //边框
        if($border) {
            $this->objActSheet->getStyle($cel_begin . ':' . $cel_end)->applyFromArray(
                array(
                    'borders' => array(
                        'top' => array('style' => \PHPExcel_Style_Border::BORDER_THIN),
                        'left' => array('style' => \PHPExcel_Style_Border::BORDER_THIN),
                        'right' => array('style' => \PHPExcel_Style_Border::BORDER_THIN),
                        'bottom' => array('style' => \PHPExcel_Style_Border::BORDER_THIN)
                    )
                )
            );
        }
    }

    /**
     * 设置单元格的边框颜色
     * @param $char
     * @param $row
     * @param $rgb
     * @param $border
     */
    public function setBorderColor($char, $row, $rgb = '000000', $border = true){
        $content = $char . $row;
        $objBordersStyles = $this->objPHPExcel->getActiveSheet()->getStyle($content)->getBorders();

        $objBordersStyles->getLeft()->getColor()->setARGB($rgb);
        $objBordersStyles->getTop()->getColor()->setARGB($rgb);
        $objBordersStyles->getBottom()->getColor()->setARGB($rgb);
        $objBordersStyles->getRight()->getColor()->setARGB($rgb);

        if (!$border) {
            $objBordersStyles->getRight()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
            $objBordersStyles->getLeft()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
            $objBordersStyles->getBottom()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
            $objBordersStyles->getTop()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
        }
    }

    /**
     * 设置单元格填充色
     * lyj
     * @param $begin_col
     * @param $end_col
     * @param $begin_row
     * @param $end_row
     * @param $rgb
     */
    public function setFillColor($begin_col, $end_col, $begin_row, $end_row, $rgb) {
        $content = $begin_col . $begin_row . ':' . $end_col . $end_row;

        $this->objPHPExcel->getActiveSheet()->getStyle($content)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID);
        $this->objPHPExcel->getActiveSheet()->getStyle($content)->getFill()->getStartColor()->setARGB($rgb);
    }

    /**
     * 设置链接
     * lyj
     * @param $char //所在列
     * @param $row
     * @param $url
     * @param $urlValue
     * @throws \PHPExcel_Exception
     */
    public function setUrl($char, $row, $url, $urlValue = false) {
        $content = $char . $row;

        //是否设置单元格值为链接
        if ($urlValue) {
            $this->objPHPExcel->getActiveSheet()->setCellValue($content, $url);
        }

        //超链接地址
        $this->objPHPExcel->getActiveSheet()->getCell($content)->getHyperlink()->setUrl($url);
        //鼠标移上去链接提示
        $this->objPHPExcel->getActiveSheet()->getCell($content)->getHyperlink()->setTooltip('Navigate to website');
    }

    /**
     * 添加图片
     * lyj
     * @param $name 图片名
     * @param $description 图片描述
     * @param $path 图片路径
     * @param $ht 高度
     * @param $char 所在列
     * @param $row 行数
     * @param int $offX x轴偏移量
     * @throws \PHPExcel_Exception
     */
    public function setImage($name, $description, $path, $ht, $char, $row, $offX = 0) {
        $objDrawing = new \PHPExcel_Worksheet_Drawing();
        $objDrawing->setName($name);
        $objDrawing->setDescription($description);
        $objDrawing->setPath($path);
        $objDrawing->setHeight($ht);
        $objDrawing->setCoordinates($char . $row);
        $objDrawing->setOffsetX($offX);
        $objDrawing->setWorksheet($this->objPHPExcel->getActiveSheet());
    }

    /**
     * 设置字符串编码
     * @param $str
     * @return int|string
     */
    private function convertUTF8($str)
    {
        if($str===0){return 0;}
        if(empty($str)) return '';
        $code_type = mb_detect_encoding($str, array('UTF-8', 'GBK'));

        switch($code_type) {
            case 'UTF-8' : //如果是utf8编码
                return $str;
                break;
            case 'GBK': //如果是gbk编码
                return  iconv('gb2312', 'utf-8', $str);
                break;
        }
    }

    /**
     * @throws \PHPExcel_Exception
     * @throws \PHPExcel_Reader_Exception
     */
    public function __destruct() {
        //var_dump($this->filename);die;
        $fileName = $this->filename;
        $date = date("Y_m_d",time());
        $fileName .= "_{$date}.xls";
        $fileName = iconv("utf-8", "gb2312", $fileName);

        ob_end_clean(); //清除缓冲区,避免乱码
        ob_start(); // Added by me

        //重命名表
        $this->objPHPExcel->getActiveSheet()->setTitle($fileName);
        //设置活动单指数到第一个表,所以Excel打开这是第一个表
        $this->objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename=\"$fileName\"");
        header('Cache-Control: max-age=0');

        $objWriter = \PHPExcel_IOFactory::createWriter($this->objPHPExcel, 'Excel5');
        $objWriter->save('php://output'); //文件通过浏览器下载
        exit;
    }

}