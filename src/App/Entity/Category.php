<?php
namespace App\Entity;

use App\Entity;
use Doctrine\ORM\Mapping;

/**
 * @Entity
 * @Table(name="category")
 */
class Category extends Entity
{
  /**
  * @Column(type="string", length=255)
  * @var string
  */
  protected $name;

  public function __construct()
  {
    parent::__construct();
  }

  /**
  * @return string
  */
  public function getName()
  {
    return $this->name;
  }

  /**
  * @param string $name
  */
  public function setName($name)
  {
    $this->name = $name;
  }
}
