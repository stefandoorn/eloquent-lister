<?php namespace NielsFilmer\EloquentLister\Columns;


use Illuminate\Database\Eloquent\Model;

class Actions extends BaseColumn {

    /**
     * @var string
     */
    protected static $view = 'eloquent-lister::cells.actions';


    /**
     * @param Model $model
     *
     * @return \Illuminate\View\View
     */
    public function makeCell(Model $model)
    {
        $btn_show = $this->getOption('show_action', true);
        $btn_edit = $this->getOption('edit_action', true);
        $btn_destroy = $this->getOption('destroy_action', true);

        $key = $model->getKey();
        $slug = $this->getOption('slug');

        return view(static::$view, compact('btn_show', 'btn_edit', 'btn_destroy', 'key', 'slug'));
    }

}