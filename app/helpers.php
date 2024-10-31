<?php

function createCacheKey(...$args)
{
    return md5(implode("-", $args));
}
