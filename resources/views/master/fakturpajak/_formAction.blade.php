<div style="text-align:center;">
    <div class="d-flex flex-nowrap">
        @can('fakturpajak-edit')
        <a href="{{ $editUrl }}" class="btn btn-icon btn-warning btn-sm mr-1" title="EDIT"><i
                class="flaticon-edit"></i></a>
        @endcan

        @if ($status == 'Tidak Aktif')
        <a href="{{ route('fakturpajak.status', ['fakturpajak'=>$id]) }}" class="btn btn-icon btn-primary btn-sm mr-1" title="EDIT"><i
            class="flaticon2-check-mark "></i></a>    
        @endif

        

        &nbsp;
        @can('fakturpajak-delete')
        <a href="javascript:show_confirm({{ $id }})" class="btn btn-icon btn-danger btn-sm" title="DELETE"><i
                class="flaticon-delete"></i></a>
        @endcan
    </div>
</div>