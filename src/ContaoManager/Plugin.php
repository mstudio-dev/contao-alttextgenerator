<?php

namespace Mstudio\ContaoAltTextGenerator\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundleConfig;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Mstudio\ContaoAltTextGenerator\MstudioContaoAltTextGeneratorBundle;

class Plugin implements BundlePluginInterface
{
    public function getBundles(ParserInterface $parser): array
    {
        return [
            BundleConfig::create(MstudioContaoAltTextGeneratorBundle::class)
                ->setLoadAfter([ContaoCoreBundle::class]),
        ];
    }
}
