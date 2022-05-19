<?php

include "src/Action/ActionInterface.php";

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