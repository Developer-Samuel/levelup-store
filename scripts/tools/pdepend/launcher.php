<?php

declare(strict_types=1);

require_once 'scripts/common/launcher.php';

$returnVar = launch(
    'scripts\\tools\\pdepend\\batch\\entrypoints\\run.cmd',
    'scripts/tools/pdepend/bash/entrypoints/run.sh'
);
exit($returnVar);