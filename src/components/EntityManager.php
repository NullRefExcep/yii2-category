<?php

namespace nullref\category\components;

use nullref\core\components\EntityManager as BaseManager;

/**
 * @author    Dmytro Karpovych
 * @copyright 2015 NRE
 */
class EntityManager extends BaseManager
{
    public $hasImage = true;
    public $hasParent = true;
    public $hasStatus = true;
}