<?php

namespace Hoomat\Filesystem\App\Services;

use Hoomat\Filesystem\App\Models\DTOs\FileDTO;
use Hoomat\Filesystem\App\Models\File;
use Exception;
use Illuminate\Support\Facades\Storage;

class FileUploadService
{
    private ?File $fileModel = null;
    private $file;
    private int $user_id;
    private $fileable;
    private ?string $alt = null;
    private string $disk;
    private string $directory;
    private string $type;
    private string $name;
    private FileDTO $fileDTO;


    public function __construct(
        private readonly FileService $fileService
    )
    {
    }


    /**
     * Upload
     *
     * @throws Exception
     */
    public function upload(): void
    {
        if (! $this->validate()) {
            throw new Exception("File Info is not Valid!");
        }
        $this->disk = $this->disk ?? config('FilesystemConfig.default_disk');
        $this->moveFile();
        $this->prepare();

        if ($this->fileModel) {
            $this->fileService->deleteFromStorage($this->fileModel);
            $this->fileService->update($this->fileModel, $this->fileDTO);
        } else {
            $file = $this->fileService->create($this->fileDTO);
        }
    }


    public function model($model): static
    {
        $this->fileModel = $model;
        return $this;
    }


    public function user(int $userId): static
    {
        $this->user_id = $userId;
        return $this;
    }


    public function fileable($fileable): static
    {
        $this->fileable = $fileable;
        return $this;
    }


    public function file($file): static
    {
        $this->file = $file;
        return $this;
    }


    public function alt(string $alt): static
    {
        $this->alt = $alt;
        return $this;
    }


    public function disk(string $disk): static
    {
        $this->disk = $disk;
        return $this;
    }


    public function dir(string $directory): static
    {
        $this->directory = $directory;
        return $this;
    }


    public function type(string $type): static
    {
        $this->type = $type;
        return $this;
    }


    private function moveFile(): void
    {
        $fileHash = floor(microtime(true) * 1000);
        $name = $fileHash.'.'.$this->file->extension();

        $path = $this->directory.'/'.$this->type.'/'.$name;

        Storage::disk($this->disk)->put($path, file_get_contents($this->file));

        $this->name = $name;
    }


    private function prepare(): void
    {
        $this->fileDTO = new FileDTO(
            user_id: $this->user_id ?? auth()->id(),
            fileable_type: get_class($this->fileable),
            fileable_id: $this->fileable->id,
            alt: $this->alt,
            disk: $this->disk,
            name: $this->name,
            directory: $this->directory,
            type: $this->type
        );
    }


    private function validate(): bool
    {
        return
            $this->directory &&
            $this->type &&
            $this->fileable &&
            $this->file;
    }
}
