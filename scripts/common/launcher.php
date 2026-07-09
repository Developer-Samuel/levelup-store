<?php

declare(strict_types=1);

function launch(string $windowsCmd, string $unixCmd): int
{
    $os = PHP_OS_FAMILY;
    $isBash = getenv('SHELL') !== false && strpos(getenv('SHELL'), 'bash') !== false;

    if ($os === 'Windows' && !$isBash) {
        echo "Detected Windows CMD/PowerShell, running $windowsCmd\n";
        passthru($windowsCmd, $returnVar);
    } else {
        echo "Detected Bash or Unix, running $unixCmd\n";
        passthru("bash $unixCmd", $returnVar);
    }

    return $returnVar;
}
