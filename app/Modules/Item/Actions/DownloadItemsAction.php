<?php

namespace Modules\Item\Actions;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Modules\Item\Data\DownloadItemsData;
use Modules\Item\Models\Item;
use Illuminate\Support\Str;
use ZipArchive;

class DownloadItemsAction
{
    public function execute(DownloadItemsData $data)
    {
        $parent = $data->parent_id ? Item::find($data->parent_id) : null;

        $all = $data->all;
        $ids = $data->ids;

        if (!$all && empty($ids)) {
            return [
                'message' => 'Please select items to download'
            ];
        }

        if ($all) {
            if (!$parent) {
                return [
                    'message' => 'Parent item not found.'
                ];
            }

            $url = $this->createZip($parent->getChildren()->load('folder', 'document'));
            $filename = $parent->folder->name ?? $parent->workspace->name . '.zip';
        } else {
            [$url, $filename, $message] = $this->getDownloadUrl($ids, $parent ? $parent->folder->name ?? $parent->workspace->name : 'download');

            if ($message) {
                return [
                    'message' => $message
                ];
            }
        }

        return [
            'url' => $url,
            'filename' => $filename
        ];
    }

    public function createZip($items): string
    {
        $zipPath = 'zip/' . Str::random() . '.zip';
        $publicPath = "public/$zipPath";

        if (!Storage::exists('zip')) {
            Storage::makeDirectory('zip');
        }

        $zipFile = Storage::path($publicPath);

        $zip = new ZipArchive();

        Log::info('createZip: ' . $items);

        if ($zip->open($zipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            $this->addItemsToZip($zip, $items);
            $zip->close();
        } else {
            Log::error("Failed to create zip file at $zipFile");
            return '';
        }

        return Storage::url($zipPath);
    }

    private function addItemsToZip($zip, $items, $ancestors = '')
    {
        Log::info("What are we adding to the zip?: " . json_encode($items));
        Log::info('Item Folder: ' . $items);

        foreach ($items as $item) {
            if ($item->folder) {
                $this->addItemsToZip($zip, $item->getChildren()->load('folder', 'document'), $ancestors . $item->folder->name . '/');
            } else {
                $document = $item->document;
                $publicPath = Storage::disk('public')->path($document->file_path);

                Log::info('Document where na u?: ' . $document);

                if ($document->uploaded_on_cloud) {
                    // Assuming the file is accessible via the public disk
                    $dest = pathinfo($document->file_path, PATHINFO_BASENAME);
                    $content = Storage::get($document->file_path);
                    Storage::disk('public')->put($dest, $content);
                    $publicPath = Storage::disk('public')->path($dest);
                }

                if (file_exists($publicPath)) {
                    $zip->addFile($publicPath, $ancestors . $document->name);
                } else {
                    Log::warning("File not found: $publicPath");
                }
            }
        }
    }

    private function getDownloadUrl(array $ids, $zipName)
    {
        if (count($ids) === 1) {
            $item = Item::find($ids[0]);
            if (!$item) {
                return [null, null, 'Item not found.'];
            }

            if ($item->folder) {
                Log::info('Count of empty folder?: ' . $item->getChildren()->load('folder', 'document')->count());
                if ($item->getChildren()->load('folder', 'document')->count() === 0) {
                    return [null, null, 'The folder is empty'];
                }
                $url = $this->createZip($item->getChildren()->load('folder', 'document'));
                $filename = $item->folder->name . '.zip';
            } elseif ($item->document) {
                $document = $item->document;
                Log::info('Are you there solo document download path?: ' . json_encode($document->file_path));
                $dest = pathinfo($document->file_path, PATHINFO_BASENAME);

                try {
                    if ($document->uploaded_on_cloud) {
                        $content = Storage::get($document->file_path);
                    } else {
                        $content = Storage::disk('public')->get($document->file_path);
                        Log::info('File content where na u?: ' . $content);
                    }

                    if ($content === null) {
                        throw new \Exception('File content is null.');
                    }
                } catch (\Exception $e) {
                    Log::error("Error fetching file content: " . $e->getMessage());
                    return [null, null, 'Error fetching file content.'];
                }

                Log::debug("Getting file content. File: " . $document->file_path . ". Content length: " . strlen($content));

                $success = Storage::disk('public')->put($dest, $content);
                Log::debug('Inserted in public disk. "' . $dest . '". Success: ' . intval($success));

                if (!$success) {
                    return [null, null, 'Failed to store the file for download.'];
                }

                $url = Storage::url($dest);
                Log::debug("Logging URL " . $url);
                $filename = $document->name;
            } else {
                return [null, null, 'Selected item is neither a folder nor a document.'];
            }
        } else {
            $items = Item::whereIn('id', $ids)->get();
            $url = $this->createZip($items);
            $filename = $zipName . '.zip';
        }

        return [$url, $filename, null];
    }
}
