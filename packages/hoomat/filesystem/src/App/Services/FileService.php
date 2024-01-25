<?php

namespace Hoomat\Filesystem\App\Services;

use Hoomat\Base\App\Services\BaseService;
use Hoomat\Filesystem\App\Facades\Uploader;
use Hoomat\Filesystem\App\Models\DTOs\FileDTO;
use Hoomat\Filesystem\App\Models\File;
use Hoomat\Filesystem\App\Repositories\Interfaces\FileRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;

class FileService extends BaseService
{
    public function __construct(FileRepositoryInterface $fileRepo)
    {
        parent::__construct($fileRepo);
    }


    public function getFolders(int $userId, ?string $folder): array
    {
        $field = $folder ? ['directory', 'type'] : 'directory';
        $path = explode('/', $folder);

        $filters = [['user_id', '=', $userId]];

        if ($folder) {
            if (isset($path[1])) {
                return [];
            }

            $filters[] = ['directory', '=', $path[0]];
        }

        return $this->repository->groupByOn($field, $filters)->map(function($folder) {
            return $folder->type ?? $folder->directory;
        })->unique()->toArray();
    }


    public function getFiles(int $userId, ?string $folder): Collection|array
    {
        if (!$folder) {
            return [];
        }

        $path = explode('/', $folder);

        if (! isset($path[1])) {
            return [];
        }

        return $this->repository->getWithWhere([
            ['user_id', '=', $userId],
            ['directory', '=', $path[0]],
            ['type', '=', $path[1]]
        ]);
    }


    /**
     * Update the alt of File
     */
    public function updateAlt(File $file, string $alt): File
    {
        return $this->repository->updateOne($file, FileDTO::fromModel($file, ['alt' => $alt]));
    }


    public function updateFile($request, File $file): void
    {
        if ($request->hasFile('file')) {
            $this->deleteFromStorage($file);

            $name = $request->input('name') ?? $file->name;

            Uploader::model($file)
                ->fileable($file->fileable)
                ->file($request->file('file'))
                ->name($name)
                ->dir($file->directory)
                ->type($file->type)
                ->upload();
        } else {
            $this->updateAlt($file, $request->input('name'));
        }
    }


    public function deleteItem($item): bool
    {
        $this->deleteFromStorage($item);
        $this->repository->deleteOne($item);
        return true;
    }


    public function deleteFromStorage(File $file): void
    {
        Storage::disk($file->disk)->delete($file->path);
    }
}
