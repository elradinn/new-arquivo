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
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class NumberingSchemeController extends Controller
{
    public function __construct(
        protected CreateNumberingSchemeAction $createNumberingSchemeAction,
        protected UpdateNumberingSchemeAction $updateNumberingSchemeAction,
        protected DeleteNumberingSchemeAction $deleteNumberingSchemeAction,
    ) {}

    /**
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $numberingSchemes = NumberingScheme::query()
            ->when($search, function ($query, $search) {
                $searchableColumns = ['name'];

                $query->where(function ($query) use ($search, $searchableColumns) {
                    foreach ($searchableColumns as $column) {
                        $query->orWhere($column, 'like', "%{$search}%");
                    }
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('NumberingScheme', [
            'numberingSchemes' => NumberingSchemeResourceData::collect($numberingSchemes),
            'filters' => $request->only(['search']),
        ]);
    }

    public function show(NumberingScheme $numberingScheme): JsonResponse
    {
        return response()->json($numberingScheme);
    }

    public function store(CreateNumberingSchemeData $data): RedirectResponse
    {
        $this->createNumberingSchemeAction->execute($data);

        return redirect()->back();
    }

    public function update(UpdateNumberingSchemeData $data, NumberingScheme $numberingScheme): RedirectResponse
    {
        $numberingScheme = $this->updateNumberingSchemeAction->execute($numberingScheme, $data);

        return redirect()->back();
    }

    public function destroy(NumberingScheme $numberingScheme): JsonResponse
    {
        $this->deleteNumberingSchemeAction->execute($numberingScheme);

        return response()->json(['message' => 'Numbering scheme deleted successfully']);
    }

    public function getNumberingSchemeOfFolder(NumberingScheme $numberingScheme): JsonResponse
    {
        return response()->json($numberingScheme);
    }
}
