<?php namespace NielsFilmer\EloquentLister\Columns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use NielsFilmer\EloquentLister\Headers\BaseHeader;


abstract class BaseColumn {

    /**
     * Should make the display value for a cell
     *
     * @param $row
     *
     * @return mixed
     */
    abstract public function makeCell(Model $row);

    /**
     * @var string
     */
    protected $attribute;

    /**
     * @var array
     */
    protected $data;

    /**
     * @var array
     */
    protected $options;

    /**
     * @var callable
     */
    protected $accessor;

    /**
     * @var BaseHeader
     */
    protected $header;

    /**
     * @param $attribute
     * @param callable $accessor
     * @param array $options
     */
    public function __construct($attribute, callable $accessor, array $options = [])
    {
        $this->attribute = $attribute;
        $this->accessor = $accessor;
        $this->options = $options;
    }

    /**
     * Sets an option
     *
     * @param $key
     * @param $value
     *
     * @return $this
     */
    protected function setOption($key, $value)
    {
        $this->options[$key] = $value;
        return $this;
    }

    /**
     * Returns the value of a setting (or null if it doesn't exist)
     *
     * @param $key
     * @param null $default
     *
     * @return mixed
     */
    public function getOption($key, $default = null)
    {
        return array_get($this->options, $key, $default);
    }

    /**
     * Sets the builder for the header cell
     *
     * @param BaseHeader $header
     * @return $this
     */
    public function setHeader(BaseHeader $header)
    {
        $this->header = $header;
        return $this;
    }

    /**
     * Returns the content for the header cell
     *
     * @return mixed
     */
    public function makeHeader()
    {
        return $this->header->makeCell();
    }
}