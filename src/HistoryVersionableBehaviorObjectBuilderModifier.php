<?php

class HistoryVersionableBehaviorObjectBuilderModifier extends \VersionableBehaviorObjectBuilderModifier
{
    /**
     * Don't do any version deletion after the main deletion
     * 
     * @param \PHP5ObjectBuilder $builder
     */
    public function postDelete(\PHP5ObjectBuilder $builder)
    {
        $this->builder = $builder;
        $script = "// Look up the latest version
\$latestVersion = {$this->getVersionQueryClassName()}::create()->
    filterBy{$this->table->getPhpName()}(\$this)->
    orderByVersion(\Criteria::DESC)->
    findOne(\$con);
\$latestVersion->
    setVersionArchivedAt(time())->
    save(\$con);
        ";

        return $script;
    }
}