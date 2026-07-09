<?php

declare(strict_types=1);

require_once 'scripts/common/launcher.php';

$returnVar = launch(
    'scripts\\symfony\\database\\batch\\run.cmd',
    'scripts/symfony/database/bash/run.sh'
);
exit($returnVar);