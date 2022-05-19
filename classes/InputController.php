<?php

class Input extends Action{

use VendingMachine;
use Item;

public $input;

protected $amount = 0;

protected function getAction()
{
    $this->getMoneyCollection();
    $this->input = readline('INPUT:');
    $this->getName();
}

public function getInput()
{ 
    $this->getAction();  
}
protected function getMoneyCollection()
{
    echo "\r\nyour balance: " . "$this->amount" . "\r\n";
}
}