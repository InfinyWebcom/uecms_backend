<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  
require_once dirname(__FILE__) . '/fpdf/fpdf.php';
  
class PDF extends FPDF
{
	protected $B;
protected $I;
protected $U;
protected $HREF;
protected $fontList;
protected $issetfont;
protected $issetcolor;

 // function __construct()
 // {
 // parent::__construct();
 // }

function __construct($orientation='P', $unit='mm', $format='A4')
{
	//Call parent constructor
	parent::__construct($orientation,$unit,$format);
	//Initialization
	$this->B=0;
	$this->I=0;
	$this->U=0;
	$this->HREF='';
	$this->fontlist=array('arial', 'times', 'courier', 'helvetica', 'symbol');
	$this->issetfont=false;
	$this->issetcolor=false;
}




 function SetDash($black=null, $white=null)
	{
		if($black!==null)
			$s=sprintf('[%.3F %.3F] 0 d',$black*$this->k,$white*$this->k);
		else
			$s='[] 0 d';
		$this->_out($s);
	}

  function RoundedRect($x, $y, $w, $h, $r, $corners = '1234', $style = '')
	{
		$k = $this->k;
		$hp = $this->h;
		if($style=='F')
			$op='f';
		elseif($style=='FD' || $style=='DF')
			$op='B';
		else
			$op='S';
		$MyArc = 4/3 * (sqrt(2) - 1);
		$this->_out(sprintf('%.2F %.2F m',($x+$r)*$k,($hp-$y)*$k ));

		$xc = $x+$w-$r;
		$yc = $y+$r;
		$this->_out(sprintf('%.2F %.2F l', $xc*$k,($hp-$y)*$k ));
		if (strpos($corners, '2')===false)
			$this->_out(sprintf('%.2F %.2F l', ($x+$w)*$k,($hp-$y)*$k ));
		else
			$this->_Arc($xc + $r*$MyArc, $yc - $r, $xc + $r, $yc - $r*$MyArc, $xc + $r, $yc);

		$xc = $x+$w-$r;
		$yc = $y+$h-$r;
		$this->_out(sprintf('%.2F %.2F l',($x+$w)*$k,($hp-$yc)*$k));
		if (strpos($corners, '3')===false)
			$this->_out(sprintf('%.2F %.2F l',($x+$w)*$k,($hp-($y+$h))*$k));
		else
			$this->_Arc($xc + $r, $yc + $r*$MyArc, $xc + $r*$MyArc, $yc + $r, $xc, $yc + $r);

		$xc = $x+$r;
		$yc = $y+$h-$r;
		$this->_out(sprintf('%.2F %.2F l',$xc*$k,($hp-($y+$h))*$k));
		if (strpos($corners, '4')===false)
			$this->_out(sprintf('%.2F %.2F l',($x)*$k,($hp-($y+$h))*$k));
		else
			$this->_Arc($xc - $r*$MyArc, $yc + $r, $xc - $r, $yc + $r*$MyArc, $xc - $r, $yc);

		$xc = $x+$r ;
		$yc = $y+$r;
		$this->_out(sprintf('%.2F %.2F l',($x)*$k,($hp-$yc)*$k ));
		if (strpos($corners, '1')===false)
		{
			$this->_out(sprintf('%.2F %.2F l',($x)*$k,($hp-$y)*$k ));
			$this->_out(sprintf('%.2F %.2F l',($x+$r)*$k,($hp-$y)*$k ));
		}
		else
			$this->_Arc($xc - $r, $yc - $r*$MyArc, $xc - $r*$MyArc, $yc - $r, $xc, $yc - $r);
		$this->_out($op);
	}

	function _Arc($x1, $y1, $x2, $y2, $x3, $y3)
	{
		$h = $this->h;
		$this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c ', $x1*$this->k, ($h-$y1)*$this->k,
			$x2*$this->k, ($h-$y2)*$this->k, $x3*$this->k, ($h-$y3)*$this->k));
	}

	function load($param=NULL)

    {

        include_once APPPATH.'/third_party/mpdf/mpdf.php';

        if ($params == NULL)

        {

            $param = '"en-GB-x","A4","","",10,10,10,10,6,3';

        }

        return new mPDF($param);

    }



function hex2dec($couleur = "#000000"){
	$R = substr($couleur, 1, 2);
	$rouge = hexdec($R);
	$V = substr($couleur, 3, 2);
	$vert = hexdec($V);
	$B = substr($couleur, 5, 2);
	$bleu = hexdec($B);
	$tbl_couleur = array();
	$tbl_couleur['R']=$rouge;
	$tbl_couleur['V']=$vert;
	$tbl_couleur['B']=$bleu;
	return $tbl_couleur;
}

//conversion pixel -> millimeter at 72 dpi
function px2mm($px){
	return $px*25.4/72;
}

function txtentities($html){
	$trans = get_html_translation_table(HTML_ENTITIES);
	$trans = array_flip($trans);
	return strtr($html, $trans);
}
function WriteHTML($html)
{
	// pr($html);exit;

// pr($html);exit;
	//HTML parser
	 // $html=strip_tags($html,"<b><u><i><a><img><p><br><strong><em><font><tr><blockquote>"); //supprime tous les tags sauf ceux reconnus
  		$html=str_replace("\n",' ',$html); //remplace retour à la ligne par un espace

  	/*$html = str_replace( '<ul>', "" , $html );
	$html = str_replace( '<li>', "&#8226;" , $html );
	$html = str_replace( '</li>', "\n" , $html );
	$html = str_replace( '</ul>', "" , $html );*/
	// $html = "<ul><li>Coffee</li><li>Tea</li><li>Milk</li></ul>";
	// pr($html);exit;
	// if(preg_match('<ul>', $html)){
		// echo "vd";exit;
		$html = str_replace( '<ul>', "" , $html );
		$html = str_replace( '<li>', "\n\n<b> > </b>" , $html );
		$html = str_replace( '</li>', "\n" , $html );
		$html = str_replace( '</ul>', "" , $html );
		$html = str_replace( '<ol>', "" , $html );
		$html = str_replace( '</ol>', "" , $html );
	// }

	
 		$a=preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE); //éclate la chaîne avec les balises
	 
// 	$column_width = ($this->GetPageWidth()-30)/2;
// 	// $this->MultiCellBlt($column_width,6,chr(149),$html);


// 	$ab = explode("<li>", $html);
// 	// pr($ab);
// 	$uls = preg_match_all('/<ul>(.*?)<\/ul>/s', $html, $matches);
// 	// print_r($matches[1]);
// 	preg_match_all('/<li>(.*?)<\/li>/s', $matches[1][0], $lis);
// 	foreach ($lis as $key => $value) {
// 		// echo "<br>1.";
// 		print_r($value);
// 		$array = $value;
// 		$column_width = $this->w-30;

// // $this->MultiCellBlt($column_width,6,chr(149),$value);

// 	}exit;
// pr($array);exit;
	/*$column_width = $this->w-30;

$this->MultiCellBlt($column_width,6,chr(149),$array);*/
	// $newarray = $this->MultiCellBltArray($column_width-$this->x,6,$array);

	// pr($newarray);



	// // pr($value);exit;
	// // exit;
	// $ab = explode("<li>", $html);
	// // pr($ab);
	//  // $column_width = $this->w-30;

	// $newArray = array();

	// foreach ($ab as $key => $value) {
	// 	// pr($value);
		
	// 	// pr($value);exit;
	// 	if(preg_match('<li>', $value)){
	// 		$array =array();
	// 		// echo "dsf";
	// 		$array = explode('</li>', $value);
	// 		$newArray[] = $array[0];
			
	// 		$temp = $array[1];
	// 		// pr($array[1]);
	// 		//  pr($array[0]);exit;
	// 		if(!empty($temp)){
	// 			$newArray[] = $array[1];
	// 		}



	// 	}else{
	// 		$newArray[] = $value;
	// 	}
			
			
			
			
	// // 		//	
	// // }
 // pr($newArray);exit;


	// foreach ($newArray as $key1 => $value1) {
	// 	if(preg_match('<li>', $value1)){

			
	// 		$key = array_search('<li>', $value1);
	// 		pr($key);exit;

	// 	}
	// }
	//   pr($key);
	//   pr($newArray);exit;

	// $a=preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE); //éclate la chaîne avec les balises


	// pr($array);exit;
	// pr($newab);exit;
	// pr($ab);exit;
	// // $b = explode("</li>", $html);
	//   pr($ab);exit;
	//  $column_width = $this->w-30;
	//  $this->MultiCellBltArray($column_width-$this->x,6,$ab);
	// $html=strip_tags($html,"<b><u><i><a><img><p><br><strong><em><font><tr><blockquote><h2><small><ul><li><ol>");
	// $a=str_replace("\n",' ',$html); //remplace retour à la ligne par un espace
	 
	// $this->PutLink($a); //éclate la chaîne avec les balises
 //    pr($html);exit;
	// if($a['13'] == 'ol' || $a['15'] == 'ul'){
	// 	$column_width = ($this->GetPageWidth()-30)/2;

 //    	$this->MultiCellBlt($column_width,6,chr(149),$a);
	// }
	// $this->MultiCellBlt($column_width,6,chr(149),$a);
	// if(in_array('ul',$a )){
	// 	 $key = array_search ('ul', $a);
	// 	 $key2 = array_search ('/ul', $a);
	// 	 // pr($key2);
	// 	 //  pr($key);exit;
	// 	$column_width = ($this->GetPageWidth()-30)/2;

 //    	$this->MultiCellBlt($column_width,6,chr(149),$key);
	// }

	foreach($a as $i=>$e)
	{
		// pr($i);exit;

		if($i%2==0)
		{


			//Text
			// if($this->HREF)
	// 			pr($HREF);
	// pr($html);exit;
				$this->PutLink($e);


			// else
			// 	echo "sd";exit;
			// 	$this->Write(5,stripslashes(txtentities($e)));
		}
		else
		{
			//Tag
			if($e[0]=='/')
				$this->CloseTag(strtoupper(substr($e,1)));
			else
			{
				//Extract attributes
				$a2=explode(' ',$e);
				$tag=strtoupper(array_shift($a2));
				$attr=array();
				foreach($a2 as $v)
				{
					if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
						$attr[strtoupper($a3[1])]=$a3[2];
				}
				$this->OpenTag($tag,$attr);
			}
		}
	}

}

function OpenTag($tag, $attr)
{
	//Opening tag
	switch($tag){
		case 'STRONG':
			$this->SetStyle('B',true);
			break;
		case 'EM':
			$this->SetStyle('I',true);
			break;
		case 'B':
		case 'I':
		case 'U':
			$this->SetStyle($tag,true);
			break;
		case 'A':
			$this->HREF=$attr['HREF'];
			break;
		case 'IMG':
			if(isset($attr['SRC']) && (isset($attr['WIDTH']) || isset($attr['HEIGHT']))) {
				if(!isset($attr['WIDTH']))
					$attr['WIDTH'] = 0;
				if(!isset($attr['HEIGHT']))
					$attr['HEIGHT'] = 0;
				$this->Image($attr['SRC'], $this->GetX(), $this->GetY(), px2mm($attr['WIDTH']), px2mm($attr['HEIGHT']));
			}
			break;
		case 'TR':
		case 'BLOCKQUOTE':
		case 'BR':
			$this->Ln(5);
			break;
		case 'P':
			$this->Ln(10);
			break;
		case 'FONT':
			if (isset($attr['COLOR']) && $attr['COLOR']!='') {
				$coul=hex2dec($attr['COLOR']);
				$this->SetTextColor($coul['R'],$coul['V'],$coul['B']);
				$this->issetcolor=true;
			}
			if (isset($attr['FACE']) && in_array(strtolower($attr['FACE']), $this->fontlist)) {
				$this->SetFont(strtolower($attr['FACE']));
				$this->issetfont=true;
			}
			break;
	}
}

function CloseTag($tag)
{
	//Closing tag
	if($tag=='STRONG')
		$tag='B';
	if($tag=='EM')
		$tag='I';
	if($tag=='B' || $tag=='I' || $tag=='U')
		$this->SetStyle($tag,false);
	if($tag=='A')
		$this->HREF='';
	if($tag=='FONT'){
		if ($this->issetcolor==true) {
			$this->SetTextColor(0);
		}
		if ($this->issetfont) {
			$this->SetFont('arial');
			$this->issetfont=false;
		}
	}
}

function SetStyle($tag, $enable)
{
	//Modify style and select corresponding font
	$this->$tag+=($enable ? 1 : -1);
	$style='';
	foreach(array('B','I','U') as $s)
	{
		if($this->$s>0)
			$style.=$s;
	}
	$this->SetFont('',$style);
}

function PutLink($data)
{
	// pr($data);exit;
	//Put a hyperlink
	// $this->SetTextColor(0,0,255);
	// $this->SetStyle('U',true);
	$this->Write(5,$data);
	$this->SetStyle('a',false);
	 // $this->MultiCellBlt($data);

	$this->SetTextColor(0);
	// echo "ds";exit;
}
 // function MultiCellBlt($w, $h, $blt, $txt, $border=0, $align='J', $fill=false)
 //    {
 //        //Get bullet width including margins
 //        $blt_width = $this->GetStringWidth($blt)+$this->cMargin*2;

 //        //Save x
 //        $bak_x = $this->x;

 //        //Output bullet
 //        $this->Cell($blt_width,$h,$blt,0,'',$fill);

 //        //Output text
 //        $this->MultiCell($w-$blt_width,$h,$txt,$border,$align,$fill);

 //        //Restore x
 //        $this->x = $bak_x;
 //    }

	 function MultiCellBltArray($w, $h, $blt_array, $border=0, $align='J', $fill=false)
    {
    	//pr($blt_array);exit;
        if (!is_array($blt_array))
        {
            die('MultiCellBltArray requires an array with the following keys: bullet,margin,text,indent,spacer');
            exit;
        }
                
        //Save x
        $blt_array['text'] = $blt_array;
        $blt_array['bullet'] =  chr(149);
        $blt_array['margin'] = ' ';
       
         $bak_x = $this->x;
        // pr($blt_array);
        // pr(count($blt_array));exit;
        for ($i=0; $i<count($blt_array['text']); $i++)
        {
            //Get bullet width including margin
            $blt_width = $this->GetStringWidth($blt_array['bullet'] . $blt_array['margin'])+$this->cMargin*2;
            
            // SetX
            // $this->SetX($bak_x);
            
           
            
            //Output bullet
            $this->Cell($blt_width,$h,$blt_array['bullet'] . $blt_array['margin']);
            // $new1 = strip_tags($blt_array['text'],'<b><u><i>');
            //Output text
            // $this->MultiCell($w-$blt_width,$h,$blt_array['text'][$i]);
             $this->MultiCell($w-$blt_width,$h,strip_tags($blt_array['text'][$i]));

            
            
            //Insert a spacer between items if not the last item
          
            
            //Increment bullet if it's a number
            if (is_numeric($blt_array['bullet']))
                $blt_array['bullet']++;
        }
         

        //Restore x
      $this->x= $bak_x;
     
    }


    function MultiCellBlt($w, $h, $blt, $txt, $border=0, $align='J', $fill=false)
    {
        //Get bullet width including margins
        $blt_width = $this->GetStringWidth($blt)+$this->cMargin*2;

        //Save x
        $bak_x = $this->x;

        //Output bullet
        $this->Cell($blt_width,$h,$blt,0,'',$fill);

        //Output text
        $ret = $this->MultiCell($w-$blt_width,$h,$txt,$border,$align,$fill);

        //Restore x
        $this->x = $bak_x;
    }


}