<?php

namespace Symfony\Components\Routing\Matcher\Dumper;

/*
 * This file is part of the symfony framework.
 *
 * (c) Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

/**
 * MatcherDumperInterface is the interface that all matcher dumper classes must implement.
 *
 * @package    symfony
 * @subpackage routing
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 */
interface MatcherDumperInterface
{
  /**
   * Dumps a set of routes to a PHP class.
   *
   * Available options:
   *
   *  * class:      The class name
   *  * base_class: The base class name
   *
   * @param  array  $options An array of options
   *
   * @return string A PHP class representing the matcher class
   */
  function dump(array $options = array());
}
