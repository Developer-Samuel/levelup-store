<?php

declare(strict_types=1);

require_once 'scripts/common/launcher.php';

$returnVar = launch(
    'scripts\\tools\\deptrac\\batch\\entrypoints\\run.cmd',
    'scripts/tools/deptrac/bash/entrypoints/run.sh'
);
exit($returnVar);
