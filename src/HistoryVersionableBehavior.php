<?php

// This is how the versionable behavior works
require_once dirname(__FILE__) . '/HistoryVersionableBehaviorObjectBuilderModifier.php';

class HistoryVersionableBehavior extends \VersionableBehavior
{
    // default parameters value
    protected $parameters = array(
        'version_column' => 'version',
        'version_table'  => '',
        'log_created_at' => 'false',
        'log_created_by' => 'false',
        'log_comment'    => 'false',
        'version_created_at_column' => 'version_created_at',
        'version_created_by_column' => 'version_created_by',
        'version_comment_column' => 'version_comment',
        'version_archived_at_column' => 'version_archived_at'
    );

    /**
     * Let's just add the version_archived_at_column column for uniformity of implementation
     * Even though it won't get populated as object will be deleted
     */
    protected function addLogColumns()
    {
        parent::addLogColumns();

        $table = $this->getTable();
        if (!$table->hasColumn($this->getParameter('version_archived_at_column'))) {
            $table->addColumn(array('name' => $this->getParameter('version_archived_at_column'), 'type' => 'TIMESTAMP'));
        }
    }

    /**
     * Reset the FKs from CASCADE ON DELETE to no action
     * 
     * (I expect all future migration diffs will incorrectly try to re-add the constraint
     * I manually removed from the migration that introduced versioning, may try to fix
     * that another time. 'Tis fine for now).
     */
    public function addVersionTable()
    {
        parent::addVersionTable();

        $this->swapAllForeignKeysToNoDeleteAction();
        // $this->addVersionArchivedColumn();
    }

    protected function swapAllForeignKeysToNoDeleteAction()
    {
        $versionTable = $this->lookupVersionTable();
        $fks = $versionTable->getForeignKeys();
        foreach ($fks as $fk)
        {
            $fk->setOnDelete(null);
        }
    }

    protected function addVersionArchivedColumn()
    {
        $versionTable = $this->lookupVersionTable();
        $versionTable->addColumn(array(
            'name' => 'version_archived_at',
            'type' => 'timestamp',
        ));
    }

    protected function lookupVersionTable()
    {
        $table = $this->getTable();
        $versionTableName = $this->getParameter('version_table') ?
            $this->getParameter('version_table') :
            ($table->getName() . '_version');
        $database = $table->getDatabase();

        return $database->getTable($versionTableName);
    }

    /**
     * Point to the custom object builder class
     * 
     * @return HistoryVersionableBehaviorObjectBuilderModifier
     */
    public function getObjectBuilderModifier()
    {
        if (is_null($this->objectBuilderModifier)) {
            $this->objectBuilderModifier = new HistoryVersionableBehaviorObjectBuilderModifier($this);
        }

        return $this->objectBuilderModifier;
    }
}