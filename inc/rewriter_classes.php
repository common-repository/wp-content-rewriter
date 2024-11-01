<?php
class wp_article_rewriter{

function rewrite_content($content){
		
		preg_match_all("/<[^<>]+>/is",$article,$matches,PREG_PATTERN_ORDER);
		$htmlfounds=$matches[0];
		
		$pattern="\[.*?\]";
		preg_match_all("/".$pattern."/s",$article,$matches2,PREG_PATTERN_ORDER);
		$shortcodes=$matches2[0];
		
		
		$htmlfounds=array_merge($htmlfounds,$shortcodes);
		
		foreach($htmlfounds as $htmlfound){
			$content=str_replace($htmlfound,'('.md5($htmlfound).')',$content);
		}
		
		$dictonary = file(dirname(__FILE__)  .'/dictonary.dat');
		$founds=array();
		
		
		foreach($dictonary as $line){
			
			  
			$synonyms=explode('|',$line);
			foreach($synonyms as $word){
				if(trim($word) != ''){
					
					$word=str_replace('/','\/',$word);
					
					if(preg_match('/\b'. $word .'\b/i', $content)) {					  
					  $founds[md5($word)]=str_replace(array("\n", "\r"), '',$line);
					  $content=preg_replace('/\b'.$word.'\b/i',md5($word),$content);
					  
					}
				}
			}
			
		}	
		
		foreach($htmlfounds as $htmlfound){
			$content=str_replace('('.md5($htmlfound).')',$htmlfound,$content);
		}
		
		if(count($founds) !=0){
			foreach ($founds as $key=>$val){
				$content=str_replace($key,'{'.$val.'}',$content);
			}
		}
		return $content;
	}
	
	
	function rebuild_content($rewrite_content){
			 $z=-1;
	      $input = $this->bracketArray($rewrite_content);
	      for($i=0; $i<count($input);$i++){
	         for($x=0; $x<count($input[$i]);$x++) {
	            if(!$input[$i][$x]==""||"/n"){
	               $z++;
	               if(strstr($input[$i][$x], "|")){
	                  $out = explode("|", $input[$i][$x]);
	                  $output[$z] = '<span style="color:red">'.$out[rand(0, count($out)-1)].'</span>';
	               } else {
	                  $output[$z] = $input[$i][$x];
	               }
	            }
	         }
	      }
	      $res='';
	      for($i=0;$i<count($output);$i++){
	        $res .=  $output[$i];
	      }
	      return $res;
		
		
		}
		
		
		
	function bracketArray($str, $view=false)
	   {
	      @$string = split("{", $str);
	      for($i=0;$i<count($string);$i++){
	         @$_string[$i] = split("}", $string[$i]);
	      }
	      if($view){
	         $this->printArray($_string);
	      }
	      return $_string;
	   }
	   
	   function cleanArray($array){
	      for($i=0;$i<count($array);$i++){
	         if($array[$i]!=""){
	            $cleanArray[$i] = $array[$i];
	         }
	      }
	      return $cleanArray;
	   }
	   
	   function printArray($array)
	   {
	      echo '<pre>';
	      print_r($array);
	      echo '</pre>';
	   }
}

?>
