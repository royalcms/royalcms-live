<?php

namespace Royalcms\Component\Live\Facades;

use Royalcms\Component\Support\Facades\Facade;


/**
 * Class Elasticsearch
 *
 * @package Royalcms\Component\Elasticsearch
 */
class Live extends Facade
{

    /**
     * @inheritdoc
     */
    protected static function getFacadeAccessor()
    {
        return 'live';
    }
}
