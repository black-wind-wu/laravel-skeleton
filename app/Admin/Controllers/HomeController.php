<?php

namespace App\Admin\Controllers;

use App\Admin\Forms\Settings;
use App\Admin\Metrics\Examples;
use App\Admin\Metrics\NewBaiduPush;
use App\Admin\Metrics\NewBingPush;
use App\Admin\Metrics\NewDevices;
use App\Admin\Metrics\NewUsers;
use App\Http\Controllers\Controller;
use Dcat\Admin\Http\Controllers\Dashboard;
use Dcat\Admin\Layout\Column;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;
use Dcat\Admin\Widgets\Card;

class HomeController extends Controller
{
    public function index(Content $content)
    {
        return $content
            ->header('控制台')
            //->description('Description...')
            ->body(function (Row $row) {
                $row->column(6, function (Column $column) {
                    $column->row(Dashboard::title());
                    $column->row(new Examples\Tickets());
                });

                $row->column(6, function (Column $column) {
                    $column->row(function (Row $row) {
                        $row->column(6, new NewUsers());
                        $row->column(6, new NewDevices());
                    });
                    $column->row(function (Row $row) {
                        $row->column(6, new NewBaiduPush());
                        $row->column(6, new NewBingPush());
                    });

                    $column->row(new Examples\Sessions());
                    $column->row(new Examples\ProductOrders());
                });


            });
    }

    /**
     * 网站设置
     * @param Content $content
     * @return Content
     */
    public function settings(Content $content)
    {
        return $content
            ->title('网站设置')
            ->body(new Card(new Settings()));
    }
}
