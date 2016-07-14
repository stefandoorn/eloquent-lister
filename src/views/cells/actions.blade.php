@if($btn_show)<a data-text="view" href="/{{ $slug }}/{{ $key }}"><i class="glyphicon glyphicon-search"></i></a> @endif
@if($btn_edit)<a data-text="edit" href="/{{ $slug }}/{{ $key }}/edit"><i class="glyphicon glyphicon-edit"></i></a> @endif
@if($btn_destroy)<a class="rest" data-method="DELETE" data-text="delete" href="/{{ $slug }}/{{ $key }}"><i class="glyphicon glyphicon-trash"></i></a>@endif
