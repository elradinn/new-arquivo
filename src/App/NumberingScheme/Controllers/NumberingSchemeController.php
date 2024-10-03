<?php

namespace App\NumberingScheme\Controllers;

use App\Common\Controllers\Controller;
use Domain\NumberingScheme\Actions\CreateNumberingSchemeAction;
use Domain\NumberingScheme\Actions\DeleteNumberingSchemeAction;
use Domain\NumberingScheme\Actions\UpdateNumberingSchemeAction;
use Domain\NumberingScheme\Data\CreateNumberingSchemeData;
use Domain\NumberingScheme\Data\NumberingSchemeResourceData;
use Domain\NumberingScheme\Data\UpdateNumberingSchemeData;
use Domain\NumberingScheme\Models\NumberingScheme;
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
