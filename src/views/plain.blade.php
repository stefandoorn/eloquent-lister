@if(count($collection))
    <table class="table table-hover">
        <thead>
        <tr>
            @foreach($columns as $column)
                <th>{!! $column->makeHeader()->render() !!}</th>
            @endforeach
        </tr>
        </thead>
        <tbody>
        @foreach($collection as $model)
            <tr>
                @foreach($columns as $column)
                    <td>{!! $column->makeCell($model)->render() !!}</td>
                @endforeach
            </tr>
        @endforeach
        </tbody>
    </table>
    {!! $pagination !!}
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
@else
    <p>There are no items to display</p>
@endif