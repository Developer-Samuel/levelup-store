<?php

declare(strict_types=1);

require_once 'scripts/common/launcher.php';

$returnVar = launch(
    'scripts\\tasks\\prepare-assets\\batch\\run.cmd',
    'scripts/tasks/prepare-assets/bash/run.sh'
);
exit($returnVar);
