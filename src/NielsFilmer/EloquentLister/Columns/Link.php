<?php
/**
 * Created by PhpStorm.
 * User: nielsfilmer
 * Date: 17/08/16
 * Time: 11:38
 */

namespace NielsFilmer\EloquentLister\Columns;

use Illuminate\Database\Eloquent\Model;


class Link extends BaseColumn {

    protected static $view = 'eloquent-lister::cells.link';

    /**
     * @param Model $row
     *
     * @return \Illuminate\View\View
     */
    public function makeCell(Model $row)
    {
        $attribute = $this->attribute;
        $target = $this->getOption('target');
        $accessor = $this->accessor;
        $value = $accessor($row->$attribute, $row);

        if(is_array($value) && isset($value['display']) && isset($value['link'])) {
            $display = $value['display'];
            $link = $value['link'];
        } else if(is_object($value) && isset($value->display) && isset($value->link)) {
            $display = $value->display;
            $link = $value->link;
        } else if(is_string($value)) {
            $display = $value;
            $link = $value;
        } else {
            throw new \InvalidArgumentException("Found no valid value for Link cell");
        }

        return view(static::$view, compact('target', 'link', 'display'));
    }

}