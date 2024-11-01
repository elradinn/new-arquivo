<?php

namespace Modules\Dashboard\Data;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation\Required;

class DashboardReportParametersData extends Data
{
    public function __construct(
        public ?string $document_status = null,
        public ?string $start_date = null,
        public ?string $end_date = null,
        #[Required]
        public array $metadata_ids = []
    ) {}
}
