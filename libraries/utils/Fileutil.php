<?php
class Fileutil{
    public DateTime $waktu;
    
    public function __construct(){
        $this->waktu = new DateTime("now", new DateTimeZone('Asia/Jakarta'));
    }

    public function WriteLog($logPath, $usersession, $logtext, $debugMode='DEBUG'){
        if (empty($usersession) || $usersession == '') {
            return;
        }
        
        $ifolder = $logPath . date('Ymd');
        $ifile = $usersession . '_' . date('dmY') . '_session.log';
        
        // Create directory and file if needed
        $this->CreateFile($ifolder, $ifile);
        
        $completepath = $ifolder . '/' . $ifile;
        
        // Use coroutine-safe file check and append
        if ($this->CheckFile($completepath)) {
            $logEntry = $this->waktu->format('Y-m-d H:i:s') . ' [' . $debugMode . '] ' . $logtext . "\n";
            $this->AppendText($completepath, $logEntry);
        }
    }

    public function CreateFile($path, $filename, $useTs=1){
        // Use coroutine-safe directory creation
        if (!$this->CheckDirectory($path)) {
            // Fallback to regular mkdir (will be hooked by SWOOLE_HOOK_ALL)
            @mkdir($path, 0777, true);
        }
        
        $ifilename = $path . '/' . $filename;

        // Check if file exists using coroutine-safe method
        if (!$this->CheckFile($ifilename)) {
            $txt = '';
            if ($useTs == 1) {
                $txt = "Created on " . date('Y-m-d H:i:s') . "\n";
            }
            
            // Use OpenSwoole's coroutine-safe writeFile
            $result = \OpenSwoole\Coroutine\System::writeFile($ifilename, $txt);
            
            if ($result === false) {
                // Log error or handle failure
                error_log("Failed to create file: " . $ifilename);
            }
        }
    }

    public function AppendText($pathfilename, $mytext){
        if (!$this->CheckFile($pathfilename)) {
            return;
        }

        // Use coroutine-safe file append with FILE_APPEND flag
        // This is more efficient and handles concurrent writes better
        $result = \OpenSwoole\Coroutine\System::writeFile($pathfilename, $mytext, FILE_APPEND);
        
        if ($result === false) {
            error_log("Failed to append to file: " . $pathfilename);
        }
    }

    public function CheckFile($path){
        // Use coroutine-safe file existence check
        $stat = \OpenSwoole\Coroutine\System::stat($path);
        return ($stat !== false && isset($stat['mode']));
    }

    public function CheckDirectory($path){
        // Use coroutine-safe directory existence check
        $stat = \OpenSwoole\Coroutine\System::stat($path);
        return ($stat !== false && is_dir($path));
    }
}
