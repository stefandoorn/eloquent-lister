<?php namespace NielsFilmer\EloquentLister;


use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class ListBuilder {

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var array
     */
    protected $config;

    /**
     * @var TableList
     */
    protected $list;

    /**
     * @var LengthAwarePaginator|Collection
     */
    protected $collection;

    /**
     * @var array
     */
    protected $settings;

    /**
     * @var Factory
     */
    protected $factory;


    /**
     * @param Request $request
     * @param Factory $factory
     * @param array $config
     */
    public function __construct(Request $request, Factory $factory, array $config)
    {
        $this->request = $request;
        $this->factory = $factory;
        $this->config = $config;
    }


    /**
     * @param TableList $list
     * @param LengthAwarePaginator|Collection $collection
     * @param array $settings
     * @return ListBuilder
     */
    public function build(TableList $list, $collection, array $settings = [])
    {
        $this->list = $list;
        $this->collection = $collection;
        $this->settings = $settings;
        return $this;
    }


    /**
     * Walks through the collection to build a data array
     * TODO: This is kind of messy. Maybe refactor
     *
     * @param TableList $list
     * @return array
     */
    protected function buildColumns(TableList $list)
    {
        $column_data = $list->getColumns($this->getSetting('data'));
        $factory = $this->factory;
        $columns = [];

        foreach($column_data as $data) {
            $data['options']['slug'] = $this->getSlug();
            $column = $factory->makeColumn($data['type'], $data['attribute'], $data['accessor'], $data['options']);

            $header_type = (array_get($data['options'], 'orderable')) ? 'orderable' : 'plain';
            $header = $factory->makeHeader($header_type, $data['display'], $data['attribute'], $this->request, $data['options']);

            $column->setHeader($header);
            $columns[] = $column;
        }

        return $columns;
    }


    /**
     * @return \Illuminate\View\View
     */
    public function makeView()
    {
        $columns    = $this->buildColumns($this->list);
        $slug       = $this->getSlug();
        $pagination = ($this->collection instanceof LengthAwarePaginator)
            ? $this->makePagination($this->collection)
            : '';
        $collection = $this->collection;

        return view( 'eloquent-lister::plain', compact( 'columns', 'collection', 'slug', 'pagination' ) );
    }


    /**
     * Returns the slug or attempts to guess based on the List class
     *
     * @return string
     */
    protected function getSlug()
    {
        if(!$this->getSetting('slug')) {
            $class_name = class_basename($this->list);
            $slug = str_plural(str_replace('list', '', strtolower($class_name)));
            return $slug;
        }

        return $this->getSetting('slug');
    }


    /**
     * Makes the paginator
     *
     * @param LengthAwarePaginator $paginator
     *
     * @return string
     * @internal param LengthAwarePaginator $collection
     */
    protected function makePagination(LengthAwarePaginator $paginator)
    {
        $query = $this->request->query;
        if($query->has('page')) $query->remove('page');
        return $paginator->appends($query->all())->render();
    }


    /**
     * Renders the view to a string
     *
     * @return string
     */
    public function render()
    {
        $view = $this->makeView();
        return $view->render();
    }


    /**
     * @return string
     */
    public function getCreateUrl()
    {
        return url("/{$this->getSlug()}/create");
    }


    /**
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }


    /**
     * Shortcut for getting settings
     *
     * @param $key
     * @return mixed
     */
    protected function getSetting($key, $default = null)
    {
        return array_get($this->settings, $key, $default);
    }
}
