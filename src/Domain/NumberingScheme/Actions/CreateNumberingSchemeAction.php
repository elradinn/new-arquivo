<?php

namespace Domain\NumberingScheme\Actions;

use Domain\NumberingScheme\Data\CreateNumberingSchemeData;
use Domain\NumberingScheme\Models\NumberingScheme;

class CreateNumberingSchemeAction
{
    public function execute(CreateNumberingSchemeData $data): NumberingScheme
    {
        return NumberingScheme::create($data->toArray());
    }
}
