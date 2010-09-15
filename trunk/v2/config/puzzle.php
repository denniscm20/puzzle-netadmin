<?php

//exec('echo KEY Piece Function | sudo /usr/bin/php -f /home/puzzle/puzzle.php')

class Command {

    private $pieceName;
    
    private $functionName;
    
    private $parameter;
    
    public function __construct($pieceName, $functionName, $parameter)
    {
        $this->pieceName = $pieceName;
        $this->functionName = $functionName;
        $this->parameter = $parameter;
    }
    
    public function execute()
    {
        $file = './Piece/'.$this->pieceName.'.php';
        if (file_exists($file)) {
            require_once $file;
            $className = "Piece_".$this->pieceName();
            $command = new $className();
            if (method_exists($command, $this->functionName)) {
                if ($this->parameter === "") {
                    $command->{$this->functionName}();
                } else {
                    $command->{$this->functionName}($this->parameter);
                }
                return;
            }
        }
        exit 1;
    }
}

$lines = file('php://stdin');
$count = count($lines);
if ($count === 2 || $count === 3) {
    $pieceName = $lines[0];
    $functionName = $lines[1];
    $parameter = ($count === 3)?$lines[2]:"";
    $command = new Command($pieceName, $functionName, $parameter);
    $command->execute();
    exit 0;
}
exit 1;

// [in /etc/sudoers] 
// www    ALL=(ALL) NOPASSWD: /usr/bin/php -f /home/puzzle.php

?>
