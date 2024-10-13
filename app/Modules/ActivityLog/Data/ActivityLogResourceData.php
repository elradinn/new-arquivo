<?php

namespace App\Modules\ActivityLog\Data;

use Spatie\LaravelData\Resource;
use Spatie\Activitylog\Models\Activity;

class ActivityLogResourceData extends Resource
{
    public function __construct(
        public string $date,
        public string $time,
        public string $user_name,
        public string $user_email,
        public string $subject_type,
        public ?string $subject_name,
        public ?string $subject_link,
        public string $description
    ) {}

    public static function fromModel(Activity $activityLog): self
    {
        return new self(
            date: $activityLog->created_at->toDateString(),
            time: $activityLog->created_at->toTimeString(),
            user_name: $activityLog->causer?->name ?? 'System',
            user_email: $activityLog->causer?->email ?? 'System',
            subject_type: ucfirst(strtolower(basename(str_replace('\\', '/', $activityLog->subject_type)))),
            subject_name: $activityLog->subject?->name ?? null,
            subject_link: self::generateSubjectLink($activityLog),
            description: $activityLog->description
        );
    }

    private static function generateSubjectLink(Activity $activityLog): ?string
    {
        if (!$activityLog->subject_id || !$activityLog->subject_type) {
            return null;
        }

        $baseUrl = match ($activityLog->subject_type) {
            'Modules\Workspace\Models\Workspace' => '/workspace/',
            'Modules\Folder\Models\Folder' => '/folder/',
            'Modules\Document\Models\Document' => '/document/',
            'Modules\Metadata\Models\Metadata' => '/metadata/',
            default => null,
        };

        return $baseUrl ? $baseUrl . $activityLog->subject_id : null;
    }
}
