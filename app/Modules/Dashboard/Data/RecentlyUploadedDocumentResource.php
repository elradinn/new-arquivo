<?php

namespace Modules\Dashboard\Data;

use Modules\Document\Models\Document;
use Spatie\LaravelData\Data;

class RecentlyUploadedDocumentResource extends Data
{
    public function __construct(
        public string $name,
        public string $status,
        public string $date_uploaded
    ) {}
}
