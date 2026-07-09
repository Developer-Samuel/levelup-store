<?php

declare(strict_types=1);

require_once 'scripts/common/launcher.php';

$returnVar = launch(
    'scripts\\tools\\php-metrics\\batch\\entrypoints\\run.cmd',
    'scripts/tools/php-metrics/bash/entrypoints/run.sh'
);
exit($returnVar);
