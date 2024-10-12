<?php

namespace Modules\Metadata\Controllers;

use App\Modules\Metadata\Data\MetadataResourceData;
use Modules\Common\Controllers\Controller;
use Modules\Metadata\Models\Metadata;
use Modules\Metadata\Data\CreateMetadataData;
use Modules\Metadata\Data\UpdateMetadataData;
use Modules\Metadata\Actions\CreateMetadataAction;
use Modules\Metadata\Actions\UpdateMetadataAction;
use Modules\Metadata\Actions\DeleteMetadataAction;
use Illuminate\Http\JsonResponse;
use Inertia\Inertia;

class MetadataController extends Controller
{
    public function __construct(
        protected CreateMetadataAction $createMetadataAction,
        protected UpdateMetadataAction $updateMetadataAction,
        protected DeleteMetadataAction $deleteMetadataAction
    ) {}

    /**
     * Display a listing of the metadata.
     */
    public function index()
    {
        // $metadata = Metadata::all();
        // return response()->json($metadata, 200);

        return Inertia::render('Metadata/Metadata.page', [
            'metadata' => MetadataResourceData::collect(Metadata::all()),
        ]);
    }

    /**
     * Store a newly created metadata in storage.
     */
    public function store(CreateMetadataData $data): JsonResponse
    {
        $metadata = $this->createMetadataAction->execute($data);
        return response()->json($metadata, 201);
    }

    /**
     * Update the specified metadata in storage.
     */
    public function update(UpdateMetadataData $data, Metadata $metadata): JsonResponse
    {
        $metadata = $this->updateMetadataAction->execute($metadata, $data);
        return response()->json($metadata, 200);
    }

    /**
     * Remove the specified metadata from storage.
     */
    public function destroy(Metadata $metadata): JsonResponse
    {
        $this->deleteMetadataAction->execute($metadata);
        return response()->json(['message' => 'Metadata deleted successfully.'], 200);
    }
}
