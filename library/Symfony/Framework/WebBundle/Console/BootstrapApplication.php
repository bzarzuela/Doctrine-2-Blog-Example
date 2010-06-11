<?php

namespace Symfony\Framework\WebBundle\Console;

use Symfony\Components\Console\Application as BaseApplication;
use Symfony\Components\Console\Input\InputInterface;
use Symfony\Components\Console\Input\InputOption;
use Symfony\Components\Console\Output\OutputInterface;
use Symfony\Foundation\Kernel;
use Symfony\Framework\WebBundle\Command\InitApplicationCommand;

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
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 */
class BootstrapApplication extends BaseApplication
{
  /**
   * Constructor.
   */
  public function __construct()
  {
    parent::__construct('Symfony', Kernel::VERSION);

    $this->addCommand(new InitApplicationCommand());
  }
}
