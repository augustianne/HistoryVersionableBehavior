<?php

/**
 * Let's disable versioning by default
 */
class HistoryVersionableBehaviorPeerBuilderModifier extends \VersionableBehaviorPeerBuilderModifier
{
    public function __construct(HistoryVersionableBehavior $behavior)
    {
        $this->behavior = $behavior;
    }

    public function staticAttributes()
    {
        if ($this->behavior->getParameter('enable_versioning_by_default') == 'true') {
            return "
/**
 * Whether the versioning is enabled
 */
static \$isVersioningEnabled = true;
";
        }
        else {
            return "
/**
 * Whether the versioning is enabled
 */
static \$isVersioningEnabled = false;
";
        }
    }
}