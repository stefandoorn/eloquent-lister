<a href="{{ $url }}" class="lister-order-link" data-order="{{ $order }}">
    {{ $display }}
    @if($order)
        @if($order == 'asc')
            <span class="glyphicon glyphicon-triangle-bottom"></span>
        @else
            <span class="glyphicon glyphicon-triangle-top"></span>
        @endif
    @endif
</a>