<?php

namespace Modules\Document\Data;

use Illuminate\Http\UploadedFile;
use Spatie\LaravelData\Attributes\Validation\File;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation\Mimes;
use Spatie\LaravelData\Attributes\Validation\Required;

class FileData extends Data
{
    public function __construct(
        #[Required, File, Mimes('pdf', 'docx', 'doc', 'txt', 'png', 'jpg', 'jpeg')]
        public UploadedFile $file
    ) {}
}
