<?php

include 'src/Action/ActionInterface.php';


class Input extends Action{

    use VendingMachine;
    use Item;
    use Money;

    public $input;

    protected $amount = 0;
    protected $cash = array();

    protected function getAction()
    {
        $this->getMoneyCollection();
        $this->input = readline("\r\nINPUT:");
        $this->getName();
    }

    public function getInput()
    { 
        $this->getAction();  
    }
    protected function getMoneyCollection()
    {
        echo "\r\nyour balance: " . "$this->amount ";
        $this->merge();
    }
}

trait Item{
    private $A;
    private $B;
    private $C;

    protected function getPrice()
    {
        $this->A = 0.60;
        $this->B = 1;
        $this->C = 1.60;

    }
    
    protected function getCount()
    {
        switch($this->input){
            case 'GET-A':
                if($this->amount >= $this->A){
                    $this->amount -= $this->A;
                    $this->dropItem();
                    break;
                }
                else
                    $this->errorMoney();
                    break;
            case 'GET-B':
                if($this->amount >= $this->B){
                    $this->amount -= $this->B;
                    $this->dropItem();
                    break;
                }
                else
                    $this->errorMoney();
                    break;
            case 'GET-C':
                if($this->amount >= $this->C){
                    $this->amount -= $this->C;
                    $this->dropItem();
                    break;
                }
                else
                    $this->errorMoney();
                    break;
            } 
            $this->getInput();
    }
}
trait Money{

    protected function add()
    {
        switch($this->input){
            case 'N':
                $this->amount += 0.05;
                break;
            case 'D':
                $this->amount += 0.1;
                break;
            case 'Q':
                $this->amount += 0.25;
                break;
            case 'DOLLAR':
                $this->amount += 1;
                break;    
        }
        $this->toArray();
    }
    protected function merge()
    {   
        echo'(';
        foreach ($this->cash as $sad) {
            echo $sad . ", ";
        }
        echo')';
    }
    protected function toArray()
    {
        $this->cash = $this->input;
    }
}
trait VendingMachine{
    public function errorMoney()
    {
        echo "no enought money";
    }

    protected function addItem(){
        $this->getPrice();
        $this->getCount();
    }

    protected function dropItem(){
        echo substr($this->input,4);
    }

    protected function insertMoney(){
        
        $this->add();
        $this->getInput();
    }

    protected function getCurrentTransactionMoney(){
        
        if($this->amount != 0){
            $this->getInsertedMoney();
        }
        else
            echo "You haven't enought money";
    }

    protected function getInsertedMoney(){        
        
        echo "You recived " . "$this->amount";
        $this->amount = 0;
        echo("$this->amount");
    }
}

class Action{

    protected function getName()
    {
        switch($this->input){
            case 'GET-A':
            case 'GET-B':
            case 'GET-C':
                $this->addItem();
                break;

            case 'Q':
            case 'N':
            case 'D':
            case 'DOLLAR':
                $this->insertMoney();
                break;

            case 'RETURN MONEY':
                $this->getCurrentTransactionMoney();
                break;

            default:
                echo "sorry, I can't see";
                break;
        }
    }
}


$sam = new Input();
$sam->getInput();