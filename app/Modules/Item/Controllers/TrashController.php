<?php

namespace App\Modules\Item\Controllers;

use Inertia\Inertia;
use Modules\Common\Controllers\Controller;

class TrashController extends Controller
{
    public function index()
    {
        return Inertia::render('Trash/Trash.page');
    }
}
