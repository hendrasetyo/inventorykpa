<div style="text-align:center;">

    @can('navigation-edit')
    <a href="{{ $editUrl }}" class="btn btn-icon btn-warning btn-sm mr-2" title="EDIT"><i class="flaticon-edit"></i></a>
    @endcan
    &nbsp;
    @can('navigation-delete')
    <a href="javascript:show_confirm({{ $id }})" class="btn btn-icon btn-danger btn-sm" title="DELETE"><i
            class="flaticon-delete"></i></a>
    @endcan
</div>