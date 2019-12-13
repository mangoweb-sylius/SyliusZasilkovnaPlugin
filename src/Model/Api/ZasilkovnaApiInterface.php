<?php

declare(strict_types=1);

namespace MangoSylius\SyliusZasilkovnaPlugin\Model\Api;

interface ZasilkovnaApiInterface
{
	public function syncBranches(): void;
}
