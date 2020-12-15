<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Http\Controllers;

use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * 上传控制器
 * @author Tongle Xu <xutongle@gmail.com>
 */
class UploaderController extends Controller
{
    /**
     * UploaderController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * CKEditor 5 文件上传
     * @param Request $request
     * @return array
     */
    public function ckeditor(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'upload' => ['required', 'image'],
        ]);
        if ($validator->fails()) {
            return $this->CKEditorUploadResponse(0, $validator->errors()->first());
        } else {
            $file = $request->file('upload');
            return $this->CKEditorUploadResponse(1, '', $file->getClientOriginalName(), FileService::store($file));
        }
    }

    /**
     * CKEditor 上传文件的标准返回格式
     * @param int $uploaded [description]
     * @param string $error [description]
     * @param string $filename [description]
     * @param string $url [description]
     * @return array
     */
    private function CKEditorUploadResponse($uploaded, $error = '', $filename = '', $url = '')
    {
        return [
            "uploaded" => $uploaded,
            "fileName" => $filename,
            "url" => $url,
            "error" => [
                "message" => $error
            ]
        ];
    }
}
