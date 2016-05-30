<?php

/**
 * Auto generated by MySQL Workbench Schema Exporter.
 * Version 2.1.6-dev (doctrine2-mappedsuperclass) on 2016-05-30 09:28:34.
 * Goto https://github.com/johmue/mysql-workbench-schema-exporter for more
 * information.
 */

namespace ErsBase\Entity\Base;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * ErsBase\Entity\Base\User
 *
 * @ORM\MappedSuperclass
 * @ORM\Table(name="`user`", indexes={@ORM\Index(name="fk_user_Country1_idx", columns={"Country_id"})}, uniqueConstraints={@ORM\UniqueConstraint(name="email_UNIQUE", columns={"email"})})
 * @ORM\HasLifecycleCallbacks
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $session_id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $username;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $email;

    /**
     * @ORM\Column(type="string", length=45, nullable=true)
     */
    protected $email_status;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $display_name;

    /**
     * @ORM\Column(type="string", length=45)
     */
    protected $firstname;

    /**
     * @ORM\Column(type="string", length=45)
     */
    protected $surname;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $gender;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $Country_id;

    /**
     * @ORM\Column(name="`password`", type="string", length=128, nullable=true)
     */
    protected $password;

    /**
     * @ORM\Column(type="string", length=45, nullable=true)
     */
    protected $hashkey;

    /**
     * @ORM\Column(name="`state`", type="string", length=45, nullable=true)
     */
    protected $state;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $active;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    protected $birthday;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $updated;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $created;

    /**
     * @ORM\OneToMany(targetEntity="Log", mappedBy="user")
     * @ORM\JoinColumn(name="id", referencedColumnName="user_id")
     */
    protected $logs;

    /**
     * @ORM\OneToMany(targetEntity="Match", mappedBy="user")
     * @ORM\JoinColumn(name="id", referencedColumnName="admin_id")
     */
    protected $matches;

    /**
     * @ORM\OneToMany(targetEntity="Order", mappedBy="user")
     * @ORM\JoinColumn(name="id", referencedColumnName="buyer_id")
     */
    protected $orders;

    /**
     * @ORM\OneToMany(targetEntity="Package", mappedBy="user", cascade={"persist", "merge"})
     * @ORM\JoinColumn(name="id", referencedColumnName="participant_id")
     */
    protected $packages;

    /**
     * @ORM\ManyToOne(targetEntity="Country", inversedBy="users")
     * @ORM\JoinColumn(name="Country_id", referencedColumnName="id", nullable=true)
     */
    protected $country;

    /**
     * @ORM\ManyToMany(targetEntity="Role", inversedBy="users")
     * @ORM\JoinTable(name="user_has_role",
     *     joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id")}
     * )
     */
    protected $roles;

    public function __construct()
    {
        $this->logs = new ArrayCollection();
        $this->matches = new ArrayCollection();
        $this->orders = new ArrayCollection();
        $this->packages = new ArrayCollection();
        $this->roles = new ArrayCollection();
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
     * @return \ErsBase\Entity\Base\User
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
     * Set the value of session_id.
     *
     * @param integer $session_id
     * @return \ErsBase\Entity\Base\User
     */
    public function setSessionId($session_id)
    {
        $this->session_id = $session_id;

        return $this;
    }

    /**
     * Get the value of session_id.
     *
     * @return integer
     */
    public function getSessionId()
    {
        return $this->session_id;
    }

    /**
     * Set the value of username.
     *
     * @param string $username
     * @return \ErsBase\Entity\Base\User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get the value of username.
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set the value of email.
     *
     * @param string $email
     * @return \ErsBase\Entity\Base\User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of email.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email_status.
     *
     * @param string $email_status
     * @return \ErsBase\Entity\Base\User
     */
    public function setEmailStatus($email_status)
    {
        $this->email_status = $email_status;

        return $this;
    }

    /**
     * Get the value of email_status.
     *
     * @return string
     */
    public function getEmailStatus()
    {
        return $this->email_status;
    }

    /**
     * Set the value of display_name.
     *
     * @param string $display_name
     * @return \ErsBase\Entity\Base\User
     */
    public function setDisplayName($display_name)
    {
        $this->display_name = $display_name;

        return $this;
    }

    /**
     * Get the value of display_name.
     *
     * @return string
     */
    public function getDisplayName()
    {
        return $this->display_name;
    }

    /**
     * Set the value of firstname.
     *
     * @param string $firstname
     * @return \ErsBase\Entity\Base\User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get the value of firstname.
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set the value of surname.
     *
     * @param string $surname
     * @return \ErsBase\Entity\Base\User
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get the value of surname.
     *
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * Set the value of gender.
     *
     * @param boolean $gender
     * @return \ErsBase\Entity\Base\User
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get the value of gender.
     *
     * @return boolean
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set the value of Country_id.
     *
     * @param integer $Country_id
     * @return \ErsBase\Entity\Base\User
     */
    public function setCountryId($Country_id)
    {
        $this->Country_id = $Country_id;

        return $this;
    }

    /**
     * Get the value of Country_id.
     *
     * @return integer
     */
    public function getCountryId()
    {
        return $this->Country_id;
    }

    /**
     * Set the value of password.
     *
     * @param string $password
     * @return \ErsBase\Entity\Base\User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of password.
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of hashkey.
     *
     * @param string $hashkey
     * @return \ErsBase\Entity\Base\User
     */
    public function setHashkey($hashkey)
    {
        $this->hashkey = $hashkey;

        return $this;
    }

    /**
     * Get the value of hashkey.
     *
     * @return string
     */
    public function getHashkey()
    {
        return $this->hashkey;
    }

    /**
     * Set the value of state.
     *
     * @param string $state
     * @return \ErsBase\Entity\Base\User
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get the value of state.
     *
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set the value of active.
     *
     * @param boolean $active
     * @return \ErsBase\Entity\Base\User
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get the value of active.
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set the value of birthday.
     *
     * @param \DateTime $birthday
     * @return \ErsBase\Entity\Base\User
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * Get the value of birthday.
     *
     * @return \DateTime
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Set the value of updated.
     *
     * @param \DateTime $updated
     * @return \ErsBase\Entity\Base\User
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
     * @return \ErsBase\Entity\Base\User
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
     * Add Log entity to collection (one to many).
     *
     * @param \ErsBase\Entity\Base\Log $log
     * @return \ErsBase\Entity\Base\User
     */
    public function addLog(Log $log)
    {
        $this->logs[] = $log;

        return $this;
    }

    /**
     * Remove Log entity from collection (one to many).
     *
     * @param \ErsBase\Entity\Base\Log $log
     * @return \ErsBase\Entity\Base\User
     */
    public function removeLog(Log $log)
    {
        $this->logs->removeElement($log);

        return $this;
    }

    /**
     * Get Log entity collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLogs()
    {
        return $this->logs;
    }

    /**
     * Add Match entity to collection (one to many).
     *
     * @param \ErsBase\Entity\Base\Match $match
     * @return \ErsBase\Entity\Base\User
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
     * @return \ErsBase\Entity\Base\User
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
     * Add Order entity to collection (one to many).
     *
     * @param \ErsBase\Entity\Base\Order $order
     * @return \ErsBase\Entity\Base\User
     */
    public function addOrder(Order $order)
    {
        $this->orders[] = $order;

        return $this;
    }

    /**
     * Remove Order entity from collection (one to many).
     *
     * @param \ErsBase\Entity\Base\Order $order
     * @return \ErsBase\Entity\Base\User
     */
    public function removeOrder(Order $order)
    {
        $this->orders->removeElement($order);

        return $this;
    }

    /**
     * Get Order entity collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOrders()
    {
        return $this->orders;
    }

    /**
     * Add Package entity to collection (one to many).
     *
     * @param \ErsBase\Entity\Base\Package $package
     * @return \ErsBase\Entity\Base\User
     */
    public function addPackage(Package $package)
    {
        $this->packages[] = $package;

        return $this;
    }

    /**
     * Remove Package entity from collection (one to many).
     *
     * @param \ErsBase\Entity\Base\Package $package
     * @return \ErsBase\Entity\Base\User
     */
    public function removePackage(Package $package)
    {
        $this->packages->removeElement($package);

        return $this;
    }

    /**
     * Get Package entity collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPackages()
    {
        return $this->packages;
    }

    /**
     * Set Country entity (many to one).
     *
     * @param \ErsBase\Entity\Base\Country $country
     * @return \ErsBase\Entity\Base\User
     */
    public function setCountry(Country $country = null)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get Country entity (many to one).
     *
     * @return \ErsBase\Entity\Base\Country
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Add Role entity to collection.
     *
     * @param \ErsBase\Entity\Base\Role $role
     * @return \ErsBase\Entity\Base\User
     */
    public function addRole(Role $role)
    {
        $role->addUser($this);
        $this->roles[] = $role;

        return $this;
    }

    /**
     * Remove Role entity from collection.
     *
     * @param \ErsBase\Entity\Base\Role $role
     * @return \ErsBase\Entity\Base\User
     */
    public function removeRole(Role $role)
    {
        $role->removeUser($this);
        $this->roles->removeElement($role);

        return $this;
    }

    /**
     * Get Role entity collection.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRoles()
    {
        return $this->roles;
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
        $dataFields = array('id', 'session_id', 'username', 'email', 'email_status', 'display_name', 'firstname', 'surname', 'gender', 'Country_id', 'password', 'hashkey', 'state', 'active', 'birthday', 'updated', 'created');
        $relationFields = array('country');
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
        return array('id', 'session_id', 'username', 'email', 'email_status', 'display_name', 'firstname', 'surname', 'gender', 'Country_id', 'password', 'hashkey', 'state', 'active', 'birthday', 'updated', 'created');
    }
}