<?php 
/**
* Blog Post Class
* 
* @Entity
* @Table(name="posts")
*/
class D2Test_Model_Post extends Boz_Model_Doctrine2
{
	/** 
	* @Id @Column(type="integer") 
	* @GeneratedValue
	*/
	protected $id;
	
	/** @Column(length=50) */
	protected $title;
	
	/** @Column(length=50) */
	protected $body;
	
}
