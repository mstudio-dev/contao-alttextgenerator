<?php

namespace Mstudio\ContaoAltTextGenerator\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class MstudioContaoAltTextGeneratorExtension extends Extension
{
    public function getAlias(): string
    {
        return 'mstudio_contao_alt_text_generator';
    }

    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('mstudio_contao_alt_text_generator.model', $config['model']);
        $container->setParameter('mstudio_contao_alt_text_generator.replace_existing_alt', $config['replace_existing_alt']);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../../config'));
        $loader->load('services.yaml');
    }
}
