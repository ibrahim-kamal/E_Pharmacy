<?php
class system extends CI_Model {
	public function saveimg($type,$file){
		$extension = array("png","jpeg","jpg");
		$img  = explode('.', $file['img']['name']);
		if(count($img) == 2){
			if(in_array($img[1], $extension)){
				$name = $type."_".$img[0]."0.".$img[1];
				$path = "style/images/".$name;
				$i = 0;
				while(file_exists($path)){
					$i++;
					$name = $type."_".$img[0].$i.".".$img[1];
					$path = "style/images/".$name;
				}
				$img = file_get_contents($file['img']['tmp_name']);
				file_put_contents($path,$img);
				return $name;
			}
			else{
				return $type.'.jpg';
			}
			
		}
		else{
			return $type.'.jpg';
		}
		
	}
}
?>