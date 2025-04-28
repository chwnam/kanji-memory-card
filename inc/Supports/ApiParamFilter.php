<?php

namespace Chwnam\KanjiMemoryCard\Supports;

use Bojaghi\Contract\Support;

class ApiParamFilter implements Support
{
    public static function sanitizeCardId(mixed $p): int
    {
        return absint((string)$p);
    }

    public static function sanitizeCourse(mixed $p): string
    {
        return sanitize_key((string)$p);
    }

    public static function sanitizeIntArray(mixed $p): array
    {
        return array_unique(array_filter(array_map(fn($v) => absint(trim($v)), explode(',', (string)$p))));
    }

    public static function sanitizeResult(mixed $p): bool
    {
        return filter_var((string)$p, FILTER_VALIDATE_BOOLEAN);
    }

    public static function sanitizeTier(mixed $p): int
    {
        return absint((string)$p);
    }

    public static function sanitizeUserId(mixed $p): int
    {
        return absint((string)$p);
    }
}
