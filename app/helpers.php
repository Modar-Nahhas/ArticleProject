<?php


if (!function_exists('enumAsArray')) {
    function enumAsArray($enumClass): array
    {
        return array_column($enumClass::cases(),'value');

    }
}
