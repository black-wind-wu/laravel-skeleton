<?php

namespace App\Admin\Actions\Grid;

use Dcat\Admin\Actions\Response;
use Dcat\Admin\Grid\Tools\AbstractTool;
use Illuminate\Http\Request;

/**
 * 永久删除
 * @author Tongle Xu <xutongle@gmail.com>
 */
class ForceDelete extends AbstractTool
{
    /**
     * @return string
     */
    protected $title = '清空回收站';

    protected $model;

    /**
     * ForceDelete constructor.
     * @param string|null $model
     */
    public function __construct(string $model = null)
    {
        $this->model = $model;
        parent::__construct($this->title);
    }

    /**
     * Handle the action request.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function handle(Request $request)
    {
        $model = $request->get('model');
        $model::onlyTrashed()->forceDelete();
        return $this->response()->success('已清空')->refresh();
    }

    /**
     * @return string|array|void
     */
    public function confirm()
    {
        return ['确定清空吗？'];
    }

    /**
     * @return array
     */
    protected function parameters()
    {
        return [
            'model' => $this->model,
        ];
    }
}
