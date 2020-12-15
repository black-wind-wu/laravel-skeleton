<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Http\Controllers;

/**
 * 单页面
 * @author Tongle Xu <xutongle@gmail.com>
 */
class PageController extends Controller
{
    /**
     * Displays Privacy page.
     *
     * @return mixed
     */
    public function about()
    {
        return view('page.about');
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function contact()
    {
        return view('page.contact');
    }

    /**
     * Displays Terms of Use page.
     *
     * @return mixed
     */
    public function terms()
    {
        return view('page.terms');
    }

    /**
     * Displays Copyright page.
     *
     * @return mixed
     */
    public function copyright()
    {
        return view('page.copyright');
    }

    /**
     * Displays Privacy page.
     *
     * @return mixed
     */
    public function privacy()
    {
        return view('page.privacy');
    }

    /**
     * Displays link page.
     *
     * @return mixed
     */
    public function delete()
    {
        return view('page.delete');
    }

    /**
     * Displays adm page.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function adm()
    {
        return view('page.adm');
    }

    /**
     * Displays link page.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function link()
    {
        return view('page.link');
    }
}
