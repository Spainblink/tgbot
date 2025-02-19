<?php

declare(strict_types = 1);

namespace classes;

use classes\LogHelper;

Class Translator
{
    private static string $translateUrl = 'https://libretranslate.com/translate';

    public static function translate(string $text): array
    {
        $data = [
            'q' => $text,
            'source' => 'en',
            'target' => 'ru',
            'format' => 'text'
        ];
        $ch = curl_init(self::$translateUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $response = curl_exec($ch);
        curl_close($ch);
        $jsonDecode = json_decode($response, true);
        $str = '';
        foreach ($jsonDecode as $k => $v) {
            $str .= $k . ' => ' . $v . PHP_EOL;
        }
        LogHelper::logToFile($str);

        return $jsonDecode;
    }
}
