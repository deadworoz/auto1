<?php

declare(strict_types=1);

namespace App\Controller;

use Psr\Container\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

abstract class AbstractBaseController extends AbstractController
{
    /**
     * @var ContainerInterface
     *
     * @psalm-suppress PropertyNotSetInConstructor
     */
    protected $container;
}
