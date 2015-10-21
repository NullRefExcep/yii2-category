<?php
/**
 * @author    Dmytro Karpovych
 * @copyright 2015 NRE
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace nullref\category;


use nullref\core\components\ModuleInstaller;

class Installer extends ModuleInstaller
{
    public function getModuleId()
    {
        return 'category';
    }
} 