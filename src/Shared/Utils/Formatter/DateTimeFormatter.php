<?php

declare(strict_types=1);

namespace App\Shared\Utils\Formatter;

final class DateTimeFormatter
{
    /**
     * @param \DateTimeInterface $dateTime
     *
     * @return string
    */
    public static function format(\DateTimeInterface $dateTime): string
    {
        return $dateTime->format('Y-m-d H:i:s');
    }

    /**
     * @param \DateTimeInterface $dateTime
     *
     * @return string
    */
    public static function formatShort(\DateTimeInterface $dateTime): string
    {
        return $dateTime->format('Y-m-d H:i');
    }

    /**
     * @param \DateTimeInterface $dateTime
     *
     * @return string
    */
    public static function formatDMY(\DateTimeInterface $dateTime): string
    {
        return $dateTime->format('d.m.Y H:i');
    }
}
