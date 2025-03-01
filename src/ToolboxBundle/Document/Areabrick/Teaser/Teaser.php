<?php

namespace ToolboxBundle\Document\Areabrick\Teaser;

use Symfony\Component\HttpFoundation\Response;
use ToolboxBundle\Document\Areabrick\AbstractAreabrick;
use Pimcore\Model\Document\Editable\Area\Info;

class Teaser extends AbstractAreabrick
{
    public function action(Info $info): ?Response
    {
        return parent::action($info);
    }

    public function getName()
    {
        return 'Teaser';
    }

    public function getDescription()
    {
        return 'Toolbox Teaser';
    }
}
