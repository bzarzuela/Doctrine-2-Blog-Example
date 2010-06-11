<?php

namespace Symfony\Components\DependencyInjection\Loader;

/*
 * This file is part of the symfony framework.
 *
 * (c) Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

/**
 * LoaderInterface is the interface implemented by all loader classes.
 *
 * $loader = new XXXLoader();
 * $config = $loader->load('resource_name');
 *
 * $container = new Builder();
 * $container->merge($config);
 *
 * @package    symfony
 * @subpackage dependency_injection
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 */
interface LoaderInterface
{
  /**
   * Loads a resource.
   *
   * A resource can be anything that can be converted to a
   * BuilderConfiguration instance.
   *
   * Some loaders support an array of resources as an argument to the
   * constructor.
   *
   * If multiple resources are loaded, the services and parameters are merged.
   *
   * Remember that services and parameters are simple key/pair stores.
   *
   * When overriding a value, the old one is totally replaced, even if it is
   * a "complex" value (an array for instance):
   *
   * <pre>
   *   file1.xml
   *   <parameter key="complex" type="collection">
   *     <parameter>true</parameter>
   *     <parameter>false</parameter>
   *   </parameter>
   *
   *   file2.xml
   *   <parameter key="complex">foo</parameter>
   * </pre>
   *
   * If you load file1.xml and file2.xml in this order, the value of complex
   * will be "foo".
   *
   * @param mixed $resource The resource
   *
   * @return BuilderConfiguration A BuilderConfiguration instance
   */
  function load($resource);

  static function registerExtension(LoaderExtensionInterface $extension);
}
