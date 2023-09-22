<?php

declare(strict_types=1);

namespace Ilyaplot\Architect\DependencyInjection;

use InvalidArgumentException;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * @throws InvalidArgumentException
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $builder = new TreeBuilder('architect');
        /** @var ArrayNodeDefinition $rootNode */
        $rootNode = $builder->getRootNode();
        $this->appendAnalysedPaths($rootNode);
        return $builder;
    }

    private function appendAnalysedPaths(ArrayNodeDefinition $node): void
    {
        /**
         * @psalm-suppress MixedMethodCall, UndefinedInterfaceMethod, PossiblyNullReference
         */
        $node
            ->fixXmlConfig('path')
            ->children()
            ->arrayNode('paths')
            ->info('List of paths to search for PHP files to be analysed.')
            ->addDefaultChildrenIfNoneSet()
            ->requiresAtLeastOneElement()
            ->scalarPrototype()
            ->cannotBeEmpty()
            ->defaultValue('src/')
            ->end()
            ->end()
            ->end();
    }
}
