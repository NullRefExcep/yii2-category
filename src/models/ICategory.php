<?php

namespace nullref\category\models;
use yii\db\ActiveRecordInterface;

/**
 * @author    Dmytro Karpovych
 * @copyright 2015 NRE
 */
interface ICategory extends ActiveRecordInterface
{
    public function getId();

    public function getType();

    public function getTitle();
}