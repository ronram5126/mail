<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;

return static function (RectorConfig $rectorConfig): void {
	// $rectorConfig->importNames();
	$rectorConfig->removeUnusedImports();
	$rectorConfig->indent('	', 1);

	$rectorConfig->rule(\OCA\Mail\Utils\Rector\Rector\OcServerGetToOcpServerGet::class);
	$rectorConfig->rule(\OCA\Mail\Utils\Rector\Rector\OcServerQueryToOcpServerGet::class);

	$rectorConfig->paths([
		__DIR__ . '/lib',
		__DIR__ . '/tests',
	]);
	$rectorConfig->skip([
		__DIR__ . '/lib/Vendor',
	]);
};
