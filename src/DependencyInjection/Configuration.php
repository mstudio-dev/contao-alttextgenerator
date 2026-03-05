<?php

namespace Mstudio\ContaoAltTextGenerator\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('mstudio_contao_alt_text_generator');

        $treeBuilder->getRootNode()
            ->children()
                ->scalarNode('model')
                    ->defaultValue('gpt-4o-mini')
                    ->cannotBeEmpty()
                ->end()
                ->booleanNode('replace_existing_alt')
                    ->defaultFalse()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
