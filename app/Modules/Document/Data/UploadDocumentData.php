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
    public function __construct(
        #[Uuid()]
        public string $parent_id,

        #[Required]
        public string $name,

        #[Required, File, Mimes('pdf', 'docx', 'doc', 'txt', 'png', 'jpg', 'jpeg')]
        public UploadedFile $file,

        #[Uuid()]
        public ?string $owned_by = null
    ) {}
}
