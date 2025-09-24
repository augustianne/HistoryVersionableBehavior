<?php

/**
 * @author Yan Co
 */
class HistoryVersionableBehaviorTest extends \TestCase
{
    // protected function setUp()
    // {
    //     if (!class_exists('Person')) {
            
    //     }
    // }

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

    private function buildSchema($schema, $class)
    {
        if (!class_exists($class)) {
            $this->getBuilder($schema)->build();
        }
        
    }

    /**
     * @covers Autodeal\FleetBundle\Service\AccessControl\SystemOperation\SystemOperationRegistry::getOperationsBySection
     * @dataProvider getObjectMethodDefaultData
     */
    public function testObjectMethodsDefault($method, $expected)
    {
        $schema = <<<XML
<database name="history_versionable_test_1">
    <table name="person">
        <column name="id" required="true" primaryKey="true" autoIncrement="true" type="INTEGER" />
        <column name="name" type="VARCHAR" required="true" />
        <behavior name="history_versionable" />
    </table>
</database>
XML;
        $this->buildSchema($schema, 'Person');

        $this->assertTrue(class_exists('Person'));
        $this->assertEquals($expected, method_exists('Person', $method));
    }

    /**
     * @covers Autodeal\FleetBundle\Service\AccessControl\SystemOperation\SystemOperationRegistry::getOperationsBySection
     * @dataProvider getObjectMethodDefaultData
     */
    public function testVersionObjectMethodDefault($method, $expected)
    {
        $schema = <<<XML
<database name="history_versionable_test_1">
    <table name="person">
        <column name="id" required="true" primaryKey="true" autoIncrement="true" type="INTEGER" />
        <column name="name" type="VARCHAR" required="true" />
        <behavior name="history_versionable" />
    </table>
</database>
XML;
        $this->buildSchema($schema, 'Person');

        $this->assertTrue(class_exists('PersonVersion'));
        $this->assertEquals($expected, method_exists('PersonVersion', $method));
    }

    /**
     * @covers Autodeal\FleetBundle\Service\AccessControl\SystemOperation\SystemOperationRegistry::getOperationsBySection
     * @dataProvider getObjectMethodLogFieldsSetData
     */
    public function testObjectMethodsLogFieldsSet($method, $expected)
    {
        $schema = <<<XML
<database name="history_versionable_test_2">
    <table name="Car">
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
        $this->buildSchema($schema, 'Car');

        $this->assertTrue(class_exists('Car'));
        $this->assertEquals($expected, method_exists('Car', $method));
    }

    /**
     * @covers Autodeal\FleetBundle\Service\AccessControl\SystemOperation\SystemOperationRegistry::getOperationsBySection
     * @dataProvider getObjectMethodLogFieldsSetData
     */
    public function testVersionObjectMethodLogFieldsSet($method, $expected)
    {
        $schema = <<<XML
<database name="history_versionable_test_2">
    <table name="Car">
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
        $this->buildSchema($schema, 'Car');

        $this->assertTrue(class_exists('CarVersion'));
        $this->assertEquals($expected, method_exists('CarVersion', $method));

        var_dump(method_exists('BaseCarVersion', 'setOnDelete'));
    }
}