<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Orders
 *
 * @ORM\Table(name="order_list")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OrderRepository")
 */
class Order
{


    CONST STATUS_NEW = 'new';
    CONST STATUS_ASSIGNED = 'assigned';
    CONST STATUS_PICKED = 'picked';
    CONST STATUS_FINISHED = 'finished';
    CONST STATUS_CANCELED = 'canceled';

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="Driver", inversedBy="orderCollection")
     * @ORM\JoinColumn(name="driver_id", referencedColumnName="id")
     */
    private $driver;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=64)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=64)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="pickup_address", type="string", length=255)
     */
    private $pickupAddress;

    /**
     * @var float
     *
     * @ORM\Column(name="pickup_latitude", type="float")
     */
    private $pickupLatitude;

    /**
     * @var string
     *
     * @ORM\Column(name="pickup_longitude", type="float")
     */
    private $pickupLongitude;

    /**
     * @var string
     *
     * @ORM\Column(name="destination_address", type="string", length=255)
     */
    private $destinationAddress;

    /**
     * @var float
     *
     * @ORM\Column(name="destination_latitude", type="float")
     */
    private $destinationLatitude;

    /**
     * @var float
     *
     * @ORM\Column(name="destination_longitude", type="float")
     */
    private $destinationLongitude;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="string", length=255, nullable=true)
     */
    private $comment;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=24)
     */
    private $status;

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
     * @return Order
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
     * @return Order
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
     * Set pickupAddress
     *
     * @param string $pickupAddress
     *
     * @return Order
     */
    public function setPickupAddress($pickupAddress)
    {
        $this->pickupAddress = $pickupAddress;

        return $this;
    }

    /**
     * Get pickupAddress
     *
     * @return string
     */
    public function getPickupAddress()
    {
        return $this->pickupAddress;
    }

    /**
     * Set pickupLatitude
     *
     * @param float $pickupLatitude
     *
     * @return Order
     */
    public function setPickupLatitude($pickupLatitude)
    {
        $this->pickupLatitude = $pickupLatitude;

        return $this;
    }

    /**
     * Get pickupLatitude
     *
     * @return float
     */
    public function getPickupLatitude()
    {
        return $this->pickupLatitude;
    }

    /**
     * Set pickupLongitude
     *
     * @param float $pickupLongitude
     *
     * @return Order
     */
    public function setPickupLongitude($pickupLongitude)
    {
        $this->pickupLongitude = $pickupLongitude;

        return $this;
    }

    /**
     * Get pickupLongitude
     *
     * @return float
     */
    public function getPickupLongitude()
    {
        return $this->pickupLongitude;
    }

    /**
     * Set destinationAddress
     *
     * @param string $destinationAddress
     *
     * @return Order
     */
    public function setDestinationAddress($destinationAddress)
    {
        $this->destinationAddress = $destinationAddress;

        return $this;
    }

    /**
     * Get destinationAddress
     *
     * @return string
     */
    public function getDestinationAddress()
    {
        return $this->destinationAddress;
    }

    /**
     * Set destinationLatitude
     *
     * @param float $destinationLatitude
     *
     * @return Order
     */
    public function setDestinationLatitude($destinationLatitude)
    {
        $this->destinationLatitude = $destinationLatitude;

        return $this;
    }

    /**
     * Get destinationLatitude
     *
     * @return float
     */
    public function getDestinationLatitude()
    {
        return $this->destinationLatitude;
    }

    /**
     * Set destinationLongitude
     *
     * @param float $destinationLongitude
     *
     * @return Order
     */
    public function setDestinationLongitude($destinationLongitude)
    {
        $this->destinationLongitude = $destinationLongitude;

        return $this;
    }

    /**
     * Get destinationLongitude
     *
     * @return float
     */
    public function getDestinationLongitude()
    {
        return $this->destinationLongitude;
    }

    /**
     * Set comment
     *
     * @param string $comment
     *
     * @return Order
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return Order
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set dateUpdated
     *
     * @param \DateTime $dateUpdated
     *
     * @return Order
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
     * @return Order
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
     * Set driver
     *
     * @param \AppBundle\Entity\Driver $driver
     *
     * @return Order
     */
    public function setDriver(\AppBundle\Entity\Driver $driver = null)
    {
        $this->driver = $driver;

        return $this;
    }

    /**
     * Get driver
     *
     * @return \AppBundle\Entity\Driver
     */
    public function getDriver()
    {
        return $this->driver;
    }

    public static function getStatusCollection(){
        return [
            self::STATUS_NEW,
            self::STATUS_ASSIGNED,
            self::STATUS_PICKED,
            self::STATUS_FINISHED,
            self::STATUS_CANCELED,
        ];
    }
}
