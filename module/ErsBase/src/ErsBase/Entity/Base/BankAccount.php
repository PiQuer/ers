<?php

/**
 * Auto generated by MySQL Workbench Schema Exporter.
 * Version 2.1.6-dev (doctrine2-mappedsuperclass) on 2016-03-19 10:02:20.
 * Goto https://github.com/johmue/mysql-workbench-schema-exporter for more
 * information.
 */

namespace ErsBase\Entity\Base;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * ErsBase\Entity\Base\BankAccount
 *
 * @ORM\MappedSuperclass
 * @ORM\Table(name="bank_account")
 * @ORM\HasLifecycleCallbacks
 */
class BankAccount
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="`name`", type="string", length=45, nullable=true)
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=45, nullable=true)
     */
    protected $bank;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $virtual;

    /**
     * @ORM\Column(type="string", length=45, nullable=true)
     */
    protected $iban;

    /**
     * @ORM\Column(type="string", length=45, nullable=true)
     */
    protected $bic;

    /**
     * @ORM\Column(type="string", length=45, nullable=true)
     */
    protected $kto;

    /**
     * @ORM\Column(type="string", length=45, nullable=true)
     */
    protected $blz;

    /**
     * @ORM\Column(type="string", length=3000, nullable=true)
     */
    protected $statement_format;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $updated;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $created;

    /**
     * @ORM\OneToMany(targetEntity="BankAccountCsv", mappedBy="bankAccount")
     * @ORM\JoinColumn(name="id", referencedColumnName="bank_account_id")
     */
    protected $bankAccountCsvs;

    /**
     * @ORM\OneToMany(targetEntity="BankStatement", mappedBy="bankAccount")
     * @ORM\JoinColumn(name="id", referencedColumnName="bank_account_id")
     */
    protected $bankStatements;

    public function __construct()
    {
        $this->bankAccountCsvs = new ArrayCollection();
        $this->bankStatements = new ArrayCollection();
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
     * @return \ErsBase\Entity\Base\BankAccount
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
     * Set the value of name.
     *
     * @param string $name
     * @return \ErsBase\Entity\Base\BankAccount
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of bank.
     *
     * @param string $bank
     * @return \ErsBase\Entity\Base\BankAccount
     */
    public function setBank($bank)
    {
        $this->bank = $bank;

        return $this;
    }

    /**
     * Get the value of bank.
     *
     * @return string
     */
    public function getBank()
    {
        return $this->bank;
    }

    /**
     * Set the value of virtual.
     *
     * @param boolean $virtual
     * @return \ErsBase\Entity\Base\BankAccount
     */
    public function setVirtual($virtual)
    {
        $this->virtual = $virtual;

        return $this;
    }

    /**
     * Get the value of virtual.
     *
     * @return boolean
     */
    public function getVirtual()
    {
        return $this->virtual;
    }

    /**
     * Set the value of iban.
     *
     * @param string $iban
     * @return \ErsBase\Entity\Base\BankAccount
     */
    public function setIban($iban)
    {
        $this->iban = $iban;

        return $this;
    }

    /**
     * Get the value of iban.
     *
     * @return string
     */
    public function getIban()
    {
        return $this->iban;
    }

    /**
     * Set the value of bic.
     *
     * @param string $bic
     * @return \ErsBase\Entity\Base\BankAccount
     */
    public function setBic($bic)
    {
        $this->bic = $bic;

        return $this;
    }

    /**
     * Get the value of bic.
     *
     * @return string
     */
    public function getBic()
    {
        return $this->bic;
    }

    /**
     * Set the value of kto.
     *
     * @param string $kto
     * @return \ErsBase\Entity\Base\BankAccount
     */
    public function setKto($kto)
    {
        $this->kto = $kto;

        return $this;
    }

    /**
     * Get the value of kto.
     *
     * @return string
     */
    public function getKto()
    {
        return $this->kto;
    }

    /**
     * Set the value of blz.
     *
     * @param string $blz
     * @return \ErsBase\Entity\Base\BankAccount
     */
    public function setBlz($blz)
    {
        $this->blz = $blz;

        return $this;
    }

    /**
     * Get the value of blz.
     *
     * @return string
     */
    public function getBlz()
    {
        return $this->blz;
    }

    /**
     * Set the value of statement_format.
     *
     * @param string $statement_format
     * @return \ErsBase\Entity\Base\BankAccount
     */
    public function setStatementFormat($statement_format)
    {
        $this->statement_format = $statement_format;

        return $this;
    }

    /**
     * Get the value of statement_format.
     *
     * @return string
     */
    public function getStatementFormat()
    {
        return $this->statement_format;
    }

    /**
     * Set the value of updated.
     *
     * @param \DateTime $updated
     * @return \ErsBase\Entity\Base\BankAccount
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
     * @return \ErsBase\Entity\Base\BankAccount
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
     * Add BankAccountCsv entity to collection (one to many).
     *
     * @param \ErsBase\Entity\Base\BankAccountCsv $bankAccountCsv
     * @return \ErsBase\Entity\Base\BankAccount
     */
    public function addBankAccountCsv(BankAccountCsv $bankAccountCsv)
    {
        $this->bankAccountCsvs[] = $bankAccountCsv;

        return $this;
    }

    /**
     * Remove BankAccountCsv entity from collection (one to many).
     *
     * @param \ErsBase\Entity\Base\BankAccountCsv $bankAccountCsv
     * @return \ErsBase\Entity\Base\BankAccount
     */
    public function removeBankAccountCsv(BankAccountCsv $bankAccountCsv)
    {
        $this->bankAccountCsvs->removeElement($bankAccountCsv);

        return $this;
    }

    /**
     * Get BankAccountCsv entity collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBankAccountCsvs()
    {
        return $this->bankAccountCsvs;
    }

    /**
     * Add BankStatement entity to collection (one to many).
     *
     * @param \ErsBase\Entity\Base\BankStatement $bankStatement
     * @return \ErsBase\Entity\Base\BankAccount
     */
    public function addBankStatement(BankStatement $bankStatement)
    {
        $this->bankStatements[] = $bankStatement;

        return $this;
    }

    /**
     * Remove BankStatement entity from collection (one to many).
     *
     * @param \ErsBase\Entity\Base\BankStatement $bankStatement
     * @return \ErsBase\Entity\Base\BankAccount
     */
    public function removeBankStatement(BankStatement $bankStatement)
    {
        $this->bankStatements->removeElement($bankStatement);

        return $this;
    }

    /**
     * Get BankStatement entity collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBankStatements()
    {
        return $this->bankStatements;
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
        $dataFields = array('id', 'name', 'bank', 'virtual', 'iban', 'bic', 'kto', 'blz', 'statement_format', 'updated', 'created');
        $relationFields = array();
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
        return array('id', 'name', 'bank', 'virtual', 'iban', 'bic', 'kto', 'blz', 'statement_format', 'updated', 'created');
    }
}