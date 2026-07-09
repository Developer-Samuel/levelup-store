<?php

declare(strict_types=1);

require_once 'scripts/common/launcher.php';

$returnVar = launch(
    'scripts\\tasks\\prepare-temp\\batch\\run.cmd',
    'scripts/tasks/prepare-temp/bash/run.sh'
);
exit($returnVar);
