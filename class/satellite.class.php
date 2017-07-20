<?php
class satellite {
  public $hp;
	public $ftd;
  public $std; 
  public $bstar; 

  public function __construct($hp, $ftd, $std, $bstar) {
    $this->hp = $hp;
    $this->ftd = $ftd;
    $this->std = $std;
    $this->bstar = $bstar;
  }
}