 <!-- Modal -->
 <div class="modal fade" id="status" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
     aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalCenterTitle">Status</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <div class="modal-body">
                 <form action="{{ route('absensi.inputstatus') }}" method="POST" enctype="multipart/form-data">
                     @csrf
                     <div class="form-group">
                         <label for="">Status</label>
                         <select name="status" class="form-control"  id="status">
                             <option value="{{ $absensi->status }}" selected>{{ $absensi->status }}</option>
                             <option value="ijin">Ijin</option>
                             <option value="tidak hadir">Tidak Hadir</option>
                             <option value="terlambat">Terlambat</option>
                             <option value="ontime">Ontime</option>
                         </select>
                     </div>

                    <input type="hidden" id="id_status" value="{{$absensi->id}}">
             </div>
             <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="button" onclick="javascript:submitItem();" class="btn btn-success mr-2">Submit</button>
             </div>
             </form>
         </div>
     </div>
 </div>
