<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class LangType extends Enum
{
    const English = 'en';
    const Deutsch = 'de';
    const Türkçe = 'tr';
}
