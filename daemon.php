<?php
class daemon{
	
	private 
	$low_limit,
	$high_limit,
	$amount,
	$max;
	
	public $v = 0;
	
	public function __construct(int $low_limit, int $high_limit, int $amount, int $max)
	{
		$this->low_limit = $low_limit;
		$this->high_limit = $high_limit;
		$this->amount = $amount;
		$this->max = $max;
	}
	
	public function start(){
		$x=0;
		$y=0;
		while(1){
			$level=$this->getMoistureLevel();
			echo "[system]: current moisture level = ".$level.PHP_EOL;
			if($level>=$this->high_limit){
				echo "[system]: exceed high limit".PHP_EOL;
				$this->v++;
			}
			if($level<$this->low_limit){
				echo "[system]: exceed low limit".PHP_EOL;
				$this->v--;
			}
			if($this->v>$this->amount*(1)){
				echo "[system]: exceed high limit".PHP_EOL;
				echo "[system]: stop watering".PHP_EOL;
				system('sudo ./hub-ctrl -P 2 -p 0');
				system('sudo ./hub-ctrl -P 2 -p 0');
			}
			if($y>$this->max){
				echo "[system]: exceed watering limit".PHP_EOL;
				echo "[system]: stop watering".PHP_EOL;
				system('sudo ./hub-ctrl -P 2 -p 0');
				system('sudo ./hub-ctrl -P 2 -p 0');
			}else{
				if($this->v<$this->amount*(-1)){
				echo "[system]: exceed low limit for too many times".PHP_EOL;
				if($y>$this->amount){
					echo "[system]: exceed watering limit".PHP_EOL;
				}else{
					echo "[system]: start watering".PHP_EOL;
				system('sudo ./hub-ctrl -P 2 -p 1');
				$y++;
			}
			}
			}
			$x++;
			echo "[system]: cycle".$x.PHP_EOL;
			if($x>10000){
				echo "[system]: starting new cycle".PHP_EOL;
				$x=0;
				$y=0;
				$this->v=0;
			}
			sleep(1);
		}
	}
	
	public function getMoistureLevel() : int
	{
		$level=file_get_contents('data.txt');
		return empty($level)?intval($this->getMoistureLevel()):intval($level);
	}
}
$daemon = new daemon(5000,10000,10,10);
$daemon->start();
