<?php

namespace Modules\Item\Actions;

use Modules\Item\Data\DownloadItemsData;
use Modules\Item\Models\Item;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use ZipArchive;
use Illuminate\Support\Facades\Log;
use Modules\Folder\Models\Folder;

class DownloadItemsAction
{
    /**
     * Executes the download process.
     *
     * @param DownloadItemsData $data
     * @return array
     */
    public function execute(DownloadItemsData $data): array
    {
        Log::info('Data: ' . json_encode($data));
        // Fetch items based on the 'all' flag or specific IDs
        if ($data->all) {
            if (!$data->parent_id) {
                throw new \InvalidArgumentException('Parent ID is required when downloading all items.');
            }

            $items = Item::where('parent_id', $data->parent_id)->with(['document', 'folder'])->get();
        } else {
            if (empty($data->ids)) {
                throw new \InvalidArgumentException('No item IDs provided for download.');
            }

            $items = Item::whereIn('id', $data->ids)->with(['document', 'folder'])->get();
        }

        if ($items->isEmpty()) {
            throw new \Exception('No valid items found for download.');
        }

        // Collect all file paths
        $files = $this->collectFiles($items);

        if (empty($files)) {
            throw new \Exception('No files found to download.');
        }

        // If there's only one file, return its direct URL
        if (count($files) === 1) {
            $file = $files[0];
            $fileUrl = Storage::disk('public')->url($file['path']);
            return [
                'url' => $fileUrl,
                'filename' => $file['name'],
            ];
        }

        // Create a unique ZIP file name
        $zipFileName = 'downloads/' . Str::uuid() . '.zip';

        // Ensure the downloads directory exists
        Storage::disk('public')->makeDirectory('downloads');

        // Initialize ZipArchive
        $zip = new ZipArchive;
        $zipPath = storage_path('app/public/' . $zipFileName);

        if ($zip->open($zipPath, ZipArchive::CREATE) === TRUE) {
            foreach ($files as $file) {
                $filePath = storage_path('app/public/' . $file['path']);
                if (file_exists($filePath)) {
                    // Add file to the ZIP archive with its original name
                    $zip->addFile($filePath, $file['name']);
                } else {
                    Log::warning("File not found: {$filePath}");
                }
            }
            $zip->close();
        } else {
            throw new \Exception('Failed to create ZIP archive.');
        }

        // Generate a publicly accessible URL for the ZIP file
        $zipUrl = Storage::disk('public')->url($zipFileName);

        return [
            'url' => $zipUrl,
            'filename' => 'download.zip',
        ];
    }

    /**
     * Recursively collects all file paths from the selected items.
     *
     * @param \Illuminate\Support\Collection $items
     * @return array
     */
    private function collectFiles($items): array
    {
        $files = [];

        foreach ($items as $item) {
            if ($item->document) {
                $files[] = [
                    'path' => $item->document->file_path,
                    'name' => $item->document->name,
                ];
            }

            if ($item->folder) {
                Log::info('An empty folder?: ' . $item->folder);
                $folderFiles = $this->getAllFilesInFolder($item->folder);
                $files = array_merge($files, $folderFiles);
            }
        }


        return $files;
    }

    /**
     * Recursively retrieves all files within a folder and its subfolders.
     *
     * @param \Modules\Folder\Models\Folder $folder
     * @return array
     */
    private function getAllFilesInFolder(Folder $folder): array
    {
        $files = [];

        // Get documents in the current folder
        $itemDocuments = $folder->item->getChildren()->load('document');
        Log::info('Are there documents?: ' . json_encode($itemDocuments));
        foreach ($itemDocuments as $item) {
            if ($item->document) {
                $files[] = [
                    'path' => $item->document->file_path,
                    'name' => $item->document->name,
                ];
            }
        }

        // Get subfolders and recursively get their files
        $subfolders = $folder->item->getChildren()->load('folder');
        Log::info($subfolders);
        foreach ($subfolders as $subfolder) {
            if ($subfolder->folder) {
                $files = array_merge($files, $this->getAllFilesInFolder($subfolder->folder));
            }
        }


        return $files;
    }
}
