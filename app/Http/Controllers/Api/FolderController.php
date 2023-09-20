<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Folder;
use Illuminate\Http\JsonResponse;

class FolderController extends Controller
{
    public function tree(): JsonResponse
    {
        return response()->json(Folder::getTree());
    }
}
