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
use BjyAuthorize\Provider\Role\ProviderInterface;
use ZfcUser\Entity\UserInterface;

/**
 * ErsBase\Entity\User
 *
 * @ORM\Entity()
 * @ORM\Table(name="`user`", indexes={@ORM\Index(name="fk_user_Country1_idx", columns={"Country_id"})}, uniqueConstraints={@ORM\UniqueConstraint(name="email_UNIQUE", columns={"email"})})
 * @ORM\HasLifecycleCallbacks
 */
class User extends Base\User implements UserInterface, ProviderInterface
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * implement __toString for error reporting
     */
    public function __toString() {
        return $this->getFirstname().' '.$this->getSurname().' ('.$this->getEmail().')';
    }
    
    /**
     * Check if user already has a specific role
     * 
     * @param \ErsBase\Entity\Role $role
     * @return type
     */
    public function hasRole(Role $role) {
        $index = $this->roles->indexOf($role);
        return is_numeric($index);
    }
}