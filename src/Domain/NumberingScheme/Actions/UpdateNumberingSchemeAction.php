<?php

namespace Domain\NumberingScheme\Actions;

use Domain\NumberingScheme\Data\UpdateNumberingSchemeData;
use Domain\NumberingScheme\Models\NumberingScheme;

class UpdateNumberingSchemeAction
{
    public function execute(NumberingScheme $numberingScheme, UpdateNumberingSchemeData $data): NumberingScheme
    {
        $numberingScheme->update($data->toArray());
        return $numberingScheme;
    }
}
