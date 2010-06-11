<?php 
/**
* Blog Post Class
* 
* @Entity
* @Table(name="posts")
* @HasLifecycleCallbacks
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
	
	/** @Column(name="created_at", type="datetime") */
	protected $createdAt;
	
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
	
	/**
	 * Just a convenience function I like to have. 
	 *
	 * @param array $values 
	 * @return $this 
	 * @author Bryan Zarzuela
	 */
	public function fromArray($values)
	{
		foreach ($values as $field => $value) {
			$func = 'set' . ucfirst($field);
			$this->$func($value);
		}
		return $this;
	}
	
	/**
	 * Initializes the default values of this class before persisting.
	 *
	 * @PrePersist
	 */
	public function initDefaults()
	{
		$this->setCreatedAt(new DateTime());
	}
}
