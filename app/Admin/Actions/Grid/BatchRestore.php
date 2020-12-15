<?php

namespace App\Admin\Actions\Grid;

use Dcat\Admin\Actions\Response;
use Dcat\Admin\Grid\BatchAction;
use Dcat\Admin\Traits\HasPermissions;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * 批量恢复
 * @author Tongle Xu <xutongle@gmail.com>
 */
class BatchRestore extends BatchAction
{
    protected $title = '<i class="feather icon-rotate-ccw"></i> '.'恢复';

    protected $model;

    /**
     * BatchRestore constructor.
     * @param string|null $model
     */
    public function __construct(string $model = null)
    {
        $this->model = $model;
        parent::__construct($this->title);
    }

    public function handle(Request $request)
    {
        $model = $request->get('model');
        foreach ((array)$this->getKey() as $key) {
            $model::withTrashed()->findOrFail($key)->restore();
        }
        return $this->response()->success('已恢复')->refresh();
    }

    public function confirm()
    {
        return ['确定恢复吗？'];
    }

    public function parameters()
    {
        return [
            'model' => $this->model,
        ];
    }
}
