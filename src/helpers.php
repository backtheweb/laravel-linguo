<?php

if (! function_exists('__')) {

    function __($msgId, Array $args = [], $domain = 'default', $locale = null)
    {
        return App('linguo')->trans($msgId, $args, $domain, $locale);
    }
}

if (! function_exists('plural')) {

    function plural($msgId1, $plural, $count = 1,  Array $args = [], $domain = 'default', $locale = null)
    {
        return App('linguo')->plural($msgId1, $plural, $count, $args, $domain, $locale);
    }
}