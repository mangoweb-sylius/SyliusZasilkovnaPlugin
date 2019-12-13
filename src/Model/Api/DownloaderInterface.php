<?php

declare(strict_types=1);

namespace MangoSylius\SyliusZasilkovnaPlugin\Model\Api;

use stdClass;

interface DownloaderInterface
{
	/**
	 * @return stdClass[]
	 */
	public function downloadBranches(string $apiUrl): array;
}
