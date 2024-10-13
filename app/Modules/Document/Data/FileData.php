<?php

namespace Modules\Document\Data;

use Spatie\LaravelData\Data;
use Illuminate\Http\UploadedFile;
use Spatie\LaravelData\Attributes\Validation\MimeTypes;
use Spatie\LaravelData\Attributes\Validation\Required;

class FileData extends Data
{
    public function __construct(
        #[Required, MimeTypes('text/plain', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'image/png', 'image/jpeg')]
        public UploadedFile $file
    ) {}

    public function getUploadedFile(): UploadedFile
    {
        return $this->file;
    }
}
