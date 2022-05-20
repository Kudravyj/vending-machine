<?php

include __DIR__ . "/src/Action/ActionInterface.php";
include __DIR__ . "/src/VendingMachineInterface.php";
use VendingMachine\Action\ActionInterface;
use VendingMachine\VendingMachineInterface;
use VendingMachine\Response\ResponseInterface;
use VendingMachine\Item\ItemCodeInterface;
use VendingMachine\Item\ItemInterface;
use VendingMachine\Money\MoneyCollectionInterface;
use VendingMachine\Money\MoneyInterface;


class Input extends Action Implements ActionInterface{

    use VendingMachine;
    use Item;
    use Money;

    public $input;

    protected $amount = 0;
    protected $cash = array();

    protected function getAction()
    {
        $this->getMoneyCollection();
        $this->input = readline("INPUT: ");
        $this->getName();
    }

    public function getInput()
    { 
        $this->getAction();  
    }
    protected function getMoneyCollection()
    {
        echo "your balance: " . "$this->amount ";
        $this->merge();
    }
    public function handle(VendingMachineInterface $vendingMachine): ResponseInterface{
        $this->__toString();
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
    public function alertItem()
    {
        echo "Incorrect Item\r\n";
        $this->getAction();
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
                    $this->alertMoney();
                    break;
            } 
            $this->cash = array();
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
        echo"(";
        foreach ($this->cash as $sad) {
            echo $sad . ",";
        }
        echo")\r\n";
    }

    protected function toArray()
    {
        $this->cash[] = $this->input;
    }

    protected function getValue()
    {
        return $this->amount;
    }
}
trait VendingMachine{
    public function alertMoney()
    {
        echo "no enought money";
    }

    public function addItem(){
        $this->getPrice();
        $this->getCount();
    }

    public function dropItem(){
        echo substr($this->input,4) . "\r\n";
    }

    public function insertMoney(): void{
        $this->add();
        $this->getInput();
        return;
    }

    public function getCurrentTransactionMoney(){
        
        if($this->amount != 0){
            $this->getInsertedMoney();
        }
        else
            $this->alertMoney();
    }

    public function getInsertedMoney(){        
        
        echo "You recived " . "$this->amount";
        $this->merge();
        $this->amount = 0;
        $this->cash = array();
    }
}

class Action{

    public function getName() : string
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
                $this->alertItem();
                break;
        }
        return "stop";
    }
}


$sam = new Input();
$sam->getInput();