<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Driver
 *
 * @ORM\Table(name="driver")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DriverRepository")
 */
class Driver
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Order", mappedBy="driverId")
     */
    private $orderCollection;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255)
     */
    private $phone;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_working", type="boolean")
     */
    private $isWorking;

    /**
     * @var string
     *
     * @ORM\Column(name="imei", type="string", length=255)
     */
    private $imei;

    /**
     * @var float
     *
     * @ORM\Column(name="latitude", type="float", nullable=true)
     */
    private $latitude;

    /**
     * @var float
     *
     * @ORM\Column(name="longitude", type="float", nullable=true)
     */
    private $longitude;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_updated", type="datetime", nullable=true)
     */
    private $dateUpdated;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_created", type="datetime")
     */
    private $dateCreated;

    ///////////////////////////////////////////////

    public $orderCount = 0;

    ///////////////////////////////////////////////



    /**
     * Constructor
     */
    public function __construct()
    {
        $this->orderCollection = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Driver
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return Driver
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set isWorking
     *
     * @param boolean $isWorking
     *
     * @return Driver
     */
    public function setIsWorking($isWorking)
    {
        $this->isWorking = $isWorking;

        return $this;
    }

    /**
     * Get isWorking
     *
     * @return boolean
     */
    public function isWorking()
    {
        return $this->isWorking;
    }

    /**
     * Set imei
     *
     * @param string $imei
     *
     * @return Driver
     */
    public function setImei($imei)
    {
        $this->imei = $imei;

        return $this;
    }

    /**
     * Get imei
     *
     * @return string
     */
    public function getImei()
    {
        return $this->imei;
    }

    /**
     * Set latitude
     *
     * @param float $latitude
     *
     * @return Driver
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param float $longitude
     *
     * @return Driver
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return Driver
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function isActive()
    {
        return $this->isActive;
    }

    /**
     * Set dateUpdated
     *
     * @param \DateTime $dateUpdated
     *
     * @return Driver
     */
    public function setDateUpdated($dateUpdated)
    {
        $this->dateUpdated = $dateUpdated;

        return $this;
    }

    /**
     * Get dateUpdated
     *
     * @return \DateTime
     */
    public function getDateUpdated()
    {
        return $this->dateUpdated;
    }

    /**
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     *
     * @return Driver
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    /**
     * Get dateCreated
     *
     * @return \DateTime
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * Add orderCollection
     *
     * @param \AppBundle\Entity\Order $orderCollection
     *
     * @return Driver
     */
    public function addOrderCollection(\AppBundle\Entity\Order $orderCollection)
    {
        $this->orderCollection[] = $orderCollection;

        return $this;
    }

    /**
     * Remove orderCollection
     *
     * @param \AppBundle\Entity\Order $orderCollection
     */
    public function removeOrderCollection(\AppBundle\Entity\Order $orderCollection)
    {
        $this->orderCollection->removeElement($orderCollection);
    }

    /**
     * Get orderCollection
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOrderCollection()
    {
        return $this->orderCollection;
    }
}
