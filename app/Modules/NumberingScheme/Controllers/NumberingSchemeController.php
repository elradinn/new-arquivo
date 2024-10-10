<?php

namespace Modules\NumberingScheme\Controllers;

use Modules\Common\Controllers\Controller;
use Modules\NumberingScheme\Actions\CreateNumberingSchemeAction;
use Modules\NumberingScheme\Actions\DeleteNumberingSchemeAction;
use Modules\NumberingScheme\Actions\UpdateNumberingSchemeAction;
use Modules\NumberingScheme\Data\CreateNumberingSchemeData;
use Modules\NumberingScheme\Data\NumberingSchemeResourceData;
use Modules\NumberingScheme\Data\UpdateNumberingSchemeData;
use Modules\NumberingScheme\Models\NumberingScheme;
use Illuminate\Http\JsonResponse;

class NumberingSchemeController extends Controller
{
    public function __construct(
        protected CreateNumberingSchemeAction $createNumberingSchemeAction,
        protected UpdateNumberingSchemeAction $updateNumberingSchemeAction,
        protected DeleteNumberingSchemeAction $deleteNumberingSchemeAction,
    ) {}

    /**
     * @return \Spatie\LaravelData\DataCollection<NumberingSchemeResourceData>
     */
    public function index()
    {
        $numberingSchemes = NumberingScheme::with('folder')->get();

        return NumberingSchemeResourceData::collect($numberingSchemes);
    }

    public function store(CreateNumberingSchemeData $data): JsonResponse
    {
        $numberingScheme = $this->createNumberingSchemeAction->execute($data);

        return response()->json($numberingScheme, 201);
    }

    public function update(UpdateNumberingSchemeData $data, NumberingScheme $numberingScheme): JsonResponse
    {
        $numberingScheme = $this->updateNumberingSchemeAction->execute($numberingScheme, $data);

        return response()->json($numberingScheme);
    }

    public function destroy(NumberingScheme $numberingScheme): JsonResponse
    {
        $this->deleteNumberingSchemeAction->execute($numberingScheme);

        return response()->json(['message' => 'Numbering scheme deleted successfully']);
    }
}
