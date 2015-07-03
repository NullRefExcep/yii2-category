<?php

namespace nullref\category\models;

/**
 * @author    Dmytro Karpovych
 * @copyright 2015 NRE
 */
interface ICategory
{
    public function getId();

    public function getType();

    public function getTitle();
}