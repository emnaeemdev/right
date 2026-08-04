<?php

namespace App\Support;

use Illuminate\Support\Facades\Session;

class SimpleCaptcha
{
    public static function refresh(string $key): array
    {
        $left = random_int(1, 9);
        $right = random_int(1, 9);

        Session::put(self::sessionKey($key), $left + $right);

        return [
            'key' => $key,
            'left' => $left,
            'right' => $right,
            'question' => __('forms.captcha_question', ['a' => $left, 'b' => $right]),
        ];
    }

    public static function verify(string $key, mixed $answer): bool
    {
        $expected = Session::pull(self::sessionKey($key));

        if ($expected === null || $answer === null || $answer === '') {
            return false;
        }

        return (int) $expected === (int) $answer;
    }

    protected static function sessionKey(string $key): string
    {
        return 'simple_captcha.'.$key;
    }
}
