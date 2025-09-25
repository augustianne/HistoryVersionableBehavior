<?php

use PHPUnit\Framework\TestCase as PHPUnit_Framework_TestCase;

/**
 * @author Yan Co
 */
class HistoryVersionableBehaviorTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        if (!class_exists('HistoryVersionableTest1Table1')) {
            $schema = <<<XML
<database name="history_versionable_test_1">
    <table name="history_versionable_test_1_table_1">
        <column name="id" required="true" primaryKey="true" autoIncrement="true" type="INTEGER" />
        <column name="name" type="VARCHAR" required="true" />
        <behavior name="history_versionable" />
    </table>
    <table name="history_versionable_test_1_table_2">
        <column name="id" required="true" primaryKey="true" autoIncrement="true" type="INTEGER" />
        <column name="name" type="VARCHAR" required="true" />
        <behavior name="history_versionable">
            <parameter name="log_created_at" value="true" />
            <parameter name="log_created_by" value="true" />
            <parameter name="log_comment" value="true" />
        </behavior>
    </table>
</database>
XML;
            PropelQuickBuilder::buildSchema($schema);
        }
    }

    public function getObjectMethodDefaultData()
    {
        return [
            ['getId', true],
            ['getName', true],
            ['getVersion', true],
            ['getVersionArchivedAt', true],
            ['getVersionCreatedBy', false],
            ['getVersionCreatedAt', false],
            ['getVersionComment', false],
        ];
    }

    public function getObjectMethodLogFieldsSetData()
    {
        return [
            ['getId', true],
            ['getName', true],
            ['getVersion', true],
            ['getVersionArchivedAt', true],
            ['getVersionCreatedBy', true],
            ['getVersionCreatedAt', true],
            ['getVersionComment', true],
        ];
    }

    public function getObjectVersionMethodDefaultData()
    {
        return [
            ['getId', true],
            ['getName', true],
            ['getVersion', true],
            ['getVersionArchivedAt', true],
            ['getVersionCreatedBy', false],
            ['getVersionCreatedAt', false],
            ['getVersionComment', false],
        ];
    }

    public function getObjectVersionMethodLogFieldsSetData()
    {
        return [
            ['getId', true],
            ['getName', true],
            ['getVersion', true],
            ['getVersionArchivedAt', true],
            ['getVersionCreatedBy', true],
            ['getVersionCreatedAt', true],
            ['getVersionComment', true],
        ];
    }

    private function buildSchema($schema, $class)
    {
        if (!class_exists($class)) {
            $this->getBuilder($schema)->build();
        }
        
    }

    /**
     * @covers HistoryVersionableBehavior
     * @dataProvider getObjectMethodDefaultData
     */
    public function testObjectMethodsDefault($method, $expected)
    {
        $this->assertTrue(class_exists('HistoryVersionableTest1Table1'));
        $this->assertEquals($expected, method_exists('HistoryVersionableTest1Table1', $method));
    }

    /**
     * @covers HistoryVersionableBehavior
     * @dataProvider getObjectVersionMethodDefaultData
     */
    public function testVersionObjectMethodDefault($method, $expected)
    {
        $this->assertTrue(class_exists('HistoryVersionableTest1Table1Version'));
        $this->assertEquals($expected, method_exists('HistoryVersionableTest1Table1Version', $method));
    }

    /**
     * @covers HistoryVersionableBehavior
     * @dataProvider getObjectMethodLogFieldsSetData
     */
    public function testObjectMethodsLogFieldsSet($method, $expected)
    {
        $this->assertTrue(class_exists('HistoryVersionableTest1Table2'));
        $this->assertEquals($expected, method_exists('HistoryVersionableTest1Table2', $method));
    }

    /**
     * @covers HistoryVersionableBehavior
     * @dataProvider getObjectVersionMethodLogFieldsSetData
     */
    public function testVersionObjectMethodLogFieldsSet($method, $expected)
    {
        $this->assertTrue(class_exists('HistoryVersionableTest1Table2Version'));
        $this->assertEquals($expected, method_exists('HistoryVersionableTest1Table2Version', $method));
    }
}