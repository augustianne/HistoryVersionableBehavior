<?php

// require_once dirname(__FILE__) . '/../../../../../generator/lib/util/PropelQuickBuilder.php';
// require_once dirname(__FILE__) . '/../src/HistoryVersionableBehavior.php';
// require_once dirname(__FILE__) . '/../../../../../runtime/lib/Propel.php';
use PHPUnit\Framework\TestCase as PHPUnit_Framework_TestCase;

class HistoryVersionableBehaviorPeerBuilderModifierTest extends PHPUnit_Framework_TestCase
{

    public function testIsVersioningEnabledDefaultState()
    {
        if (!class_exists('HistoryVersionableBehaviorTest1')) {
            $schema = <<<EOF
<database name="history_versionable_behavior_test_1">
    <table name="history_versionable_behavior_test_1">
        <column name="id" primaryKey="true" type="INTEGER" autoIncrement="true" />
        <column name="bar" type="INTEGER" />
        <behavior name="history_versionable" />
    </table>
</database>>
EOF;

            PropelQuickBuilder::buildSchema($schema);
            $this->assertFalse(HistoryVersionableBehaviorTest1Peer::isVersioningEnabled());

            HistoryVersionableBehaviorTest1Peer::enableVersioning();
            $this->assertTrue(HistoryVersionableBehaviorTest1Peer::isVersioningEnabled());

            HistoryVersionableBehaviorTest1Peer::disableVersioning();
            $this->assertFalse(HistoryVersionableBehaviorTest1Peer::isVersioningEnabled());
        }
        
    }

    public function testIsVersioningEnabledTrue()
    {
        if (!class_exists('HistoryVersionableBehaviorTest2')) {
            $schema = <<<EOF
<database name="history_versionable_behavior_test_2">
    <table name="history_versionable_behavior_test_2">
        <column name="id" primaryKey="true" type="INTEGER" autoIncrement="true" />
        <column name="bar" type="INTEGER" />
        <behavior name="history_versionable">
            <parameter name="enable_versioning_by_default" value="true" />
        </behavior>
    </table>
</database>>
EOF;
            PropelQuickBuilder::buildSchema($schema);
            $this->assertTrue(HistoryVersionableBehaviorTest2Peer::isVersioningEnabled());

            HistoryVersionableBehaviorTest2Peer::enableVersioning();
            $this->assertTrue(HistoryVersionableBehaviorTest2Peer::isVersioningEnabled());

            HistoryVersionableBehaviorTest2Peer::disableVersioning();
            $this->assertFalse(HistoryVersionableBehaviorTest2Peer::isVersioningEnabled());
        }
        
    }
}
