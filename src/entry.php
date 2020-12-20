<?php declare(strict_types=1);

use PhpUnitCoverageBadge\WorkflowService;

require __DIR__ . DIRECTORY_SEPARATOR . '../vendor/autoload.php';

$containerBuilder = new DI\ContainerBuilder();
$containerBuilder->addDefinitions(__DIR__ . '/DependencyInjection/config.php');
$container = $containerBuilder->build();

/**
 * @var WorkflowService $workflowService 
*/
$workflowService = $container->get(WorkflowService::class);
$workflowService->run();

