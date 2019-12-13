<?php

declare(strict_types=1);

namespace MangoSylius\SyliusZasilkovnaPlugin\Model\Api;

use stdClass;

class JsonDownloader implements DownloaderInterface
{
	/**
	 * @return stdClass[]
	 */
	public function downloadBranches(string $apiUrl): array
	{
		$url = $apiUrl . '/branch.json';

		$fileContent = file_get_contents($url);
		assert($fileContent !== false);
		$data = json_decode($fileContent);

		return (array) $data->data;
	}
}
