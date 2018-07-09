<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2016/5/23
 * Time: 11:38
 */

class Excel {
    private $objPHPExcel;
    private $objWriter;
    private $filename;
    public function __construct($filename){

        $this->filename = $filename;
        include_once '/PHPExcel.php';
        include '/PHPExcel/Writer/Excel2007.php';
        //include_once './plugins/excel/PhpExcel/Writer/Excel5.php';
        include_once './PhpExcel/IOFactory.php';
        $this->objPHPExcel = new PHPExcel();
        $this->objWriter = new PHPExcel_Writer_Excel5($this->objPHPExcel);

        $this->objPHPExcel->getProperties()->setCreator("administrator");
        $this->objPHPExcel->getProperties()->setLastModifiedBy("administrator");
        $this->objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");
        $this->objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
        $this->objPHPExcel->getProperties()->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.");
        $this->objPHPExcel->getProperties()->setKeywords("office 2007 openxml php");
        $this->objPHPExcel->getProperties()->setCategory("Test result file");

    }
    public function create_sheet($i,$title){
        $this->objPHPExcel->createSheet();
        $this->objPHPExcel->getSheet($i)->setTitle($title);
        $this->objPHPExcel->setActiveSheetIndex($i);
        $objActSheet = $this->objPHPExcel->getActiveSheet();
        return $objActSheet;
    }
    public function make_cell_no_merge($objActSheet,$begin_col, $end_col, $begin_row, $end_row, $title,$horizontal='center', $font_size = 9, $wd = 8, $bold = true, $wrap = false)
    {
        $cell = $begin_col . $begin_row;
        $cel_begin = $begin_col . $begin_row;
        $cel_end = $end_col . $end_row;
        $objActSheet->getColumnDimension($cell)->setWidth($wd);

        if($title)
        {
            $title = $this->convertUTF8($title);
        }
        //$objActSheet->mergeCells( 'A37:G37');
        $objActSheet->mergeCells($cel_begin . ':' . $cel_end);
        $objActSheet->setCellValue($cell ,$title);
        $objStyle = $objActSheet->getStyle($cell);
        $objStyle->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objStyle->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        if($horizontal=='left'){
            $objStyle->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objStyle->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        }

        $objFont = $objStyle->getFont();
        $objFont->setName('宋体');
        $objFont->setSize($font_size);
        $objFont->setBold($bold);
        $objStyle->getAlignment()->setWrapText($wrap);//自动换行

//        if($border)
//        {
//            $objStyle->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
//            $objStyle->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
//            $objStyle->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
//            $objStyle->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
//        }
    }
    public function make_merge_column($objActSheet, $begin_col, $end_col, $begin_row, $end_row, $title, $font_size = 10,$wd = 10,$height=28, $bold = false,  $fontName='宋体',$wrap = false, $border = true,$horizontal='center')
    {
        //$objActSheet = $objPHPExcel->getActiveSheet();
        $cel_begin = $begin_col . $begin_row;
        $cel_end = $end_col . $end_row;

        $objActSheet->getColumnDimension($begin_col)->setWidth($wd);
        $objActSheet->getRowDimension($begin_row)->setRowHeight($height);

        $objActSheet->mergeCells($cel_begin . ':' . $cel_end);

        $objActSheet->setCellValue($cel_begin ,$this->convertUTF8($title));
        $objStyle = $objActSheet->getStyle($cel_begin);
        $objStyle->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        $objStyle->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        if($horizontal=='left'){
            $objStyle->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objStyle->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        }
        $objFont = $objStyle->getFont();
        $objFont->setName($fontName);
        $objFont->setSize($font_size);
        $objFont->setBold($bold);
        $objStyle->getAlignment()->setWrapText($wrap);//自动换行
        if($border)
        {
            $objActSheet->getStyle($cel_begin . ':' . $cel_end)->applyFromArray(
                array(
                    'borders' => array(
                        'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                        'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                        'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                        'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
                    )
                )

            );
        }



    }

    /**
     * 设置单元格的字体颜色
     * @author Red
     * @date
     * @param $objActSheet
     * @param $text
     * @param $col
     * @param $row
     * @param $color
     */
    public function setFontColor($objActSheet,$text,$col,$row,$color='green'){
        $objRichText = new PHPExcel_RichText();


        $objPayable = $objRichText->createTextRun($text);
        if($color=='red'){
            $e_color =  PHPExcel_Style_Color::COLOR_DARKRED;
        }elseif($color=='yellow'){
            $e_color =  PHPExcel_Style_Color::COLOR_YELLOW;
        }else{
            $e_color =  PHPExcel_Style_Color::COLOR_DARKGREEN;
        }
        $objPayable->getFont()->setColor( new PHPExcel_Style_Color($e_color ) );//设置颜色为绿色

        $objActSheet->setCellValue($col.$row, $objRichText);
    }
    private function convertUTF8($str)
    {
        if($str===0){return 0;}
        if(empty($str)) return '';
        $code_type = mb_detect_encoding($str, array('UTF-8', 'GBK'));

        switch($code_type)
        {
            case 'UTF-8' : //如果是utf8编码
                return $str;
                break;
            case 'GBK': //如果是gbk编码
                return  iconv('gb2312', 'utf-8', $str);
                break;
        }

    }
    public function __destruct(){
        $filename = iconv('UTF-8', 'GBK', $this->filename);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
        header('Cache-Control: max-age=0');

        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');
        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public');
        $this->objWriter->save('php://output');
    }
}