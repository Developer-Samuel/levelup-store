<?php

declare(strict_types=1);

require_once 'scripts/common/launcher.php';

$returnVar = launch(
    'scripts\\tools\\php-unit\\batch\\entrypoints\\run.cmd',
    'scripts/tools/php-unit/bash/entrypoints/run.sh'
);
exit($returnVar);
