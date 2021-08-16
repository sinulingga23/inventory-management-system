@extends('layouts.base')

@section('title', 'Inventory: Data Kategori')


@section('css-scripts')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('AdminLTE-3.1.0/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('AdminLTE-3.1.0/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('AdminLTE-3.1.0/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('AdminLTE-3.1.0/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('AdminLTE-3.1.0/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('AdminLTE-3.1.0/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
@endsection

@section('container')
  <div class="container-fluid">
    <div class="row">
      <div class="col-3">
        <td>
          <button type="button" class="btn btn-primary btn-sm">Tambah Data</button>
        </td>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <div class="row">
              <div class="col-4">
                <h3>Data Kategori</h3>
              </div>
              <div class="col-8">

              </div>
            </div>
          </div>
          <div class="card-body">
            <table id="categories-table" class="table-bordered table-striped">
              <thead>
                <th>ID Kategori</th>
                  <th>Kode</th>
                  <th>Kategori</th>
                  <th>Tanggal Dibuat</th>
                  <th>Tanggal Diperbaharui</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tr>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('plugins-scripts')
  <!-- DataTables  & Plugins -->
  <script src="{{ asset('AdminLTE-3.1.0/plugins/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('AdminLTE-3.1.0/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('AdminLTE-3.1.0/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
  <script src="{{ asset('AdminLTE-3.1.0/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('AdminLTE-3.1.0/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
  <script src="{{ asset('AdminLTE-3.1.0/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('AdminLTE-3.1.0/plugins/jszip/jszip.min.js') }}"></script>
  <script src="{{ asset('AdminLTE-3.1.0/plugins/pdfmake/pdfmake.min.js') }}"></script>
  <script src="{{ asset('AdminLTE-3.1.0/plugins/pdfmake/vfs_fonts.js') }}"></script>
  <script src="{{ asset('AdminLTE-3.1.0/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
  <script src="{{ asset('AdminLTE-3.1.0/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
  <script src="{{ asset('AdminLTE-3.1.0/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

  <!-- SweetAlert2 -->
  <script src="{{ asset('AdminLTE-3.1.0/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
@endsection

@section('scripts')
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      $('#categories-table').DataTable({
        responsive: true,
        lengthChange: false,
        autoWidth: true,
        processing: true,
        serverSide: true,
        ajax: {
          url: "{{ url('/api/server-side/categories') }}",
          dataType: 'json',
          type: 'POST',
          data: { _token: `{{ csrf_token() }}`},
        },
        columns: [
          { data: 'category_id' },
          { data: 'code' },
          { data: 'category' },
          { data: 'created_at' },
          { data: 'updated_at' },
          { data: 'options', orderable: false, searchable: false, }
        ],
      });
    });
  </script>
@endsection
