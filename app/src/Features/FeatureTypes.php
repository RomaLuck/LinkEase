<?php

namespace Src\Features;

class FeatureTypes
{
    public const WEATHER = 'weather';
    public const PHP_STUDY = 'PHP';
    public const JS_STUDY = 'JS';
    public const PYTHON_STUDY = 'PYTHON';

    public static function getStudySubjects(): array
    {
        return [
            self::PHP_STUDY,
            self::JS_STUDY,
            self::PYTHON_STUDY,
        ];
    }
}