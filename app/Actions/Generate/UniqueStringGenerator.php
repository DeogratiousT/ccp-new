<?php

namespace App\Actions\Generate;

use Exception;
use function random_int;

class UniqueStringGenerator
{
    /**
     * @param int $length
     * @param bool $useSmallLetters
     * @param bool $useCapitalLetters
     * @param bool $useNumbers
     *
     * @return string
     * @throws Exception
     */
    function generate(int $length = 20, bool $useSmallLetters = true, bool $useCapitalLetters = true, bool $useNumbers = true): string
    {
        $randstr = '';

        $smallLetters = 'abcdefghijklmnpqrstuvwxyz';

        $numbers = '123456789';

        $capitalLetters = 'ABCDEFGHIJKLMNPQRSTUVWXYZ';

        $chars = '';

        if ($useSmallLetters === true) {
            $chars .= $smallLetters;
        }

        if ($useCapitalLetters === true) {
            $chars .= $capitalLetters;
        }

        if ($useNumbers === true) {
            $chars .= $numbers;
        }

        $max = strlen($chars);

        for ($i = 0; $i < $length; $i++) {
            $randstr .= $chars[random_int(0, $max - 1)];
        }

        return $randstr;
    }
}
