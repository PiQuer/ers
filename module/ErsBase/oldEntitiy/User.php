<?php
/**
 * BjyAuthorize Module (https://github.com/bjyoungblood/BjyAuthorize)
 *
 * @link https://github.com/bjyoungblood/BjyAuthorize for the canonical source repository
 * @license http://framework.zend.com/license/new-bsd New BSD License
 */
 
namespace ErsBase\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use BjyAuthorize\Provider\Role\ProviderInterface;
use ZfcUser\Entity\UserInterface;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterInterface;

/**
 * An example of how to implement a role aware user entity.
 *
 * @ORM\Entity
 * @ORM\Table(name="users", indexes={
 *      @ORM\Index(name="fk_User_Country1_idx", columns={"Country_id"}), 
 * }, uniqueConstraints={@ORM\UniqueConstraint(name="email_UNIQUE", columns={"email"})})
 * @ORM\HasLifecycleCallbacks()
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class User implements UserInterface, ProviderInterface
{
    /**
     * Instance of InputFilterInterface.
     *
     * @var InputFilter
     */
    private $inputFilter;
    
    /**
     * Length of hashkey
     * 
     * @var length
     */
    private $length = 30;
    
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     *
     * @var int
     * variable to keep an id which is only used while this entity is hold in 
     * a session container.
     */
    protected $session_id;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, unique=true, nullable=true)
     */
    protected $username;

    /**
     * @var string
     * @ORM\Column(type="string", unique=true, length=255, nullable=true)
     */
    protected $email;

    /**
     * @var string
     * @ORM\Column(type="string", length=45, nullable=true)
     */
    protected $email_status;
    
    /**
     * @var string
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    protected $displayName;

    /**
     * @ORM\Column(type="string", length=45, nullable=true)
     */
    protected $firstname;

    /**
     * @ORM\Column(type="string", length=45, nullable=true)
     */
    protected $surname;
    
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $Country_id;
    
    /**
     * @var string
     * @ORM\Column(type="string", length=128, nullable=true)
     */
    protected $password;

    /**
     * @var string
     * @ORM\Column(type="string", length=45, nullable=true)
     */
    protected $hashkey;
    
    /**
     * @var int
     */
    protected $state;
    
    /**
     * @ORM\Column(type="boolean")
     */
    protected $active = 1;

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
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\ManyToMany(targetEntity="Role", inversedBy="users")
     * @ORM\JoinTable(name="user_role_linker",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id")}
     * )
     */
    protected $roles;
    
    /**
     * @var ErsBase\Country
     * @ORM\ManyToOne(targetEntity="Country", inversedBy="users")
     * @ORM\JoinColumn(name="Country_id", referencedColumnName="id")
     */
    protected $country;
    
    /**
     * @ORM\OneToMany(targetEntity="Log", mappedBy="user")
     * @ORM\JoinColumn(name="id", referencedColumnName="User_id")
     */
    protected $logs;

    /**
     * @ORM\OneToMany(targetEntity="Match", mappedBy="user")
     * @ORM\JoinColumn(name="id", referencedColumnName="Admin_id")
     */
    protected $matches;

    /**
     * @ORM\OneToMany(targetEntity="Order", mappedBy="buyer")
     * @ORM\JoinColumn(name="id", referencedColumnName="Buyer_id")
     */
    protected $orders;

    /**
     * @ORM\OneToMany(targetEntity="Package", mappedBy="participant")
     * @ORM\JoinColumn(name="id", referencedColumnName="Participant_id")
     */
    protected $packages;

    /**
     * Initialies the roles variable.
     */
    public function __construct()
    {
        $this->session_id = null;
        $this->roles = new ArrayCollection();
        $this->logs = new ArrayCollection();
        $this->matches = new ArrayCollection();
        $this->orders = new ArrayCollection();
        $this->packages = new ArrayCollection();
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
     * Set id of this object to null if it's cloned
     */
    public function __clone() {
        $this->id = null;
    }
    
    /**
     * implement __toString for error reporting
     */
    public function __toString() {
        return $this->getFirstname().' '.$this->getSurname().' ('.$this->getEmail().')';
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    public function getUserId()
    {
        return $this->getId();
    }
    
    /**
     * Set id.
     *
     * @param int $id
     *
     * @return void
     */
    public function setId($id)
    {
        $this->id = (int) $id;
    }
    public function setUserId($id)
    {
        $this->setId($id);
    }

    /**
     * Get session_id
     * 
     * @return int
     */
    public function getSessionId()
    {
        return $this->session_id;
    }
    
    /**
     * Set session_id.
     *
     * @param int $id
     *
     * @return void
     */
    public function setSessionId($id) {
        $this->session_id = $id;
    }
    
    /**
     * Get username.
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set username.
     *
     * @param string $username
     *
     * @return void
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * Get email.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set email.
     *
     * @param string $email
     *
     * @return void
     */
    public function setEmail($email)
    {
        if($email == '') {
            $this->email = null;
        } else {
            $this->email = $email;
        }
    }
    
    /**
     * Get email_status.
     *
     * @return string
     */
    public function getEmailStatus()
    {
        return $this->email_status;
    }

    /**
     * Set email_status.
     *
     * @param string $email_status
     *
     * @return void
     */
    public function setEmailStatus($email_status)
    {
        $this->email_status = $email_status;
    }

    /**
     * Get displayName.
     *
     * @return string
     */
    public function getDisplayName()
    {
        return $this->displayName;
    }

    /**
     * Set displayName.
     *
     * @param string $displayName
     *
     * @return void
     */
    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;
    }

    /**
     * Set the value of firstname.
     *
     * @param string $firstname
     * @return \Entity\User
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
     * @return \Entity\User
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
    
    public function getFullName() {
        return $this->getFirstname() . ' ' . $this->getSurname();
    }
    
    /**
     * Set the value of Country_id.
     *
     * @param integer $Country_id
     * @return \Entity\User
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
     * Get password.
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set password.
     *
     * @param string $password
     *
     * @return void
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * Get hashkey.
     *
     * @return string
     */
    public function getHashkey()
    {
        return $this->hashkey;
    }
    
    /**
     * Generate hashkey
     */
    public function genHashkey() {
        $alphabet = "0123456789ACDFGHKMNPRUVWXY";
        $memory = '';
        $n = '';
        #srand(time());
        srand(rand()*time());
        for ($i = 0; $i < $this->length; $i++) {
            
            while($n == '' || $memory == $alphabet[$n]) {
                $n = rand(0, strlen($alphabet)-1);
            }
            $memory = $alphabet[$n];
            $code[$i] = $alphabet[$n];
        }
        
        $this->setHashkey(implode($code));
    }

    /**
     * Set hashkey.
     *
     * @param string $hashkey
     *
     * @return void
     */
    public function setHashkey($hashkey)
    {
        $this->hashkey = $hashkey;
    }
    
    /**
     * Get state.
     *
     * @return int
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set state.
     *
     * @param int $state
     *
     * @return void
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * Set the value of active.
     *
     * @param boolean $active
     * @return \Entity\User
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
     * @param datetime $birthday
     * @return \Entity\User
     */
    public function setBirthday($birthday)
    {
        if($birthday instanceof \DateTime) {
            $this->birthday = $birthday;
        } elseif(is_string($birthday)) {
            $this->birthday = \DateTime::createFromFormat('d.m.Y', $birthday);
            #$this->birthday = new \DateTime($birthday);
        }

        return $this;
    }

    /**
     * Get the value of birthday.
     *
     * @return datetime
     */
    public function getBirthday()
    {
        return $this->birthday;
    }
    
    /**
     * Get the age of the user relative to a date, or null if no birthday is set.
     * 
     * @param \DateTime $now the date to use for the current date; default: now
     * @return int|null
     */
    public function getAge(\DateTime $now = NULL)
    {
        if(!$now)
            $now = new \DateTime();
        if(!$this->birthday)
            return null;
        
        return (int) $now->diff($this->birthday)->format('%y');
    }
    
    /**
     * Set the value of updated.
     *
     * @param datetime $updated
     * @return \Entity\ProductVariant
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get the value of updated.
     *
     * @return datetime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set the value of created.
     *
     * @param datetime $created
     * @return \Entity\ProductVariant
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get the value of created.
     *
     * @return datetime
     */
    public function getCreated()
    {
        return $this->created;
    }
    
    /**
     * Get roles.
     *
     * @return array of \Entity\Role
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Add a role to the user.
     *
     * @param Role $role
     *
     * @return void
     */
    public function addRole(Role $role)
    {
        $this->roles[] = $role;
    }
    
    public function hasRole(Role $role) {
        $index = $this->roles->indexOf($role);
        return is_numeric($index);
    }
    
    /**
     * Set Country entity (many to one).
     *
     * @param \Entity\Country $country
     * @return \Entity\User
     */
    public function setCountry(Country $country = null)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get Country entity (many to one).
     *
     * @return \Entity\Country
     */
    public function getCountry()
    {
        return $this->country;
    }

    
    /**
     * Add Log entity to collection (one to many).
     *
     * @param \Entity\Log $log
     * @return \Entity\User
     */
    public function addLog(Log $log)
    {
        $this->logs[] = $log;

        return $this;
    }

    /**
     * Remove Log entity from collection (one to many).
     *
     * @param \Entity\Log $log
     * @return \Entity\User
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
     * @param \Entity\Match $match
     * @return \Entity\User
     */
    public function addMatch(Match $match)
    {
        $this->matches[] = $match;

        return $this;
    }

    /**
     * Remove Match entity from collection (one to many).
     *
     * @param \Entity\Match $match
     * @return \Entity\User
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
     * @param \Entity\Order $order
     * @return \Entity\User
     */
    public function addOrder(Order $order)
    {
        $this->orders[] = $order;

        return $this;
    }

    /**
     * Remove Order entity from collection (one to many).
     *
     * @param \Entity\Order $order
     * @return \Entity\User
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
     * @param \Entity\Package $package
     * @return \Entity\User
     */
    public function addPackage(Package $package)
    {
        $this->packages[] = $package;

        return $this;
    }

    /**
     * Remove Package entity from collection (one to many).
     *
     * @param \Entity\Package $package
     * @return \Entity\User
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
     * Not used, Only defined to be compatible with InputFilterAwareInterface.
     * 
     * @param \Zend\InputFilter\InputFilterInterface $inputFilter
     * @throws \Exception
     */
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used.");
    }

    /**
     * Return a for this entity configured input filter instance.
     *
     * @return InputFilterInterface
     */
    public function getInputFilter()
    {
        if ($this->inputFilter instanceof InputFilterInterface) {
            return $this->inputFilter;
        }
        $factory = new InputFactory();
        $filters = array(
            array(
                'name' => 'id',
                'required' => true,
                'filters' => array(),
                'validators' => array(),
            ),
            array(
                'name' => 'username',
                'required' => false,
                'filters' => array(),
                'validators' => array(),
            ),
            array(
                'name' => 'email',
                'required' => false,
                'filters' => array(),
                'validators' => array(),
            ),
            array(
                'name' => 'displayName',
                'required' => false,
                'filters' => array(),
                'validators' => array(),
            ),
            array(
                'name' => 'password',
                'required' => false,
                'filters' => array(),
                'validators' => array(),
            ),
            array(
                'name' => 'state',
                'required' => false,
                'filters' => array(),
                'validators' => array(),
            ),
            array(
                'name' => 'firstname',
                'required' => true,
                'filters' => array(),
                'validators' => array(),
            ),
            array(
                'name' => 'surname',
                'required' => true,
                'filters' => array(),
                'validators' => array(),
            ),
            array(
                'name' => 'active',
                'required' => false,
                'filters' => array(),
                'validators' => array(),
            ),
            array(
                'name' => 'birthday',
                'required' => true,
                'filters' => array(),
                'validators' => array(),
            ),
            array(
                'name' => 'updated',
                'required' => false,
                'filters' => array(),
                'validators' => array(),
            ),
            array(
                'name' => 'created',
                'required' => false,
                'filters' => array(),
                'validators' => array(),
            ),
        );
        $this->inputFilter = $factory->createInputFilter($filters);

        return $this->inputFilter;
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
        $dataFields = array('id', 'session_id', 'username', 'email', 'displayName', 'password', 'hashkey', 'state', 'firstname', 'surname', 'Country_id', 'active', 'birthday', 'updated', 'created');
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
        return array(
            'id', 
            'session_id', 
            'username', 
            'email', 
            'displayName', 
            'password', 
            'hashkey', 
            'state', 
            'firstname', 
            'surname', 
            'Country_id', 
            'active', 
            'birthday', 
            'updated', 
            'created'
        );
    }
}
