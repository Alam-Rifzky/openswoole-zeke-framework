<?php
class Fileutil{
    public DateTime $waktu;
    public function __construct(){
		$this->waktu = new DateTime("now", new DateTimeZone('Asia/Jakarta'));
	}

    public function WriteLog($logPath,$usersession,$logtext,$debugMode='DEBUG'){
		
        if (!empty($usersession)||$usersession!='') {
            $ifolder = $logPath.date('Ymd');
            $ifile = $usersession.'_'.date('dmY').'_session.log';
            $this->CreateFile($ifolder,$ifile);
            
            // echo $ifolder;
            $completepath = $ifolder.'/'.$ifile;
            if ($this->CheckFile($completepath)) {
                $this->AppendText($completepath,$this->waktu->format('Y-m-d H:i:s').' ['.$debugMode.'] '.$logtext);    
            }
        }
	}

    public function CreateFile($path,$filename,$useTs=1){
        if (!file_exists($path)){
            mkdir($path, 0777, true);
        }
        
        $ifilename = $path.'/'.$filename;

        if (!file_exists($ifilename)) {
            $myfile = fopen($ifilename, "w");
            if ($useTs==1) {
                $txt = "Created on ".date('Y-m-d H:i:s')."\n";
                fwrite($myfile, $txt);
            }
            fclose($myfile);
        }
    }

    public function AppendText($pathfilename,$mytext){
        if (!file_exists($pathfilename)) {
            return;
        }

        if (file_exists($pathfilename)) {
            $fp = fopen($pathfilename, 'a');
            fwrite($fp, $mytext."\n");  
            fclose($fp);	
        }
    }

    public function CheckFile($path){
	if (file_exists($path)) {
		return true;
	} else {
		return false;
	}
}

}