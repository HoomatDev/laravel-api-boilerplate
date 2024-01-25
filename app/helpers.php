<?php

if (! function_exists('getInputValue')) {
    function getInputValue($value, $default = null) {
        return isset($value) ? $value : $default;
    }
}

if (! function_exists('getRequestPage')) {
    function getRequestPage() {
        return request()->input('page') ?? 1;
    }
}
