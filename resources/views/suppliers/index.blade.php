@extends('layouts.base')

@section('title', 'Inventory: Data Supplier')

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
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-add-supplier">Tambah Data</button>
                </td>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                      <div class="row">
                        <div class="col-4">
                          <h3>Data Supplier</h3>
                        </div>
                        <div class="col-8">
                          @if (session('success-add-supplier'))
                          <div class="alert alert-success">{{ session('success-add-supplier') }}</div>
                          @endif

                          @if (session('success-update-supplier'))
                          <div class="alert alert-success">{{ session('success-update-supplier') }}</div>
                          @endif

                          @if (session('failed-add-supplier'))
                          <div class="alert alert-danger">{{ session('failed-add-supplier') }}</div>
                          @endif

                          @if (session('failed-update-supplier'))
                          <div class="alert alert-danger">{{ session('failed-update-supplier') }}</div>
                          @endif

                          @if (session('success-delete-supplier'))
                          <div class="alert alert-success">{{ session('success-delete-supplier') }}</div>
                          @endif

                          @if (session('failed-delete-supplier'))
                          <div class="alert alert-danger">{{ session('failed-delete-supplier') }}</div>
                          @endif

                          @if ($errors->any())
                          <div class="alert alert-warning">Please insert with valid value.</div>
                          @endif
                        </div>
                      </div>
                    </div>
                    <div class="card-body">
                        <table id="suppliers-table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID Supplier</th>
                                    <th>Supplier</th>
                                    <th>Alamat</th>
                                    <th>Tanggal Buat</th>
                                    <th>Tanggal Perbaharui</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-add-supplier">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Form: Tambah Data</h4>
            </div>
            <div class="modal-body">
              <form action="{{ route('suppliers.store') }}" method="POST" id="form-add-supplier">
                @csrf
                <div class="form-group">
                  <label for="supplier-add-name">Supplier</label>
                  <input type="text" class="form-control" name="supplier-add-name" value="{{ old('supplier-add-name') }}" id="supplier-add-name" maxlength="150" placeholder="Isi Supplier..." required>
                  <p class="text-danger">{{ $errors->first('supplier-add-name') }}</p>
                </div>
                <div class="form-group">
                  <label for="supplier-add-address">Alamat</label>
                  <textarea class="form-control" name="supplier-add-address" value="{{ old('supplier-add-address') }}" maxlength="200" placeholder="Isi alamat Supplier..." required></textarea>
                  <p class="text-danger">{{ $errors->first('supplier-add-address') }}</p>
                </div>
                <button type="submit" name="btn-add-supplier" id="btn-add-supplier" style="display: none;"></button>
              </form>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
              <button type="button" class="btn btn-primary" id="btn-submit-supplier">Tambah</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

      <div class="modal fade" id="modal-edit-supplier">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Form: Edit Data</h4>
            </div>
            <div class="modal-body">
              <form action="#" method="POST" id="form-update-supplier">
                @csrf
                @method('PUT')
                <div class="form-group">
                  <label for="supplier-add-name">Supplier</label>
                  <input type="text" class="form-control" name="supplier-edit-name" id="supplier-edit-name" maxlength="150" placeholder="Isi Supplier..." required>
                </div>
                <div class="form-group">
                  <label for="supplier-edit-address">Alamat</label>
                  <textarea class="form-control" name="supplier-edit-address" id="supplier-edit-address" maxlength="200" placeholder="Isi alamat Supplier..." required></textarea>
                </div>
                <button type="submit" name="btn-update-supplier" id="btn-update-supplier" style="display: none;"></button>
                <input type="number" name="supplier-edit-id" id="supplier-edit-id" style="display: none;" required>
              </form>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
              <button type="button" class="btn btn-primary" id="btn-edit-supplier">Update</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

      <div class="row" style="display: none;">
        <form action="#" method="POST" id="form-delete-supplier">
          @csrf
          @method('DELETE')
          <input type="number" name="supplier-delete-id" id="supplier-delete-id" required>
          <button type="submit" name="btn-delete-supplier" id="btn-delete-supplier"></button>
        </form>
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
      const editSupplier = function() {
        document.addEventListener('click', function(event) {
          event.preventDefault();
          if (event.target.classList.contains('edit-supplier')) {
            updateSupplier({supplierId: event.target.id});
          } else if (event.target.classList.contains('delete-supplier')) {
            deleteSupplier({supplierId: event.target.id, target: event.target});
          }
        });
      }

      const addSupplier = function() {
        document.querySelector('#btn-submit-supplier').addEventListener('click', function(event) {
          event.preventDefault();
          document.querySelector('#form-add-supplier').submit();
        });
      }

      const updateSupplier = function(object) {
        fetch(`http://127.0.0.1:8000/api/suppliers/${object.supplierId}`, {
          method: 'GET',
          headers: {
            'Accept': 'application/json',
              'Content-Type': 'application/json',
            }
          })
          .then(response => {
            if (response) {
              return response.json();
            }
          })
          .then(result => {
            if (result.statusCode === 200) {
              document.querySelector('#form-update-supplier').setAttribute('action', `http://127.0.0.1:8000/suppliers/${result.data.supplierId}`);
              document.querySelector('#supplier-edit-id').setAttribute('value', result.data.supplierId);
              document.querySelector('#supplier-edit-name').setAttribute('value', result.data.supplier);
              document.querySelector('#supplier-edit-address').value = result.data.address;
            }
          })
          .catch(errors => {
            console.log(errors);
          });
          document.querySelector('#btn-edit-supplier').addEventListener('click', function(event) {
            event.preventDefault();
            document.querySelector('#form-update-supplier').submit();
          });
      }

      const deleteSupplier = function(object) {
        Swal.fire({
          title: 'Anda yakin data ini mau dihapus?',
          showDenyButton: true,
          showCancelButton: false,
          confirmButtonText: 'Hapus',
          denyButtonText: 'Batal',
        })
        .then(result => {
          if (result.isConfirmed) {
            document.querySelector('#form-delete-supplier').setAttribute('action', `http://127.0.0.1:8000/suppliers/${object.supplierId}/delete`);
            document.querySelector('#supplier-delete-id').setAttribute('value', object.supplierId);
            document.querySelector('#form-delete-supplier').submit();
          }
        });
      }

        $(document).ready(function() {
            $('#suppliers-table').DataTable( {
              responsive: true,
              lengthChange: false,
              autoWidth: true,
              processing: true,
              serverSide: true,
              ajax: {
                  url: "{{ url('/api/server-side/suppliers') }}",
                  dataType: 'json',
                  type: 'POST',
                  data: { _token: `{{ csrf_token() }}`}
              },
              columns: [
                  { data: 'supplier_id' },
                  { data: 'supplier' },
                  { data: 'address' },
                  { data: 'created_at' },
                  { data: 'updated_at' },
                  { data: 'options' , orderable: false, searchable: false}
              ]
            }
          );

          addSupplier();
          editSupplier();
        });

    </script>
@endsection('scripts')
