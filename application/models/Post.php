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
	
	private $_em;
	
	/**
	 * Returns all of the posts from the database. 
	 * Yes, I know it's dependent on Zend_Registry.
	 * I'll figure out something else later.
	 *
	 * @return array
	 * @author Bryan Zarzuela
	 */
	public static function findAll()
	{
		$em = Zend_Registry::get('EntityManager');
		return $em->createQuery("SELECT p FROM D2Test_Model_Post p")->getResult();
	}
}
