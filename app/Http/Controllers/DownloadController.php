<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Http\Controllers;

use App\Http\Requests\Download\StoreDownloadRequest;
use App\Http\Requests\Download\UpdateDownloadRequest;
use App\Models\Category;
use App\Models\Download;
use App\Models\Tag;
use Illuminate\Http\Request;

/**
 * 下载页面
 * @author Tongle Xu <xutongle@gmail.com>
 */
class DownloadController extends Controller
{
    /**
     * DownloadController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show', 'tag']);
        $this->authorizeResource(Download::class, 'download');
    }

    /**
     * Display a listing of the downloads.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $items = Download::approved()->with('user')->orderByDesc('id')->paginate(15);
        return view('download.index', [
            'items' => $items,
        ]);
    }

    /**
     * 下载Tag页
     * @param Tag $tag
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function tag(Tag $tag)
    {
        $items = $tag->downloads()->with(['user'])->paginate(15);
        return view('download.tag', [
            'items' => $items,
            'tag' => $tag
        ]);
    }

    /**
     * Show the form for creating a new download.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        return view('download.create');
    }

    /**
     * Store a newly created download in storage.
     *
     * @param StoreDownloadRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreDownloadRequest $request)
    {
        $download = Download::create($request->validated());
        if ($download) {
            $message = '发布成功！为了确保内容的质量，我们可能会对您的发布进行审核。';
            $this->flash()->info($message);
            return redirect()->route('downloads.show', $download);
        }
        $this->flash()->error('发布失败，请稍后再试!');
        return redirect()->back();
    }

    /**
     * 查看下载详情
     * @param Download $download
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Download $download)
    {
        /*查看数+1*/
        $download->increment('views');
        return view('download.show', [
            'download' => $download
        ]);
    }

    /**
     * Show the form for editing the specified download.
     *
     * @param Download $download
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function edit(Download $download)
    {
        return view('download.edit', [
            'download' => $download
        ]);
    }

    /**
     * Update the specified download in storage.
     *
     * @param UpdateDownloadRequest $request
     * @param Download $download
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateDownloadRequest $request, Download $download)
    {
        if ($download->update($request->validated())) {
            $message = '更新成功！为了确保内容的质量，我们可能会对您发布的内容进行审核。';
            $this->flash()->info($message);
            return redirect()->route('downloads.show', $download);
        }
        $this->flash()->error('更新失败，请稍后再试!');
        return redirect()->back();
    }

    /**
     * Remove the specified article from storage.
     *
     * @param Download $download
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Download $download)
    {
        $download->delete();
        return redirect()->route('downloads.index');
    }

    /**
     * 下载文件
     * @param Download $download
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function download(Download $download)
    {

    }
}
