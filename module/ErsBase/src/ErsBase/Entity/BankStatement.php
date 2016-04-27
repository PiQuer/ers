<?php

/**
 * Auto generated by MySQL Workbench Schema Exporter.
 * Version 2.1.6-dev (doctrine2-realentity) on 2016-01-07 08:26:28.
 * Goto https://github.com/johmue/mysql-workbench-schema-exporter for more
 * information.
 */

namespace ErsBase\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * ErsBase\Entity\BankStatement
 *
 * @ORM\Entity()
 * @ORM\Table(name="bank_statement", indexes={@ORM\Index(name="fk_bank_statement_bank_account_csv1_idx", columns={"bank_account_csv_id"}), @ORM\Index(name="fk_bank_statement_bank_account1_idx", columns={"bank_account_id"})})
 * @ORM\HasLifecycleCallbacks
 */
class BankStatement extends Base\BankStatement
{
    public function __construct()
    {
        parent::__construct();
    }

    
    /**
     * generate the hash code for this bank statement
     * 
     * @return \ErsBase\Entity\BankStatement
     */
    public function generateHash() {
        $values = array();
        foreach($this->getBankStatementCols() as $col) {
            $values[] = $col->getValue();
        }
        $this->setHash(md5(implode($values)));
        
        return $this;
    }
    
    /**
     * Get BankStatementCol entity by column number
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBankStatementColByNumber($num)
    {
        # I don't know why this is not working
        #$columnCriteria = Criteria::create()->where(Criteria::expr()->eq("column", $num));
        #return $this->getBankStatementCols()->matching($columnCriteria)->first();
        foreach($this->getBankStatementCols() as $col) {
            if($col->getColumn() == $num) {
                return $col;
            }
        }
        return new BankStatementCol();
    }
    
    /**
     * get the amount of this statement according to the format
     */
    public function getAmount() {
        $statement_format = json_decode($this->getBankAccount()->getStatementFormat());
        return $this->getBankStatementColByNumber($statement_format->amount);
    }
    
    /**
     * get the value of the amount of this statement according to the format
     */
    public function getAmountValue() {
        return (float) $this->getAmount()->getValue();
    }
    
    /**
     * Get the name of this statement according to the format
     */
    public function getName() {
        $statement_format = json_decode($this->getBankAccount()->getStatementFormat());
        return $this->getBankStatementColByNumber($statement_format->name);
    }
    /**
     * Get the code of this statement according to the format
     */
    public function getCode() {
        $statement_format = json_decode($this->getBankAccount()->getStatementFormat());
        return $this->getBankStatementColByNumber($statement_format->matchKey);
    }
    /**
     * Get the date of this statement according to the format
     */
    public function getDate() {
        $statement_format = json_decode($this->getBankAccount()->getStatementFormat());
        $datestring = $this->getBankStatementColByNumber($statement_format->date)->getValue();
        $timestamp = strtotime($datestring);
        if($timestamp != false) {
            $date = new \DateTime();
            $date->setTimestamp($timestamp);
            return $date;
        } else {
            error_log('unable to convert this to time: '.$datestring);
            return false;
        }
        
    }
    
}
