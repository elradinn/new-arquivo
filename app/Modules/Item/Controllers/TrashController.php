<?php

namespace App\Modules\Item\Controllers;

use App\Modules\Item\Actions\GetTrashedItemAction;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Modules\Common\Controllers\Controller;
use Modules\Item\Actions\DeleteTrashedItemsAction;
use Modules\Item\Actions\RestoreTrashedItemsAction;
use Modules\Item\Data\DeleteTrashedItemsData;
use Modules\Item\Data\RestoreTrashedItemsData;

class TrashController extends Controller
{
    public function __construct(
        protected GetTrashedItemAction $getTrashedItemAction,
        protected DeleteTrashedItemsAction $deleteTrashedItemsAction,
        protected RestoreTrashedItemsAction $restoreTrashedItemsAction
    ) {}

    public function index()
    {
        $data = $this->getTrashedItemAction->execute();


        return Inertia::render('Trash/Trash.page', $data);
    }

    public function delete(DeleteTrashedItemsData $data): RedirectResponse
    {
        $this->deleteTrashedItemsAction->execute($data);

        return redirect()->back();
    }

    public function restore(RestoreTrashedItemsData $data): RedirectResponse
    {
        $this->restoreTrashedItemsAction->execute($data);

        return redirect()->back();
    }
}
