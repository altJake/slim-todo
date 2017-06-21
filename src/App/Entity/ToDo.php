<?php
namespace App\Entity;
use App\Entity;
use Doctrine\ORM\Mapping;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 * @Table(name="todos")
 */
class Todo extends Entity
{
  /**
  * @Column(type="string", length=255)
  * @var string
  */
  protected $subject;

  /**
  * @Column(type="boolean", name="is_done")
  * @var boolean
  */
  protected $isDone;

  /**
  * @ManyToMany(targetEntity="Category")
  * @JoinTable(name="todos_categories",
  *   joinColumns={@JoinColumn(name="todo_id", referencedColumnName="id")},
  *   inverseJoinColumns={@JoinColumn(name="category_id", referencedColumnName="id")}
  * )
  */
  public $categories;

  public function __construct()
  {
    parent::__construct();
    $this->categories = new ArrayCollection();
    $this->setIsDone(false);
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
    if(!empty($subject))
      $this->subject = $subject;
  }

  /**
  * @return boolean
  */
  public function getIsDone()
  {
    return $this->isDone;
  }

  /**
  * @param boolean $isDone
  */
  public function setIsDone($isDone)
  {
    if($isDone != null)
      $this->isDone = $isDone;
  }

  public function jsonSerialize()
  {
    $entity = parent::jsonSerialize();

    $entity['categories'] =
      array_map(function($category) { return $category->jsonSerialize(); },
                $this->categories->getValues());

    return $entity;
  }
}
