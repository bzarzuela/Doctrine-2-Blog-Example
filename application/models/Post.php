<?php 
/**
* Blog Post Class
* 
* @Entity
* @Table(name="posts")
*/
class D2Test_Model_Post
{
	/** 
	* @Id @Column(type="integer") 
	* @GeneratedValue
	*/
	private $id;
	
	/** @Column(length=50) */
	private $title;
	
	/** @Column(length=50) */
	private $body;
	
	public function getId()
	{
		return $this->id;
	}
	
	public function getTitle()
	{
		return $this->title;
	}
	
	public function setTitle($val)
	{
		$this->title = $val;
		return $this;
	}
	
	public function getBody()
	{
		return $this->body;
	}
	
	public function setBody($val)
	{
		$this->body = $val;
		return $this;
	}
}
