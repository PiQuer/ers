<?php

/**
 * Auto generated by MySQL Workbench Schema Exporter.
 * Version 2.1.6-dev (doctrine2-mappedsuperclass) on 2016-01-26 12:14:33.
 * Goto https://github.com/johmue/mysql-workbench-schema-exporter for more
 * information.
 */

namespace ErsBase\Entity\Base;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * ErsBase\Entity\Base\BankStatement
 *
 * @ORM\MappedSuperclass
 * @ORM\Table(name="bank_statement", indexes={@ORM\Index(name="fk_bank_statement_bank_account_csv1_idx", columns={"bank_account_csv_id"}), @ORM\Index(name="fk_bank_statement_bank_account1_idx", columns={"bank_account_id"})})
 * @ORM\HasLifecycleCallbacks
 */
class BankStatement
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="integer")
     */
    protected $bank_account_id;

    /**
     * @ORM\Column(type="integer")
     */
    protected $bank_account_csv_id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $hash;

    /**
     * @ORM\Column(name="`status`", type="string", length=45, nullable=true)
     */
    protected $status;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $updated;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $created;

    /**
     * @ORM\OneToMany(targetEntity="BankStatementCol", mappedBy="bankStatement")
     * @ORM\JoinColumn(name="id", referencedColumnName="bank_statement_id")
     */
    protected $bankStatementCols;

    /**
     * @ORM\OneToMany(targetEntity="Match", mappedBy="bankStatement")
     * @ORM\JoinColumn(name="id", referencedColumnName="bank_statement_id")
     */
    protected $matches;

    /**
     * @ORM\ManyToOne(targetEntity="BankAccount", inversedBy="bankStatements")
     * @ORM\JoinColumn(name="bank_account_id", referencedColumnName="id")
     */
    protected $bankAccount;

    /**
     * @ORM\ManyToOne(targetEntity="BankAccountCsv", inversedBy="bankStatements")
     * @ORM\JoinColumn(name="bank_account_csv_id", referencedColumnName="id")
     */
    protected $bankAccountCsv;

    public function __construct()
    {
        $this->bankStatementCols = new ArrayCollection();
        $this->matches = new ArrayCollection();
    }

    /**
     * @ORM\PrePersist
     */
    public function PrePersist()
    {
        if(!isset($this->created)) {
            $this->created = new \DateTime();
        }
        $this->updated = new \DateTime();
    }

    /**
     * @ORM\PreUpdate
     */
    public function PreUpdate()
    {
        $this->updated = new \DateTime();
    }

    /**
     * Set the value of id.
     *
     * @param integer $id
     * @return \ErsBase\Entity\Base\BankStatement
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of id.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of bank_account_id.
     *
     * @param integer $bank_account_id
     * @return \ErsBase\Entity\Base\BankStatement
     */
    public function setBankAccountId($bank_account_id)
    {
        $this->bank_account_id = $bank_account_id;

        return $this;
    }

    /**
     * Get the value of bank_account_id.
     *
     * @return integer
     */
    public function getBankAccountId()
    {
        return $this->bank_account_id;
    }

    /**
     * Set the value of bank_account_csv_id.
     *
     * @param integer $bank_account_csv_id
     * @return \ErsBase\Entity\Base\BankStatement
     */
    public function setBankAccountCsvId($bank_account_csv_id)
    {
        $this->bank_account_csv_id = $bank_account_csv_id;

        return $this;
    }

    /**
     * Get the value of bank_account_csv_id.
     *
     * @return integer
     */
    public function getBankAccountCsvId()
    {
        return $this->bank_account_csv_id;
    }

    /**
     * Set the value of hash.
     *
     * @param string $hash
     * @return \ErsBase\Entity\Base\BankStatement
     */
    public function setHash($hash)
    {
        $this->hash = $hash;

        return $this;
    }

    /**
     * Get the value of hash.
     *
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * Set the value of status.
     *
     * @param string $status
     * @return \ErsBase\Entity\Base\BankStatement
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get the value of status.
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of updated.
     *
     * @param \DateTime $updated
     * @return \ErsBase\Entity\Base\BankStatement
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get the value of updated.
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set the value of created.
     *
     * @param \DateTime $created
     * @return \ErsBase\Entity\Base\BankStatement
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get the value of created.
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Add BankStatementCol entity to collection (one to many).
     *
     * @param \ErsBase\Entity\Base\BankStatementCol $bankStatementCol
     * @return \ErsBase\Entity\Base\BankStatement
     */
    public function addBankStatementCol(BankStatementCol $bankStatementCol)
    {
        $this->bankStatementCols[] = $bankStatementCol;

        return $this;
    }

    /**
     * Remove BankStatementCol entity from collection (one to many).
     *
     * @param \ErsBase\Entity\Base\BankStatementCol $bankStatementCol
     * @return \ErsBase\Entity\Base\BankStatement
     */
    public function removeBankStatementCol(BankStatementCol $bankStatementCol)
    {
        $this->bankStatementCols->removeElement($bankStatementCol);

        return $this;
    }

    /**
     * Get BankStatementCol entity collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBankStatementCols()
    {
        return $this->bankStatementCols;
    }

    /**
     * Add Match entity to collection (one to many).
     *
     * @param \ErsBase\Entity\Base\Match $match
     * @return \ErsBase\Entity\Base\BankStatement
     */
    public function addMatch(Match $match)
    {
        $this->matches[] = $match;

        return $this;
    }

    /**
     * Remove Match entity from collection (one to many).
     *
     * @param \ErsBase\Entity\Base\Match $match
     * @return \ErsBase\Entity\Base\BankStatement
     */
    public function removeMatch(Match $match)
    {
        $this->matches->removeElement($match);

        return $this;
    }

    /**
     * Get Match entity collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMatches()
    {
        return $this->matches;
    }

    /**
     * Set BankAccount entity (many to one).
     *
     * @param \ErsBase\Entity\Base\BankAccount $bankAccount
     * @return \ErsBase\Entity\Base\BankStatement
     */
    public function setBankAccount(BankAccount $bankAccount = null)
    {
        $this->bankAccount = $bankAccount;

        return $this;
    }

    /**
     * Get BankAccount entity (many to one).
     *
     * @return \ErsBase\Entity\Base\BankAccount
     */
    public function getBankAccount()
    {
        return $this->bankAccount;
    }

    /**
     * Set BankAccountCsv entity (many to one).
     *
     * @param \ErsBase\Entity\Base\BankAccountCsv $bankAccountCsv
     * @return \ErsBase\Entity\Base\BankStatement
     */
    public function setBankAccountCsv(BankAccountCsv $bankAccountCsv = null)
    {
        $this->bankAccountCsv = $bankAccountCsv;

        return $this;
    }

    /**
     * Get BankAccountCsv entity (many to one).
     *
     * @return \ErsBase\Entity\Base\BankAccountCsv
     */
    public function getBankAccountCsv()
    {
        return $this->bankAccountCsv;
    }

    /**
     * Populate entity with the given data.
     * The set* method will be used to set the data.
     *
     * @param array $data
     * @return boolean
     */
    public function populate(array $data = array())
    {
        foreach ($data as $field => $value) {
            $setter = sprintf('set%s', ucfirst(
                str_replace(' ', '', ucwords(str_replace('_', ' ', $field)))
            ));
            if (method_exists($this, $setter)) {
                $this->{$setter}($value);
            }
        }

        return true;
    }

    /**
     * Return a array with all fields and data.
     * Default the relations will be ignored.
     * 
     * @param array $fields
     * @return array
     */
    public function getArrayCopy(array $fields = array())
    {
        $dataFields = array('id', 'bank_account_id', 'bank_account_csv_id', 'hash', 'status', 'updated', 'created');
        $relationFields = array('bankAccountCsv', 'bankAccount');
        $copiedFields = array();
        foreach ($relationFields as $relationField) {
            $map = null;
            if (array_key_exists($relationField, $fields)) {
                $map = $fields[$relationField];
                $fields[] = $relationField;
                unset($fields[$relationField]);
            }
            if (!in_array($relationField, $fields)) {
                continue;
            }
            $getter = sprintf('get%s', ucfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $relationField)))));
            $relationEntity = $this->{$getter}();
            $copiedFields[$relationField] = (!is_null($map))
                ? $relationEntity->getArrayCopy($map)
                : $relationEntity->getArrayCopy();
            $fields = array_diff($fields, array($relationField));
        }
        foreach ($dataFields as $dataField) {
            if (!in_array($dataField, $fields) && !empty($fields)) {
                continue;
            }
            $getter = sprintf('get%s', ucfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $dataField)))));
            $copiedFields[$dataField] = $this->{$getter}();
        }

        return $copiedFields;
    }

    public function __sleep()
    {
        return array('id', 'bank_account_id', 'bank_account_csv_id', 'hash', 'status', 'updated', 'created');
    }
}