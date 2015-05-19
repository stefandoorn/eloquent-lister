<?php namespace NielsFilmer\EloquentLister;


use Illuminate\Http\Request;
use NielsFilmer\EloquentLister\Exceptions\ModelListerException;

class Factory {

    /**
     * @param $class
     * @param $attribute
     * @param callable $accessor
     * @param array $options
     *
     * @return mixed
     * @throws ModelListerException
     */
    public function makeColumn($class, $attribute, callable $accessor, array $options = [])
    {
        $class = $this->makeClassName($class, 'column');
        return new $class($attribute, $accessor, $options);
    }


    /**
     * @param $class
     * @param $display
     * @param $attribute
     * @param Request $request
     * @param $options
     *
     * @return mixed
     * @throws ModelListerException
     */
    public function makeHeader($class, $display, $attribute, Request $request, $options)
    {
        $class = $this->makeClassName($class, 'header');
        return new $class($display, $attribute, $request, $options);
    }


    /**
     * @param $class
     * @param $type
     *
     * @return string
     * @throws ModelListerException
     */
    protected function makeClassName($class, $type)
    {
        if(class_exists($class)) {
            return $class;
        }

        $class = ucfirst($class);
        $type = ucfirst($type);
        $basename = str_plural($type);
        $full_class = __NAMESPACE__ . "\\{$basename}\\{$class}";

        if(!class_exists($full_class)) {
            throw new ModelListerException("{$type} type {$class} does not exist");
        }

        return $full_class;
    }
}