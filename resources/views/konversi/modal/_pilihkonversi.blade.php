<div style="text-align:center;">
    <div class="d-flex flex-nowrap">
        @can('konversisatuan-create')
        <a href="javascript:pilihBarang({{ $id }}) " class="btn btn-success btn-sm">
            <i class="flaticon2-check-mark text-small "></i> Pilih
        </a>
        @endcan
    </div>
</div>