<div class="modal fade" id="caribarang" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Pesanan penjualan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body" style="height: 400px;">

                        <table class="table  yajra-datatable collapsed ">
                            <thead class="datatable-head">
                                <tr>
                                    <th>Kode</th>
                                    <th>Nama Barang</th>
                                    <th>Katalog</th>
                                    <th>Stok</th>
                                    <th>Satuan</th>
                                    <th>Qty Pesanan</th>
                                    <th>Qty Sisa</th>
                                    <th>Sudah dipilih ?</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach($dataSO as $item)
                                <tr>
                                    <td>{{ $item['kode'] }}</td>
                                    <td>{{ $item['nama'] }}</td>
                                    <td>{{ $item['katalog'] }}</td>
                                    <td>{{ $item['stok'] }}</td>
                                    <td>{{ $item['satuan'] }}</td>
                                    <td>{{ $item['qty']}}</td>
                                    <td>{{ $item['qty_sisa'] }}</td>
                                    <td>
                                        @if ($item['status'] == 'belum')
                                            <span class="badge badge-primary">Belum</span>
                                        @else
                                            <span class="badge badge-warning">Sudah</span>
                                        @endif
                                    </td>
                                    <td>   
                                        @if ($item['stok'] == 0)
                                        <span class="badge badge-warning">Stok Habis</span>                                        
                                        @elseif ($item['qty_sisa'] > 0)
                                            <a href="javascript:pilihBarang({{ $item['id']}})"
                                            class="btn btn-light-success btn-sm font-weight-bold ">Pilih</a>                                                                                   
                                        @endif
                                       
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-primary font-weight-bold"
                            data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>