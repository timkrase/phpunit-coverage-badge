<?php declare(strict_types=1);

require(__DIR__ . DIRECTORY_SEPARATOR . '../vendor/autoload.php');

$containerBuilder = new DI\ContainerBuilder();
$containerBuilder->addDefinitions(__DIR__ . '/DependencyInjection/config.php');
$container = $containerBuilder->build();

$workflowService = $container->get('WorkflowService');
$workflowService->run();

