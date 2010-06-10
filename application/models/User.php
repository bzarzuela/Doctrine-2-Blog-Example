<?php 
/**
* User Class
* 
* @Entity
* @Table(name="users")
*/
class D2Test_Model_User
{
	/** 
	* @Id @Column(type="integer") 
	* @GeneratedValue
	*/
	private $id;
	
	/** @Column(length=50) */
	private $name;
	
	public function getName()
	{
		return $this->name;
	}
	
	public function setName($val)
	{
		$this->name = $val;
		return $this;
	}
}
