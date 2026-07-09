<?php

declare(strict_types=1);

require_once 'scripts/common/launcher.php';

$returnVar = launch(
    'scripts\\symfony\\jwt\\generate\\batch\\run.cmd',
    'scripts/symfony/jwt/generate/bash/run.sh'
);
exit($returnVar);
