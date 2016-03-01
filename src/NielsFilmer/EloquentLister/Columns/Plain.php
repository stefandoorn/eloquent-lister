<?php namespace NielsFilmer\EloquentLister\Columns;

use Illuminate\Database\Eloquent\Model;


class Plain extends BaseColumn {

    protected static $view = 'eloquent-lister::cells.plain';

    /**
     * @param Model $row
     *
     * @return \Illuminate\View\View
     */
    public function makeCell(Model $row)
    {
        $attribute = $this->attribute;
        $raw = $this->getOption('raw');
        $accessor = $this->accessor;
        $value = $accessor($row->$attribute);
        return view(static::$view, compact('raw', 'value'));
    }

}
