<?php

namespace Juukie;

/**
 * Class DutchLicencePlateFormatter
 *
 * @see: https://blog.kenteken.tv/2011/05/06/code-snippets-formatteren-rdw-kenteken/
 */
class DutchLicencePlateFormatter
{
    /**
     * @param $licensePlate
     * @return string
     */
    public static function format($licensePlate)
    {
        // Sanitize
        $licensePlate = preg_replace('/[^A-Z\d]/', '', strtoupper($licensePlate));

        // Except license plates for diplomats
        if (preg_match('/^CD[ABFJNST][0-9]{1,3}$/', $licensePlate)) {
            return $licensePlate;
        }

        $arguments = self::getArguments($licensePlate);

        if ($arguments === false) {
            return $licensePlate;
        }

        return implode('-', array_map(function ($args) use ($licensePlate) {
            return call_user_func_array('substr', array_merge([$licensePlate], $args));
        }, $arguments));
    }

    /**
     * @param string $licensePlate
     * @return bool|array
     */
    private static function getArguments(string $licensePlate)
    {
        $patterns = [
            '[A-Z]{2}[\d]{2}[\d]{2}' => [[0, 2], [2, 2], [4, 2]],
            '[\d]{2}[\d]{2}[A-Z]{2}' => [[0, 2], [2, 2], [4, 2]],
            '[\d]{2}[A-Z]{2}[\d]{2}' => [[0, 2], [2, 2], [4, 2]],
            '[A-Z]{2}[\d]{2}[A-Z]{2}' => [[0, 2], [2, 2], [4, 2]],
            '[A-Z]{2}[A-Z]{2}[\d]{2}' => [[0, 2], [2, 2], [4, 2]],
            '[\d]{2}[A-Z]{2}[A-Z]{2}' => [[0, 2], [2, 2], [4, 2]],
            '[\d]{2}[A-Z]{3}[\d]{1}' => [[0, 2], [2, 3], [5, 1]],
            '[A-Z]{2}[\d]{3}[A-Z]{1}' => [[0, 2], [2, 3], [5, 1]],
            '[\d]{1}[A-Z]{3}[\d]{2}' => [[0, 1], [1, 3], [4, 2]],
            '[A-Z]{1}[\d]{3}[A-Z]{2}' => [[0, 1], [1, 3], [4, 2]],
            '[A-Z]{3}[\d]{2}[A-Z]{1}' => [[0, 3], [3, 2], [5, 1]],
            '[\d]{3}[A-Z]{2}[\d]{1}' => [[0, 3], [3, 2], [5, 1]],
            '[A-Z]{1}[\d]{2}[A-Z]{3}' => [[0, 1], [1, 2], [3, 3]],
            '[\d]{1}[A-Z]{2}[\d]{3}' => [[0, 1], [1, 2], [3, 3]],
        ];

        foreach ($patterns as $pattern => $arguments) {
            if (preg_match("/^{$pattern}$/", $licensePlate)) {
                return $arguments;
            }
        }

        return false;
    }
}
