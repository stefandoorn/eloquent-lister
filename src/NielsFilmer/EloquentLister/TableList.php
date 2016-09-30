<?php namespace NielsFilmer\EloquentLister;

use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use NielsFilmer\EloquentLister\Exceptions\ModelListerException;

abstract class TableList {

    /**
     * @var array
     */
    protected $columns = [];

    /**
     * @var array
     */
    protected $data = [];

    /**
     * The function that gets called to build the table.
     * All Columns should be added here.
     *
     * @return mixed
     */
    abstract protected function buildTable();


    /**
     * Adds a plain column to the table
     *
     * @param $attribute
     * @param $display
     * @param array $options
     *
     * @return TableList
     * @throws ModelListerException
     */
    protected function addColumn( $attribute, $display, array $options = [] )
    {
        if($attribute == 'delete') {
            throw new ModelListerException('"delete" is a reserved attribute and cannot be used');
        }

        $this->columns[] = [
            'type'      => array_get($options, 'type', 'plain'),
            'attribute' => $attribute,
            'display'   => $display,
            'accessor'  => $this->makeAccessor($options),
            'options'   => $options,
        ];

        return $this;
    }


    /**
     * Getter for columns
     *
     * @param array $data
     *
     * @return array
     */
    final public function getColumns(array $data = [])
    {
        $this->data = $data;
        $this->buildTable();
        return $this->columns;
    }


    /**
     * Returns an accessor for the column value
     *
     * @param array $options
     *
     * @return callable
     */
    protected function makeAccessor(array $options)
    {
        if(isset($options['accessor'])) {
            return $options['accessor'];
        } else if(isset($options['values'])) {
            $values = $options['values'];
            return function($value) use ($values) {
                return array_get($values, $value, $value);
            };
        } else {
            return function($value) {
                return $value;
            };
        }
    }


    /**
     * @param $key
     *
     * @return mixed
     */
    protected function getData($key)
    {
        return array_get($this->data, $key);
    }
}