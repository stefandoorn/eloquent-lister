<?php namespace NielsFilmer\EloquentLister\Columns;

use Illuminate\Database\Eloquent\Model;


class Checkbox extends BaseColumn {

    protected static $view = 'eloquent-lister::cells.checkbox';

    /**
     * @param Model $row
     *
     * @return \Illuminate\View\View
     */
    public function makeCell(Model $row)
    {
        $attribute = $this->attribute;
        $accessor = $this->accessor;
        $value = $accessor($row->$attribute, $row);
        return view(static::$view, compact('value', 'attribute'));
    }

}
