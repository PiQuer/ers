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
 * ErsBase\Entity\Base\Currency
 *
 * @ORM\MappedSuperclass
 * @ORM\Table(name="currency")
 * @ORM\HasLifecycleCallbacks
 */
class Currency
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
    protected $symbol;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    protected $exchange2euro;

    /**
     * @ORM\Column(type="string", length=45, nullable=true)
     */
    protected $short;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $updated;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $created;

    /**
     * @ORM\OneToMany(targetEntity="ProductPrice", mappedBy="currency")
     * @ORM\JoinColumn(name="id", referencedColumnName="Currency_id")
     */
    protected $productPrices;

    public function __construct()
    {
        $this->productPrices = new ArrayCollection();
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
     * @return \ErsBase\Entity\Base\Currency
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
     * @return \ErsBase\Entity\Base\Currency
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
     * Set the value of symbol.
     *
     * @param string $symbol
     * @return \ErsBase\Entity\Base\Currency
     */
    public function setSymbol($symbol)
    {
        $this->symbol = $symbol;

        return $this;
    }

    /**
     * Get the value of symbol.
     *
     * @return string
     */
    public function getSymbol()
    {
        return $this->symbol;
    }

    /**
     * Set the value of exchange2euro.
     *
     * @param float $exchange2euro
     * @return \ErsBase\Entity\Base\Currency
     */
    public function setExchange2euro($exchange2euro)
    {
        $this->exchange2euro = $exchange2euro;

        return $this;
    }

    /**
     * Get the value of exchange2euro.
     *
     * @return float
     */
    public function getExchange2euro()
    {
        return $this->exchange2euro;
    }

    /**
     * Set the value of short.
     *
     * @param string $short
     * @return \ErsBase\Entity\Base\Currency
     */
    public function setShort($short)
    {
        $this->short = $short;

        return $this;
    }

    /**
     * Get the value of short.
     *
     * @return string
     */
    public function getShort()
    {
        return $this->short;
    }

    /**
     * Set the value of updated.
     *
     * @param \DateTime $updated
     * @return \ErsBase\Entity\Base\Currency
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
     * @return \ErsBase\Entity\Base\Currency
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
     * Add ProductPrice entity to collection (one to many).
     *
     * @param \ErsBase\Entity\Base\ProductPrice $productPrice
     * @return \ErsBase\Entity\Base\Currency
     */
    public function addProductPrice(ProductPrice $productPrice)
    {
        $this->productPrices[] = $productPrice;

        return $this;
    }

    /**
     * Remove ProductPrice entity from collection (one to many).
     *
     * @param \ErsBase\Entity\Base\ProductPrice $productPrice
     * @return \ErsBase\Entity\Base\Currency
     */
    public function removeProductPrice(ProductPrice $productPrice)
    {
        $this->productPrices->removeElement($productPrice);

        return $this;
    }

    /**
     * Get ProductPrice entity collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProductPrices()
    {
        return $this->productPrices;
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
        $dataFields = array('id', 'name', 'symbol', 'exchange2euro', 'short', 'updated', 'created');
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
        return array('id', 'name', 'symbol', 'exchange2euro', 'short', 'updated', 'created');
    }
}