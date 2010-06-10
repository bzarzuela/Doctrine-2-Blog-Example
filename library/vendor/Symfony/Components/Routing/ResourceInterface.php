<?php

namespace Symfony\Components\Routing;

/*
 * This file is part of the symfony framework.
 *
 * (c) Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

/**
 * ResourceInterface is the interface that must be implemented by all Resource classes.
 *
 * @package    symfony
 * @subpackage routing
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 */
interface ResourceInterface
{
  /**
   * Returns true if the resource has not been updated since the given timestamp.
   *
   * @param timestamp $timestamp The last time the resource was loaded
   *
   * @return Boolean true if the resource has not been updated, false otherwise
   */
  function isUptodate($timestamp);

  /**
   * Returns the resource tied to this Resource.
   *
   * @return mixed The resource
   */
  function getResource();
}
