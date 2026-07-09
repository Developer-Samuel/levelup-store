<?php

declare(strict_types=1);

require_once 'scripts/common/launcher.php';

$returnVar = launch(
    'scripts\\tools\\php-cs-fixer\\batch\\entrypoints\\run.cmd',
    'scripts/tools/php-cs-fixer/bash/entrypoints/run.sh'
);
exit($returnVar);
