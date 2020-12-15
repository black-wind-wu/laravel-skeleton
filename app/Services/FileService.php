<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Services;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * 文件处理
 * @author Tongle Xu <xutongle@gmail.com>
 */
class FileService
{
    /**
     * 处理 Html 内容中的远程资源到本地
     * @param string $content
     * @return string[]
     */
    public static function handleContentRemoteFile($content)
    {
        // 匹配<img>、src，存入$matches数组,
        $p = '/<img.*[\s]src=[\"|\'](.*)[\"|\'].*>/iU';
        $num = preg_match_all($p, $content, $matches);
        if ($num) {
            foreach ($matches[1] as $src) {
                if (isset($src) && strpos($src, config('filesystems.disks.' . config('filesystems.cloud') . '.url')) === false) {
                    $ext = File::extension($src);
                    $file_content = static::getRemoteFile($src);
                    if ($ext) {
                        $path = 'images/' . date('Y/m/') . Str::random(40) . '.' . $ext;
                    } else {
                        $path = 'images/' . date('Y/m/') . Str::random(40);
                    }
                    if ($file_content && Storage::cloud()->put($path, $file_content)) {
                        Storage::cloud()->setVisibility($path, Filesystem::VISIBILITY_PUBLIC);
                        $url = Storage::cloud()->url($path);
                        $content = str_replace($src, $url, $content);
                    }
                }
            }
        }
        return $content;
    }

    /**
     * 获取内容中本地媒体列表
     * @param string $content
     * @return array
     */
    public static function getLocalFilesByContent($content): array
    {
        // 匹配<img>、src，存入$matches数组,
        $p = '/<img.*[\s]src=[\"|\'](.*)[\"|\'].*>/iU';
        $num = preg_match_all($p, $content, $matches);
        $files = [];
        if ($num) {
            foreach ($matches[1] as $src) {
                if (isset($src) && strpos($src, config('filesystems.disks.' . config('filesystems.cloud') . '.url')) !== false) {
                    $files[] = $src;
                }
            }
        }
        return $files;
    }

    /**
     * 保存远程文件
     * @param string $url 文件Url
     * @param string $prefix 保存前缀
     * @return mixed
     */
    public static function saveRemoteFile($url, $prefix = 'images')
    {
        $ext = File::extension($url);
        $file_content = static::getRemoteFile($url);
        if ($ext) {
            $path = $prefix . '/' . date('Y/m/') . Str::random(40) . '.' . $ext;
        } else {
            $path = $prefix . '/' . date('Y/m/') . Str::random(40);
        }
        if ($file_content && Storage::cloud()->put($path, $file_content)) {
            Storage::cloud()->setVisibility($path, Filesystem::VISIBILITY_PUBLIC);
            $url = Storage::cloud()->url($path);
        }
        return $url;
    }

    /**
     * 获取远程到临时文件
     * @param string $url
     * @return false|string
     */
    public static function saveRemoteTempFile(string $url)
    {
        $file_name = File::basename($url);
        $file_content = static::getRemoteFile($url);
        $file_path = 'temp/' . $file_name;
        if ($file_content && Storage::cloud()->put($file_path, $file_content)) {
            return $file_path;
        }
        return false;
    }

    /**
     * 模拟浏览器下载远程文件内容
     * @param string $url
     * @return false|string
     */
    public static function getRemoteFile($url)
    {
        $content = false;
        try {
            $content = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.125 Safari/537.36 Edg/84.0.522.59',
            ])->retry(2, 100)->get($url)->throw()->body();
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
        }
        return $content;
    }

    /**
     * 保存上传的文件
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $prefix
     * @return false|string
     */
    public static function store($file, $prefix = 'images')
    {
        $path = $prefix . '/' . date('Y/m');
        if (($fileName = Storage::cloud()->putFile($path, $file, ['visibility' => 'public'])) != false) {
            return Storage::cloud()->url($fileName);
        }
        return false;
    }

    /**
     * 获取文件访问地址
     * @param string $filename
     * @return string
     */
    public static function url(string $filename)
    {
        return Storage::cloud()->url($filename);
    }

    /**
     * 获取临时下载地址
     * @param string $filename
     * @param \DateTimeInterface $expiration 链接有效期
     * @return string
     */
    public static function temporaryUrl(string $filename, \DateTimeInterface $expiration)
    {
        try {
            return Storage::cloud()->temporaryUrl($filename, $expiration);
        } catch (\Exception $e) {
            return static::url($filename);
        }
    }

    /**
     * 删除文件
     * @param string $url
     * @return bool
     */
    public static function deleteFile($url): bool
    {
        $path = parse_url($url, PHP_URL_PATH);
        if ($path && Storage::cloud()->exists($path)) {
            return Storage::cloud()->delete($path);
        }
        return true;
    }
}
