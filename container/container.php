<?php

use League\Container\Container;
use app\controller\UserProfileController;
use app\repository\UserProfileRepository;
use app\service\UserProfileService;

$container = new Container();

$container->add(UserProfileRepository::class);
$container->add(UserProfileService::class)->addArgument(UserProfileRepository::class);
$container->add(UserProfileController::class)->addArgument(UserProfileService::class);

return $container;
