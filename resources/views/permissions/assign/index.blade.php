@extends('layouts.app', ['title' => 'Role And Permissions'])

@section('content')
<!--begin::Content-->
<div class="content  d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Subheader-->
    <div class="subheader py-2 py-lg-12  subheader-transparent " id="kt_subheader">
        <div class=" container  d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <!--begin::Info-->
            <div class="d-flex align-items-center flex-wrap mr-1">

                <!--begin::Heading-->
                <div class="d-flex flex-column">
                    <!--begin::Title-->
                    <h2 class="text-white font-weight-bold my-2 mr-5">
                        Assign Permissions </h2>
                    <!--end::Title-->

                    <!--begin::Breadcrumb-->

                    <!--end::Breadcrumb-->
                </div>
                <!--end::Heading-->

            </div>
            <!--end::Info-->


        </div>
    </div>
    <!--end::Subheader-->

    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class=" container ">
            @if (session('status'))
            <div class="alert alert-custom alert-success fade show pb-2 pt-2" role="alert">
                <div class="alert-icon"><i class="flaticon-warning"></i></div>
                <div class="alert-text">{{ session('status') }}</div>
                <div class="alert-close">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true"><i class="ki ki-close"></i></span>
                    </button>
                </div>
            </div>

            @endif
            <div class="row">

                <div class="col-lg-12">
                    <!--begin::Card-->
                    <div class="card card-custom gutter-b example example-compact">
                        <div class="card-header">
                            <h3 class="card-title">
                                Assign Permissions
                            </h3>
                            <div class="card-toolbar">
                                <div class="example-tools justify-content-center">

                                </div>
                            </div>
                        </div>
                        <!--begin::Form-->
                        <div class="card-body">
                            <table class="table table-bordered yajra-datatable collapsed table-striped">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th style="width:20%">Action</th>
                                    </tr>
                                </thead>

                            </table>
                        </div>
                        <!--end::Form-->
                    </div>
                    <!--end::Card-->


                </div>
            </div>
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
</div>
<!--end::Content-->

@endsection
@push('script')
<script src="{{ asset('assets/js/pages/widgets.js?v=7.0.6"') }}"></script>
<script src="{{ asset('/assets/plugins/custom/datatables/datatables.bundle.js?v=7.0.6') }}"></script>

<script>
    $(function () {
          
          var table = $('.yajra-datatable').DataTable({
              responsive: true,
              processing: true,
              serverSide: true,
              ajax: "{{ route('assignpermission.index') }}",
              columns: [
                //   {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                  {data: 'name', name: 'name'},
                  {
                      data: 'action', 
                      render: function(data){
                          return htmlDecode(data);
                      },
                      className:"nowrap",
                  },
              ],
              columnDefs: [

                {
                    responsivePriority: 1,
                    targets: 0
                },
                {
                    responsivePriority: 2,
                    targets: -1
                },
            ],
        });
          
    });

    function htmlDecode(data){
        var txt = document.createElement('textarea');
        txt.innerHTML=data;
        return txt.value;
    }
</script>

@endpush