<?php

namespace App\Modules\Item\Controllers;

use App\Modules\Item\Actions\GetTrashedItemAction;
use Inertia\Inertia;
use Modules\Common\Controllers\Controller;

class TrashController extends Controller
{
    public function __construct(
        protected GetTrashedItemAction $getTrashedItemAction
    ) {}

    public function index()
    {
        $data = $this->getTrashedItemAction->execute();


        return Inertia::render('Trash/Trash.page', $data);
    }
}
