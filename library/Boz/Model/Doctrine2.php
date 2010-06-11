<?php
/**
* Doctrine 2 base class for easy development.
*/
abstract class Boz_Model_Doctrine2
{
	/**
	 * Implements magic setters and getters
	 *
	 * @param string $name 
	 * @param string $args 
	 * @return void
	 * @author Bryan Zarzuela
	 */
	public function __call($name, $args)
	{
		$prefix = substr($name, 0, 3);
		
		switch ($prefix) {
			case 'set':
				if (method_exists($this, $name)) {
					return call_user_func(array($this, $name), $args);
				} else {
					$varName = strtolower(substr($name, 3, 1)) . substr($name, 4);
					$reflection = new ReflectionClass($this);
					if ($reflection->hasProperty($varName)) {
						$this->$varName = $args[0];
						return $this;
					} else {
						throw new Exception("This property does not exist: $varName");
					}
				}
				break;
			
			case 'get':
				
				if (method_exists($this, $name)) {
					return $this->$name;
				} else {
					$varName = strtolower(substr($name, 3, 1)) . substr($name, 4);
					if (isset($this->$varName)) {
						return $this->$varName;
					} else {
						throw new Exception("This property does not exist: $varName");
					}
				}
				break;
				
			default:
				if (method_exists($this, $name)) {
					return $this->$name;
				} else {
					throw new Exception("This method does not exist: $name");
				}
				break;
		}
	}
}
