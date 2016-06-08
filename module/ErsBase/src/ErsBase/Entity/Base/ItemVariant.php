<?php

/**
 * Auto generated by MySQL Workbench Schema Exporter.
 * Version 2.1.6-dev (doctrine2-mappedsuperclass) on 2016-06-07 09:27:21.
 * Goto https://github.com/johmue/mysql-workbench-schema-exporter for more
 * information.
 */

namespace ErsBase\Entity\Base;

use Doctrine\ORM\Mapping as ORM;

/**
 * ErsBase\Entity\Base\ItemVariant
 *
 * @ORM\MappedSuperclass
 * @ORM\Table(name="item_variant", indexes={@ORM\Index(name="fk_ItemVariant_Item1_idx", columns={"Item_id"}), @ORM\Index(name="fk_item_variant_product_variant1_idx", columns={"product_variant_id"}), @ORM\Index(name="fk_item_variant_product_variant_value1_idx", columns={"product_variant_value_id"})})
 * @ORM\HasLifecycleCallbacks
 */
class ItemVariant
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
    protected $Item_id;

    /**
     * @ORM\Column(type="integer")
     */
    protected $product_variant_id;

    /**
     * @ORM\Column(type="integer")
     */
    protected $product_variant_value_id;

    /**
     * @ORM\Column(name="`name`", type="string", length=45, nullable=true)
     */
    protected $name;

    /**
     * @ORM\Column(name="`value`", type="string", length=45, nullable=true)
     */
    protected $value;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $updated;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $created;

    /**
     * @ORM\ManyToOne(targetEntity="Item", inversedBy="itemVariants", cascade={"persist", "merge", "remove"})
     * @ORM\JoinColumn(name="Item_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $item;

    /**
     * @ORM\ManyToOne(targetEntity="ProductVariant", inversedBy="itemVariants")
     * @ORM\JoinColumn(name="product_variant_id", referencedColumnName="id")
     */
    protected $productVariant;

    /**
     * @ORM\ManyToOne(targetEntity="ProductVariantValue", inversedBy="itemVariants")
     * @ORM\JoinColumn(name="product_variant_value_id", referencedColumnName="id")
     */
    protected $productVariantValue;

    public function __construct()
    {
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
     * @return \ErsBase\Entity\Base\ItemVariant
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
     * Set the value of Item_id.
     *
     * @param integer $Item_id
     * @return \ErsBase\Entity\Base\ItemVariant
     */
    public function setItemId($Item_id)
    {
        $this->Item_id = $Item_id;

        return $this;
    }

    /**
     * Get the value of Item_id.
     *
     * @return integer
     */
    public function getItemId()
    {
        return $this->Item_id;
    }

    /**
     * Set the value of product_variant_id.
     *
     * @param integer $product_variant_id
     * @return \ErsBase\Entity\Base\ItemVariant
     */
    public function setProductVariantId($product_variant_id)
    {
        $this->product_variant_id = $product_variant_id;

        return $this;
    }

    /**
     * Get the value of product_variant_id.
     *
     * @return integer
     */
    public function getProductVariantId()
    {
        return $this->product_variant_id;
    }

    /**
     * Set the value of product_variant_value_id.
     *
     * @param integer $product_variant_value_id
     * @return \ErsBase\Entity\Base\ItemVariant
     */
    public function setProductVariantValueId($product_variant_value_id)
    {
        $this->product_variant_value_id = $product_variant_value_id;

        return $this;
    }

    /**
     * Get the value of product_variant_value_id.
     *
     * @return integer
     */
    public function getProductVariantValueId()
    {
        return $this->product_variant_value_id;
    }

    /**
     * Set the value of name.
     *
     * @param string $name
     * @return \ErsBase\Entity\Base\ItemVariant
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
     * Set the value of value.
     *
     * @param string $value
     * @return \ErsBase\Entity\Base\ItemVariant
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get the value of value.
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set the value of updated.
     *
     * @param \DateTime $updated
     * @return \ErsBase\Entity\Base\ItemVariant
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
     * @return \ErsBase\Entity\Base\ItemVariant
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
     * Set Item entity (many to one).
     *
     * @param \ErsBase\Entity\Base\Item $item
     * @return \ErsBase\Entity\Base\ItemVariant
     */
    public function setItem(Item $item = null)
    {
        $this->item = $item;

        return $this;
    }

    /**
     * Get Item entity (many to one).
     *
     * @return \ErsBase\Entity\Base\Item
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * Set ProductVariant entity (many to one).
     *
     * @param \ErsBase\Entity\Base\ProductVariant $productVariant
     * @return \ErsBase\Entity\Base\ItemVariant
     */
    public function setProductVariant(ProductVariant $productVariant = null)
    {
        $this->productVariant = $productVariant;

        return $this;
    }

    /**
     * Get ProductVariant entity (many to one).
     *
     * @return \ErsBase\Entity\Base\ProductVariant
     */
    public function getProductVariant()
    {
        return $this->productVariant;
    }

    /**
     * Set ProductVariantValue entity (many to one).
     *
     * @param \ErsBase\Entity\Base\ProductVariantValue $productVariantValue
     * @return \ErsBase\Entity\Base\ItemVariant
     */
    public function setProductVariantValue(ProductVariantValue $productVariantValue = null)
    {
        $this->productVariantValue = $productVariantValue;

        return $this;
    }

    /**
     * Get ProductVariantValue entity (many to one).
     *
     * @return \ErsBase\Entity\Base\ProductVariantValue
     */
    public function getProductVariantValue()
    {
        return $this->productVariantValue;
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
        $dataFields = array('id', 'Item_id', 'product_variant_id', 'product_variant_value_id', 'name', 'value', 'updated', 'created');
        $relationFields = array('item', 'productVariant', 'productVariantValue');
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
        return array('id', 'Item_id', 'product_variant_id', 'product_variant_value_id', 'name', 'value', 'updated', 'created');
    }
}