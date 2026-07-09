<?php

declare(strict_types=1);

require_once 'scripts/common/launcher.php';

$returnVar = launch(
    'scripts\\symfony\\env\\secret\\batch\\run.cmd',
    'scripts/symfony/env/secret/bash/run.sh'
);
exit($returnVar);
