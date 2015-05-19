<?php namespace NielsFilmer\EloquentLister\Headers;


use Illuminate\Http\Request;

abstract class BaseHeader {

    /**
     * Should return the contents of the header cell
     * @return mixed
     */
    abstract public function makeCell();


    /**
     * @var Request
     */
    protected $request;

    /**
     * @var array
     */
    protected $options;

    /**
     * @var string
     */
    protected $display;

    /**
     * @var string
     */
    protected $attribute;

    /**
     * @param $display
     * @param $attribute
     * @param Request $request
     * @param array $options
     */
    public function __construct($display, $attribute, Request $request, array $options = [])
    {
        $this->display = $display;
        $this->attribute = $attribute;
        $this->request = $request;
        $this->options = $options;
    }
}