<?php namespace NielsFilmer\EloquentLister\Headers;


use Illuminate\Http\Request;

class Orderable extends BaseHeader {

    protected static $view = 'eloquent-lister::headers.orderable';
    protected static $query_setting = 'eloquent-lister.order_query';


    /**
     * @return \Illuminate\View\View
     */
    public function makeCell()
    {
        $url = $this->makeOrderableLink($this->request, $this->attribute);
        $order = $this->currentOrder($this->request, $this->attribute);
        $display = $this->display;

        return view(static::$view, compact('url', 'display', 'order'));
    }


    /**
     * Makes the url for ordering by this attribute
     *
     * @param Request $request
     * @return string
     */
    protected function makeOrderableLink(Request $request, $attribute)
    {
        $new_query = [];
        $order_set = false;
        $order_query = config(static::$query_setting);

        foreach($request->query as $key=>$value) {
            if($key == $order_query) {
                $order = explode('|', $value);
                if($order[0] == $attribute && isset($order[1]) && $order[1] == 'asc') {
                    $new_query[] = "{$key}={$attribute}|desc";
                } else {
                    $new_query[] = "{$key}={$attribute}|asc";
                }
                $order_set = true;
            } else {
                if(is_array($value)) {
                    foreach($value as $k=>$v) {
                        $new_query[] = "{$key}[{$k}]={$v}";
                    }
                } else {
                    $new_query[] = "{$key}={$value}";
                }
            }
        }

        if(!$order_set) {
            $new_query[] = "{$order_query}={$attribute}|asc";
        }

        $new_query = implode('&', $new_query);
        return url($request->decodedPath() . "?{$new_query}");
    }


    /**
     * Reads the current order from the Request
     *
     * @param Request $request
     * @param $attribute
     * @return string|null
     */
    protected function currentOrder(Request $request, $attribute)
    {
        $order_query = config(static::$query_setting);

        foreach($request->query as $key=>$value) {
            if($key == $order_query) {
                $order = explode('|', $value);
                if($order[0] == $attribute && isset($order[1])) {
                    return $order[1];
                }
            }
        }

        return null;
    }
}