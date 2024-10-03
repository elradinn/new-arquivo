<?php

namespace Domain\NumberingScheme\Actions;

use Domain\NumberingScheme\Models\NumberingScheme;

class DeleteNumberingSchemeAction
{
    public function execute(NumberingScheme $numberingScheme): void
    {
        $numberingScheme->delete();
    }
}
