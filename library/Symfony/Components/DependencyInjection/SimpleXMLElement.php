<?php

namespace Symfony\Components\DependencyInjection;

/*
 * This file is part of the symfony framework.
 *
 * (c) Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

class SimpleXMLElement extends \SimpleXMLElement
{
  public function getAttributeAsPhp($name)
  {
    return self::phpize($this[$name]);
  }

  public function getArgumentsAsPhp($name)
  {
    $arguments = array();
    foreach ($this->$name as $arg)
    {
      $key = isset($arg['key']) ? (string) $arg['key'] : (!$arguments ? 0 : max(array_keys($arguments)) + 1);

      // parameter keys are case insensitive
      if ('parameter' == $name)
      {
        $key = strtolower($key);
      }

      switch ($arg['type'])
      {
        case 'service':
          $invalidBehavior = Container::EXCEPTION_ON_INVALID_REFERENCE;
          if (isset($arg['on-invalid']) && 'ignore' == $arg['on-invalid'])
          {
            $invalidBehavior = Container::IGNORE_ON_INVALID_REFERENCE;
          }
          elseif (isset($arg['on-invalid']) && 'null' == $arg['on-invalid'])
          {
            $invalidBehavior = Container::NULL_ON_INVALID_REFERENCE;
          }
          $arguments[$key] = new Reference((string) $arg['id'], $invalidBehavior);
          break;
        case 'collection':
          $arguments[$key] = $arg->getArgumentsAsPhp($name);
          break;
        case 'string':
          $arguments[$key] = (string) $arg;
          break;
        case 'constant':
          $arguments[$key] = constant((string) $arg);
          break;
        default:
          $arguments[$key] = self::phpize($arg);
      }
    }

    return $arguments;
  }

  static public function phpize($value)
  {
    $value = (string) $value;

    switch (true)
    {
      case 'null' == strtolower($value):
        return null;
      case ctype_digit($value):
        return '0' == $value[0] ? octdec($value) : intval($value);
      case 'true' === strtolower($value):
        return true;
      case 'false' === strtolower($value):
        return false;
      case is_numeric($value):
        return '0x' == $value[0].$value[1] ? hexdec($value) : floatval($value);
      case preg_match('/^(-|\+)?[0-9,]+(\.[0-9]+)?$/', $value):
        return floatval(str_replace(',', '', $value));
      default:
        return (string) $value;
    }
  }
}
