<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;

return static function (RectorConfig $rectorConfig): void {
	// $rectorConfig->importNames();
	//$rectorConfig->removeUnusedImports();
	$rectorConfig->indent('	', 1);
	//$rectorConfig->sets([\Rector\Set\ValueObject\SetList::PHP_80]);

	$rectorConfig->rule(\OCA\Mail\Utils\Rector\Rector\OcServerGetToOcpServerGet::class);
	$rectorConfig->rule(\OCA\Mail\Utils\Rector\Rector\OcServerGettersToOcpServerGet::class);
	$rectorConfig->rule(\OCA\Mail\Utils\Rector\Rector\OcServerQueryToOcpServerGet::class);

	//$rectorConfig->rule(Rector\CodeQuality\Rector\LogicalAnd\LogicalToBooleanRector::class);

	$rectorConfig->ruleWithConfiguration( Rector\Php80\Rector\Class_\AnnotationToAttributeRector::class, [
		new \Rector\Php80\ValueObject\AnnotationToAttribute(
			'NoAdminRequired',
			\OCP\AppFramework\Http\Attribute\NoAdminRequired::class
		),
	]);

	$rectorConfig->paths([
		__DIR__ . '/lib',
		__DIR__ . '/tests',
	]);
	$rectorConfig->skip([
		__DIR__ . '/lib/Vendor',
	]);
};
