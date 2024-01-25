<?php

namespace Hoomat\Filesystem\App\Http\Controllers;

use Hoomat\Base\App\Http\Controllers\Controller;
use Hoomat\Filesystem\App\Facades\Uploader;
use Hoomat\Filesystem\App\Http\Requests\FileUpdateRequest;
use Hoomat\Filesystem\App\Http\Resources\FilesystemResource;
use Hoomat\Filesystem\App\Models\File;
use Hoomat\Filesystem\App\Services\FileService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

/**
 * @group Filesystem
 */
class FileController extends Controller
{
    public function __construct(
        private readonly FileService $fileService
    )
    {
    }


    /**
     * File Index
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $folder = $request->input('folder');
        $userId = auth('sanctum')->id();

        return $this->successResponse([
            'folders' => $this->fileService->getFolders($userId, $folder),
            'files' => FilesystemResource::collection($this->fileService->getFiles($userId, $folder))
        ]);
    }


    /**
     * File Update
     *
     * @param FileUpdateRequest $request
     * @param File              $file
     * @return JsonResponse
     */
    public function update(FileUpdateRequest $request, File $file): JsonResponse
    {
        Gate::authorize('update', $file);

        $this->fileService->updateFile($request, $file);

        return $this->dynamicResponse(
            $this->fileService->show($file->id),
            FilesystemResource::class
        );
    }


    /**
     * File Delete
     *
     * @param File $file
     * @return JsonResponse
     */
    public function destroy(File $file): JsonResponse
    {
        Gate::authorize('delete', $file);

        if ($file->fileable && $file->fileable->files()->where('type', $file->type)->count() <= 1) {
            return $this->errorResponse([], 400, __('error.cant_delete_file'));
        }

        $this->fileService->deleteItem($file);

        return $this->successResponse();
    }
}
