<?php

namespace Symfony\Framework\WebBundle\Command;

use Symfony\Components\Console\Input\InputArgument;
use Symfony\Components\Console\Input\InputOption;
use Symfony\Components\Console\Input\InputInterface;
use Symfony\Components\Console\Output\OutputInterface;
use Symfony\Components\Console\Output\Output;
use Symfony\Components\Routing\Matcher\Dumper\ApacheMatcherDumper;

/*
 * This file is part of the symfony framework.
 *
 * (c) Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

/**
 * 
 *
 * @package    symfony
 * @subpackage console
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 */
class RouterDebugCommand extends Command
{
  /**
   * @see Command
   */
  protected function configure()
  {
    $this
      ->setDefinition(array(
        new InputArgument('name', InputArgument::OPTIONAL, 'A route name'),
      ))
      ->setName('router:debug')
      ->setDescription('Displays current routes for an application')
      ->setHelp(<<<EOF
The [router:debug|INFO] displays the configured routes:

  [router:debug|INFO]
EOF
      )
    ;
  }

  /**
   * @see Command
   */
  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $router = $this->container->getService('router');

    $routes = array();
    foreach ($router->getRouteCollection()->getRoutes() as $name => $route)
    {
      $routes[$name] = $route->compile();
    }

    if ($input->getArgument('name'))
    {
      $this->outputRoute($output, $routes, $input->getArgument('name'));
    }
    else
    {
      $this->outputRoutes($output, $routes);
    }
  }

  protected function outputRoutes(OutputInterface $output, $routes)
  {
    $output->writeln($this->getHelper('formatter')->formatSection('router', 'Current routes'));

    $maxName = 4;
    $maxMethod = 6;
    foreach ($routes as $name => $route)
    {
      $requirements = $route->getRequirements();
      $method = isset($requirements['_method']) ? strtoupper(is_array($requirements['_method']) ? implode(', ', $requirements['_method']) : $requirements['_method']) : 'ANY';

      if (strlen($name) > $maxName)
      {
        $maxName = strlen($name);
      }

      if (strlen($method) > $maxMethod)
      {
        $maxMethod = strlen($method);
      }
    }
    $format  = '%-'.$maxName.'s %-'.$maxMethod.'s %s';

    // displays the generated routes
    $format1  = '%-'.($maxName + 9).'s %-'.($maxMethod + 9).'s %s';
    $output->writeln(sprintf($format1, '<comment>Name</comment>', '<comment>Method</comment>', '<comment>Pattern</comment>'));
    foreach ($routes as $name => $route)
    {
      $requirements = $route->getRequirements();
      $method = isset($requirements['_method']) ? strtoupper(is_array($requirements['_method']) ? implode(', ', $requirements['_method']) : $requirements['_method']) : 'ANY';
      $output->writeln(sprintf($format, $name, $method, $route->getPattern()));
    }
  }

  protected function outputRoute(OutputInterface $output, $routes, $name)
  {
    $output->writeln($this->getHelper('formatter')->formatSection('router', sprintf('Route "%s"', $name)));

    if (!isset($routes[$name]))
    {
      throw new \InvalidArgumentException(sprintf('The route "%s" does not exist.', $name));
    }

    $route = $routes[$name];
    $output->writeln(sprintf('<comment>Name</comment>         %s', $name));
    $output->writeln(sprintf('<comment>Pattern</comment>      %s', $route->getPattern()));
    $output->writeln(sprintf('<comment>Class</comment>        %s', get_class($route)));

    $defaults = '';
    $d = $route->getDefaults();
    ksort($d);
    foreach ($d as $name => $value)
    {
      $defaults .= ($defaults ? "\n".str_repeat(' ', 13) : '').$name.': '.$this->formatValue($value);
    }
    $output->writeln(sprintf('<comment>Defaults</comment>     %s', $defaults));

    $requirements = '';
    $r = $route->getRequirements();
    ksort($r);
    foreach ($r as $name => $value)
    {
      $requirements .= ($requirements ? "\n".str_repeat(' ', 13) : '').$name.': '.$this->formatValue($value);
    }
    $output->writeln(sprintf('<comment>Requirements</comment> %s', $requirements));

    $options = '';
    $o = $route->getOptions();
    ksort($o);
    foreach ($o as $name => $value)
    {
      $options .= ($options ? "\n".str_repeat(' ', 13) : '').$name.': '.$this->formatValue($value);
    }
    $output->writeln(sprintf('<comment>Options</comment>      %s', $options));
    $output->write('<comment>Regex</comment>        ');
    $output->writeln(preg_replace('/^             /', '', preg_replace('/^/m', '             ', $route->getRegex())), Output::OUTPUT_RAW);

    $tokens = '';
    foreach ($route->getTokens() as $token)
    {
      if (!$tokens)
      {
        $tokens = $this->displayToken($token);
      }
      else
      {
        $tokens .= "\n".str_repeat(' ', 13).$this->displayToken($token);
      }
    }
    $output->writeln(sprintf('<comment>Tokens</comment>       %s', $tokens));
  }

  protected function displayToken($token)
  {
    $type = array_shift($token);
    array_shift($token);

    return sprintf('%-10s %s', $type, $this->formatValue($token));
  }

  protected function formatValue($value)
  {
    if (is_object($value))
    {
      return sprintf('object(%s)', get_class($value));
    }
    else
    {
      return preg_replace("/\n\s*/s", '', var_export($value, true));
    }
  }
}
