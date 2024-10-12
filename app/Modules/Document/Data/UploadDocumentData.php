<?php

namespace Modules\Document\Data;

use Illuminate\Http\UploadedFile;
use Spatie\LaravelData\Attributes\Validation\File;
use Spatie\LaravelData\Attributes\Validation\Mimes;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation\Uuid;

class UploadDocumentData extends Data
{
    /**
     * @param UploadedFile[] $files
     */
    public function __construct(
        #[Uuid()]
        public string $parent_id,

        #[Required, File, Mimes('pdf', 'docx', 'doc', 'txt', 'png', 'jpg', 'jpeg')]
        public array $files,

        #[Uuid()]
        public ?string $owned_by = null
    ) {}
}
