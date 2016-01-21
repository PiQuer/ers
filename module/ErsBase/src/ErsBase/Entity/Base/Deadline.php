<?php

/**
 * Auto generated by MySQL Workbench Schema Exporter.
 * Version 2.1.6-dev (doctrine2-mappedsuperclass) on 2016-01-21 09:34:07.
 * Goto https://github.com/johmue/mysql-workbench-schema-exporter for more
 * information.
 */

namespace ErsBase\Entity\Base;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * ErsBase\Entity\Base\Deadline
 *
 * @ORM\MappedSuperclass
 * @ORM\Table(name="deadline")
 * @ORM\HasLifecycleCallbacks
 */
class Deadline
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $deadline;

    /**
     * @ORM\Column(name="`name`", type="string", length=100, nullable=true)
     */
    protected $name;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $price_change;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $updated;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $created;

    /**
     * @ORM\OneToMany(targetEntity="PaymentType", mappedBy="deadlineRelatedByActiveFromId")
     * @ORM\JoinColumn(name="id", referencedColumnName="active_from_id")
     */
    protected $paymentTypeRelatedByActiveFromIds;

    /**
     * @ORM\OneToMany(targetEntity="PaymentType", mappedBy="deadlineRelatedByActiveUntilId")
     * @ORM\JoinColumn(name="id", referencedColumnName="active_until_id")
     */
    protected $paymentTypeRelatedByActiveUntilIds;

    /**
     * @ORM\OneToMany(targetEntity="ProductPrice", mappedBy="deadline")
     * @ORM\JoinColumn(name="id", referencedColumnName="Deadline_id")
     */
    protected $productPrices;

    public function __construct()
    {
        $this->paymentTypeRelatedByActiveFromIds = new ArrayCollection();
        $this->paymentTypeRelatedByActiveUntilIds = new ArrayCollection();
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
     * @return \ErsBase\Entity\Base\Deadline
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
     * Set the value of deadline.
     *
     * @param \DateTime $deadline
     * @return \ErsBase\Entity\Base\Deadline
     */
    public function setDeadline($deadline)
    {
        $this->deadline = $deadline;

        return $this;
    }

    /**
     * Get the value of deadline.
     *
     * @return \DateTime
     */
    public function getDeadline()
    {
        return $this->deadline;
    }

    /**
     * Set the value of name.
     *
     * @param string $name
     * @return \ErsBase\Entity\Base\Deadline
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
     * Set the value of price_change.
     *
     * @param boolean $price_change
     * @return \ErsBase\Entity\Base\Deadline
     */
    public function setPriceChange($price_change)
    {
        $this->price_change = $price_change;

        return $this;
    }

    /**
     * Get the value of price_change.
     *
     * @return boolean
     */
    public function getPriceChange()
    {
        return $this->price_change;
    }

    /**
     * Set the value of updated.
     *
     * @param \DateTime $updated
     * @return \ErsBase\Entity\Base\Deadline
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
     * @return \ErsBase\Entity\Base\Deadline
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
     * Add PaymentType entity related by `active_from_id` to collection (one to many).
     *
     * @param \ErsBase\Entity\Base\PaymentType $paymentType
     * @return \ErsBase\Entity\Base\Deadline
     */
    public function addPaymentTypeRelatedByActiveFromId(PaymentType $paymentType)
    {
        $this->paymentTypeRelatedByActiveFromIds[] = $paymentType;

        return $this;
    }

    /**
     * Remove PaymentType entity related by `active_from_id` from collection (one to many).
     *
     * @param \ErsBase\Entity\Base\PaymentType $paymentType
     * @return \ErsBase\Entity\Base\Deadline
     */
    public function removePaymentTypeRelatedByActiveFromId(PaymentType $paymentType)
    {
        $this->paymentTypeRelatedByActiveFromIds->removeElement($paymentType);

        return $this;
    }

    /**
     * Get PaymentType entity related by `active_from_id` collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPaymentTypeRelatedByActiveFromIds()
    {
        return $this->paymentTypeRelatedByActiveFromIds;
    }

    /**
     * Add PaymentType entity related by `active_until_id` to collection (one to many).
     *
     * @param \ErsBase\Entity\Base\PaymentType $paymentType
     * @return \ErsBase\Entity\Base\Deadline
     */
    public function addPaymentTypeRelatedByActiveUntilId(PaymentType $paymentType)
    {
        $this->paymentTypeRelatedByActiveUntilIds[] = $paymentType;

        return $this;
    }

    /**
     * Remove PaymentType entity related by `active_until_id` from collection (one to many).
     *
     * @param \ErsBase\Entity\Base\PaymentType $paymentType
     * @return \ErsBase\Entity\Base\Deadline
     */
    public function removePaymentTypeRelatedByActiveUntilId(PaymentType $paymentType)
    {
        $this->paymentTypeRelatedByActiveUntilIds->removeElement($paymentType);

        return $this;
    }

    /**
     * Get PaymentType entity related by `active_until_id` collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPaymentTypeRelatedByActiveUntilIds()
    {
        return $this->paymentTypeRelatedByActiveUntilIds;
    }

    /**
     * Add ProductPrice entity to collection (one to many).
     *
     * @param \ErsBase\Entity\Base\ProductPrice $productPrice
     * @return \ErsBase\Entity\Base\Deadline
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
     * @return \ErsBase\Entity\Base\Deadline
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
        $dataFields = array('id', 'deadline', 'name', 'price_change', 'updated', 'created');
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
        return array('id', 'deadline', 'name', 'price_change', 'updated', 'created');
    }
}