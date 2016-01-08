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
 * ErsBase\Entity\PaymentType
 *
 * @ORM\Entity()
 * @ORM\Table(name="payment_type", indexes={@ORM\Index(name="fk_PaymentType_Deadline1_idx", columns={"active_from_id"}), @ORM\Index(name="fk_PaymentType_Deadline2_idx", columns={"active_until_id"})})
 * @ORM\HasLifecycleCallbacks
 */
class PaymentType extends Base\PaymentType
{
    public function __construct()
    {
        parent::__construct();
    }

}