<?php

/**
 * @author Yan Co
 */
use PHPUnit\Framework\TestCase as PHPUnit_Framework_TestCase;

class TestCase extends PHPUnit_Framework_TestCase
{
    protected function getBuilder($schema)
    {
        $builder = new PropelQuickBuilder();
        $config  = $builder->getConfig();
        $config->setBuildProperty('behavior.history_versionable.class', '../src/HistoryVersionableBehavior');

        $builder->setConfig($config);
        $builder->setSchema($schema);

        return $builder;
    }
}