<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class singleModel extends Model
{
    
    public static function call_procedure($procName, $parameters = null, $isExecute = false) {
	
	    $syntax = '';
	    for ($i = 0; $i < count($parameters); $i++) {
	        $syntax .= (!empty($syntax) ? ',' : '') . '?';
	    }
	    $syntax = 'CALL ' . $procName . '(' . $syntax . ');';

	    $pdo = DB::connection()->getPdo();
	    $pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, true);
	    $stmt = $pdo->prepare($syntax,[\PDO::ATTR_CURSOR=>\PDO::CURSOR_SCROLL]);
	    for ($i = 0; $i < count($parameters); $i++) {
	        $stmt->bindValue((1 + $i), $parameters[$i]);
	    }
	    $exec = $stmt->execute();
	    if (!$exec) return $pdo->errorInfo();
	    if ($isExecute) return $exec;

	    $results = [];
	    do {
	        try {
	            $results[] = $stmt->fetchAll(\PDO::FETCH_OBJ);
	        } catch (\Exception $ex) {

	        }
	    } while ($stmt->nextRowset());


		
	    if (2 === count($results)) return $results[0];
	    return $results;
		

		
   }

   public static function callRaw($procName, $parameters = null, $isExecute = false) {
	
	$syntax = '';
	for ($i = 0; $i < count($parameters); $i++) {
		$syntax .= (!empty($syntax) ? ',' : '') . '?';
	}
	$syntax = 'CALL ' . $procName . '(' . $syntax . ');';

	$pdo = DB::connection()->getPdo();
	$pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, true);
	$stmt = $pdo->prepare($syntax,[\PDO::ATTR_CURSOR=>\PDO::CURSOR_SCROLL]);
	for ($i = 0; $i < count($parameters); $i++) {
		$stmt->bindValue((1 + $i), $parameters[$i]);
	}
	$exec = $stmt->execute();
	if (!$exec) return $pdo->errorInfo();
	if ($isExecute) return $exec;

	$results = [];
	do {
		try {
			$results[] = $stmt->fetchAll(\PDO::FETCH_OBJ);
		} catch (\Exception $ex) {

		}
	} while ($stmt->nextRowset());

	if (2 === count($results)) return $results[0];
	return $results;
	}


	public static function upcoming_exam_widget(){
            $parameter                    = array();
            $data['upcoming_exams']       = singlemodel::call_procedure('proc_widget_upcoming_exam_data', $parameter);
            return view('v4/upcoming_widget',$data);
    }

	public static function upcoming_exam_widget_v5(){
		$parameter                    = array();
		$data['upcoming_exams']       = singlemodel::call_procedure('proc_widget_upcoming_exam_data', $parameter);
		return view('upcoming_widget',$data);
   	 }

		public static function upcoming_exam_widget_v5_amp(){
			$parameter                    = array();
			$data['upcoming_exams']       = singlemodel::call_procedure('proc_widget_upcoming_exam_data', $parameter);
			return view('upcoming_widget_amp',$data);
			}


		public static function pdf_watermark($file , $watermark_text,$pdf_name){
			// Source file and watermark config 
			//$file = '/var/www/html/ixambee.com/public/mocktest_pdf/4ab6875e083510f7935e0ac23e2b250eixamBee_Free_MockTest_Pdf_AFCAT.pdf'; 
			//$text = 'Neeraj 9992812047'; 
			$text           = $watermark_text;
			// Text font settings 
			$name 			= uniqid(); 
			$font_size 		= 5; 
			$opacity 		= 10; 
			$ts 			= explode("\n", $text); 
			$width 			= 0; 
			foreach($ts as $k=>$string){ 
				$width = max($width, strlen($string)); 
			} 
			$width  		= imagefontwidth($font_size)*$width; 
			$height 		= imagefontheight($font_size)*count($ts); 
			$el		 		= imagefontheight($font_size); 
			$em 			= imagefontwidth($font_size); 
			$img 			= imagecreatetruecolor($width, $height); 
			
			// Background color 
			$bg 			= imagecolorallocate($img, 255, 255, 255); 
			imagefilledrectangle($img, 0, 0, $width, $height, $bg); 
			
			// Font color settings 
			$color 			= imagecolorallocate($img, 23,70,140); 
			foreach($ts as $k=>$string){ 
				$len 		= strlen($string);
				$ypos 		= 0; 
				for($i=0;$i<$len;$i++){ 
					$xpos 	= $i * $em; 
					$ypos 	= $k * $el; 
					imagechar($img, $font_size, $xpos, $ypos, $string, $color); 
					//imagecharup($img,$font_size,0,$ypos,$string,$color);
					//imagestringup($img,$font_size,  $xpos, $ypos, $string, $color);
					$string = substr($string, 1);       
				} 
			} 

			imagecolortransparent($img, $bg); 
			$blank 	= imagecreatetruecolor($width, $height); 
			$tbg 	= imagecolorallocate($blank, 255, 255, 255); 
			imagefilledrectangle($blank, 0, 0, $width, $height, $tbg); 
			imagecolortransparent($blank, $tbg); 
			$op 	= !empty($opacity)?$opacity:100; 
			if ( ($op < 0) OR ($op >100) ){ 
				$op = 100; 
			} 
			
			// Create watermark image 
			imagecopymerge($blank, $img, 0, 0, 0, 0, $width, $height, $op); 
			imagepng($blank, $name.".png"); 
			
			// Set source PDF file 
			$pdf 	= new Fpdi(); 
			if(file_exists($file)){ 
				$pagecount = $pdf->setSourceFile($file); 
			}else{ 
				die('Source PDF not found!'); 
			} 
			
			// Add watermark to PDF pages 
			
			for($i=1;$i<=$pagecount;$i++){ 
				$tpl 	= $pdf->importPage($i); 
				$size 	= $pdf->getTemplateSize($tpl); 
				//pp($size);
				$pdf->addPage(); 
				$pdf->useTemplate($tpl, 1, 1, $size['width'], $size['height'], TRUE); 
				//Put the watermark 
				$xxx_final = ($size['width']-150); 
				$yyy_final = ($size['height']-130);
				$orientation  = 'L';
				//$this->RotatedText(100,60,$text,45);
				$imageURL = 'https://www.ixambee.com/v5/assets/images/blue_logo.png'; 
				//$pdf->Image($imageURL, $xxx_final, $yyy_final, 0, 0, 'png'); 
				$pdf->Image($name.'.png',$xxx_final+20, $yyy_final+80, 0, 0, 'png'); 
				$pdf->Image($name.'.png',$xxx_final+40, $yyy_final+110, 0, 0, 'png'); 
				$pdf->Image($name.'.png',$xxx_final+50, $yyy_final+150, 0, 0, 'png'); 
				$pdf->Image($name.'.png',$xxx_final-30, $yyy_final-50, 0, 0, 'png'); 
				$pdf->Image($name.'.png',$xxx_final+35, $yyy_final-110, 0, 0, 'png'); 
				$pdf->Image($name.'.png',$xxx_final+40, $yyy_final-148, 0, 0, 'png'); 
			}
			
			@unlink($name.'.png'); 
			
			// preview pdf 
			$pdf->Output();

			// Output PDF with watermark 
			// $pdf->Output('D', $pdf_name);

	}
}
