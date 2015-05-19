@if($btn_show)<a data-text="view" href="/{{ $slug }}/{{ $key }}"><i class="fa fa-search"></i></a> @endif
@if($btn_edit)<a data-text="edit" href="/{{ $slug }}/{{ $key }}/edit"><i class="fa fa-edit"></i></a> @endif
@if($btn_destroy)<a class="rest" data-method="DELETE" data-text="delete" href="/{{ $slug }}/{{ $key }}"><i class="fa fa-trash"></i></a>@endif
