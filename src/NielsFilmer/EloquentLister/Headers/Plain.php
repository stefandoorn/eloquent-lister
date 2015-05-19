<?php namespace NielsFilmer\EloquentLister\Headers;


class Plain extends BaseHeader {

    protected static $view = 'eloquent-lister::headers.plain';

    /**
     * @return \Illuminate\View\View
     */
    public function makeCell()
    {
        $display = $this->display;
        return view(static::$view, compact('display'));
    }
}