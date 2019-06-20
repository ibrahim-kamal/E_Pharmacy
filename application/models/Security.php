<?php
class security extends CI_Model {

	public function Hide($pass)
	{
		$password=str_split($pass,1);
		$change =array(
			"a"=>"qwewiu",
			"b"=>"asdewr",
			"c"=>"zxcfgt",
			"d"=>"werbvq",
			"e"=>"sdffgv",
			"f"=>"xcvase",
			"g"=>"ertdsf",
			"h"=>"dfgcvy",
			"i"=>"cvbnks",
			"j"=>"rtysfd",
			"k"=>"fghdsf",
			"l"=>"vbncat",
			"m"=>"poioaw",
			"n"=>"lkjmiu",
			"o"=>"mnbxcb",
			"p"=>"oiuort",
			"q"=>"kjhwab",
			"r"=>"nbvasd",
			"s"=>"guwdsa",
			"t"=>"keaasd",
			"u"=>"myvxsg",
			"v"=>"mtxdfg",
			"w"=>"iawtfd",
			"x"=>"merfxr",
			"y"=>"qcbcxq",
			"z"=>"aushfs",
			"1"=>"kabkab",
			"2"=>"nbduds",
			"3"=>"udsnbd",
			"4"=>"kedked",
			"5"=>"mygmfg",
			"6"=>"mfgmyg",
			"7"=>"ifdrfr",
			"8"=>"rfrifd",
			"9"=>"cbcshf",
			"0"=>"shfcbc",
		);
		try{				
			foreach ($password as $key => $value) {
				$password[$key] = $change[$value];
			}
			$pass = join("",$password);
			#echo $pass;
			return $pass;
		}
		catch(Exception $e)
		{
			return false;
		}
	}
	public function Show($pass)
	{
		$password=str_split($pass,6);
		$change =array(
			"qwewiu"=>"a",
			"asdewr"=>"b",
			"zxcfgt"=>"c",
			"werbvq"=>"d",
			"sdffgv"=>"e",
			"xcvase"=>"f",
			"ertdsf"=>"g",
			"dfgcvy"=>"h",
			"cvbnks"=>"i",
			"rtysfd"=>"j",
			"fghdsf"=>"k",
			"vbncat"=>"l",
			"poioaw"=>"m",
			"lkjmiu"=>"n",
			"mnbxcb"=>"o",
			"oiuort"=>"p",
			"kjhwab"=>"q",
			"nbvasd"=>"r",
			"guwdsa"=>"s",
			"keaasd"=>"t",
			"myvxsg"=>"u",
			"mtxdfg"=>"v",
			"iawtfd"=>"w",
			"merfxr"=>"x",
			"qcbcxq"=>"y",
			"aushfs"=>"z",
			"kabkab"=>"1",
			"nbduds"=>"2",
			"udsnbd"=>"3",
			"kedked"=>"4",
			"mygmfg"=>"5",
			"mfgmyg"=>"6",
			"ifdrfr"=>"7",
			"rfrifd"=>"8",
			"cbcshf"=>"9",
			"shfcbc"=>"0",
		);
		try{
			foreach ($password as $key => $value) {
				$password[$key] = $change[$value];
			}
			$pass = join("",$password);
			#echo $pass;
			return $pass;
		}
		catch(Exception $e)
		{
			return false;
		}
		
	}



	public function hideSSN($SSN,$ROLE)
	{
		if($ROLE ==0){
		$SSN=str_split($SSN,1);
		$change =array("1"=>"kab",
					   "2"=>"nbd",
					   "3"=>"uds",
					   "4"=>"ked",
					   "5"=>"myg",
					   "6"=>"mfg",
					   "7"=>"ifd",
					   "8"=>"rfr",
					   "9"=>"cbc",
					   "0"=>"shf",
					);
		foreach ($SSN as $key => $value) {
			$SSN[$key] = $change[$value];
		}
		$SSN = join("",$SSN);
		return $SSN;
		}
		else
		{
			$SSN=str_split($SSN,3);
			$change =array("kab"=>"1",
					   "nbd"=>"2",
					   "uds"=>"3",
					   "ked"=>"4",
					   "myg"=>"5",
					   "mfg"=>"6",
					   "ifd"=>"7",
					   "rfr"=>"8",
					   "cbc"=>"9",
					   "shf"=>"0",
					);
			foreach ($SSN as $key => $value) {
				$SSN[$key] = $change[$value];
			}
			$SSN = join("",$SSN);
			return $SSN;
		}
	}


	public function encode($word)
	{
		return $this->Hide($this->Hide($this->Hide($word)));
	}

	public function decode($word)
	{
		return $this->Show($this->Show($this->Show($word)));
	}
}

?>	