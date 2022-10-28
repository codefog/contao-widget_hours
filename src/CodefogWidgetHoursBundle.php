<?php

namespace Codefog\WidgetHoursBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class CodefogWidgetHoursBundle extends Bundle
{
    public function getPath(): string
    {
        return dirname(__DIR__);
    }
}
