<?php
namespace App\Entity;
use App\Entity;
use Doctrine\ORM\Mapping;

/**
 * @Entity
 * @Table(name="todo")
 */
class Todo extends Entity
{
  /**
  * @Column(type="string", length=255)
  * @var string
  */
  protected $subject;

  /**
  * @Column(type="boolean")
  * @var boolean
  */
  protected $isDone;

  /**
  * @OneToMany(targetEntity="Category", mappedBy="todo")
  */
  public $categories;

  public function __construct()
  {
    parent::__construct();
    $this->categories = new ArrayCollection();
  }

  /**
  * @return string
  */
  public function getSubject()
  {
    return $this->subject;
  }

  /**
  * @param string $subject
  */
  public function setSubject($subject)
  {
    $this->subject = $subject;
  }

  /**
  * @return string
  */
  public function getIsDone()
  {
    return $this->isDone;
  }

  /**
  * @param string $isDone
  */
  public function setIsDone($isDone)
  {
    $this->isDone = $isDone;
  }
}
