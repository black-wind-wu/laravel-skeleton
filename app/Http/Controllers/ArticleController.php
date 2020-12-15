<?php

namespace App\Http\Controllers;

use App\Http\Requests\Article\StoreArticleRequest;
use App\Http\Requests\Article\UpdateArticleRequest;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;

/**
 * 前台文章模型
 * @author Tongle Xu <xutongle@gmail.com>
 */
class ArticleController extends Controller
{
    /**
     * ArticleController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show', 'tag']);
        $this->authorizeResource(Article::class, 'article');
    }

    /**
     * Display a listing of the article.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index()
    {
        $items = Article::approved()->with('user')->orderByDesc('order')->orderByDesc('id')->paginate(15);
        return view('article.index', [
            'items' => $items,
        ]);
    }

    /**
     * 文章Tag页
     * @param Tag $tag
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function tag(Tag $tag)
    {
        $items = $tag->articles()->with(['user'])->paginate(15);
        return view('article.tag', [
            'items' => $items,
            'tag' => $tag
        ]);
    }

    /**
     * Show the form for creating a new article.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        return view('article.create');
    }

    /**
     * Store a newly created article in storage.
     *
     * @param StoreArticleRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreArticleRequest $request)
    {
        $article = Article::create($request->except(['content', 'extra']));
        if ($article && $article->detail()->create($request->only(['content', 'extra']))) {
            $message = '文章发布成功！为了确保文章的质量，我们可能会对您发布的文章进行审核。';
            $this->flash()->info($message);
            return redirect()->route('articles.show', $article);
        }
        $this->flash()->error('文章发布失败，请稍后再试!');
        return redirect()->back();
    }

    /**
     * Display the specified article.
     *
     * @param \App\Models\Article $article
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Article $article)
    {
        /*查看数+1*/
        $article->increment('views');
        return view('article.show', [
            'article' => $article
        ]);
    }

    /**
     * Display the specified article.
     *
     * @param \App\Models\Article $article
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|void
     */
    public function showAmp(Article $article)
    {
        if (settings('system.system.amp_enabled')) {
            return view('article.show_amp', [
                'article' => $article
            ]);
        }
        return abort(404);
    }

    /**
     * Display the specified article.
     *
     * @param \App\Models\Article $article
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|void
     */
    public function showMip(Article $article)
    {
        if (settings('system.system.mip_enabled')) {
            return view('article.show_mip', [
                'article' => $article
            ]);
        }
        return abort(404);
    }

    /**
     * Show the form for editing the specified article.
     *
     * @param \App\Models\Article $article
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Article $article)
    {
        return view('article.edit', [
            'article' => $article
        ]);
    }

    /**
     * Update the specified article in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Article $article
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateArticleRequest $request, Article $article)
    {
        if ($article->update($request->except(['content', 'extra'])) && $article->detail->update($request->only(['content', 'extra']))) {
            $message = '文章更新成功！为了确保文章的质量，我们可能会对您发布的文章进行审核。';
            $this->flash()->info($message);
            return redirect()->route('articles.show', $article);
        }
        $this->flash()->error('文章更新失败，请稍后再试!');
        return redirect()->back();
    }

    /**
     * Remove the specified article from storage.
     *
     * @param \App\Models\Article $article
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Article $article)
    {
        $article->delete();
        return redirect()->route('articles.index');
    }
}
