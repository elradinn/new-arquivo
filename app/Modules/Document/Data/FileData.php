<?php

namespace Modules\Document\Data;

use Spatie\LaravelData\Data;
use Illuminate\Http\UploadedFile;
use Spatie\LaravelData\Attributes\Validation\Mimes;
use Spatie\LaravelData\Attributes\Validation\Required;

class FileData extends Data
{
    public function __construct(
        #[Required, Mimes('pdf', 'txt', 'docx', 'doc', 'png', 'jpg', 'jpeg')]
        public UploadedFile $file
    ) {}

    public function getUploadedFile(): UploadedFile
    {
        return $this->file;
    }
}
