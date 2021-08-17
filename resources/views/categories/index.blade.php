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
          <button type="button" class="btn btn-primary btn-sm"  data-toggle="modal" data-target="#modal-add-category">Tambah Data</button>
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
                @if (session('success-add-category'))
                <div class="alert alert-success">{{ session('success-add-category') }}</div>
                @endif

                @if (session('failed-add-category'))
                <div class="alert alert-danger">{{ session('failed-add-category') }}</div>
                @endif

                @if (session('success-update-category'))
                <div class="alert alert-success">{{ session('success-update-category') }}</div>
                @endif

                @if (session('failed-update-category'))
                <div class="alert alert-danger">{{ session('success-update-caetegory') }}</div>
                @endif

                @if (session('success-delete-category'))
                <div class="alert alert-success">{{ session('success-delete-category') }}</div>
                @endif

                @if (session('failed-delete-category'))
                <div class="alert alert-danger">{{ session('success-delete-caetegory') }}</div>
                @endif

                @if ($errors->any())
                  <div class="alert alert-warning">Please insert with valid value.</div>
                @endif
              </div>
            </div>
          </div>
          <div class="card-body">
            <table id="categories-table" class="table table-bordered table-striped">
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

  <div class="modal fade" id="modal-add-category">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modeal-header">
          <h4 class="modal-title">Form: Tambah Data</h4>
        </div>
        <div class="modal-body">
          <form action="{{ route('categories.store') }}" method="POST">
            @csrf
            <div class="form-group">
              <label for="category-add-code">Kode Kategori</label>
              <input type="text" class="form-control" name="category-add-code" value="{{ old('category-add-code') }}" id="category-add-code" maxlength="150" placeholder="Isi Kode..." required>
              <p class="text text-danger">{{ $errors->first('category-add-code') }}</p>
              <p class="text text-danger" id="category-code-exists" style="display: none;">Kode Kategori telah digunakan.</p>
            </div>
            <div class="form-group">
              <label for="category-add-name">Kategori</label>
              <input type="text" class="form-control" name="category-add-name" value="{{ old('category-add-name') }}" id="category-add-name" maxlength="150" placeholder="Isi Category..." required>
              <p class="text text-danger">{{ $errors->first('category-add-name') }}</p>
            </div>
            <div class="form-group">
              <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-primary">Tambah</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modal-update-category">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modeal-header">
          <h4 class="modal-title">Form: Edit Data</h4>
        </div>
        <div class="modal-body">
          <form action="#" method="POST" id="form-update-category">
            @csrf
            @method('PUT')
            <div class="form-group">
              <label for="category-update-code">Kode Kategori</label>
              <input type="text" class="form-control" name="category-update-code" value="{{ old('category-update-code') }}" id="category-update-code" maxlength="150" placeholder="Isi Kode..."  readonly required>
              <p class="text text-danger">{{ $errors->first('category-update-code') }}</p>
              <p class="text text-danger" id="category-code-exists" style="display: none;">Kode Kategori telah digunakan.</p>
            </div>
            <div class="form-group">
              <label for="category-update-name">Kategori</label>
              <input type="text" class="form-control" name="category-update-name" value="{{ old('category-update-name') }}" id="category-update-name" maxlength="150" placeholder="Isi Category..." required>
              <p class="text text-danger">{{ $errors->first('category-update-name') }}</p>
            </div>
            <input type="number" name="category-update-id" id="category-update-id" style="display: none;" required>
            <div class="form-group">
              <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-primary" id="btn-update-category">Update</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="row" style="display: none;">
    <form action="#" method="POST" id="form-delete-category">
      @csrf
      @method('DELETE')
      <input type="number" name="category-delete-id" id="category-delete-id" required>
      <button type="submit" name="btn-delete-category" id="btn-delete-category"></button>
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
    const validateFormaAddCategory = function() {
      document.querySelector('#category-add-code').addEventListener('change', function(event) {
        fetch(`http://127.0.0.1:8000/api/suppliers/${event.target.value}/code-check`, {
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
          if (result.isExists) {
            document.querySelector('#category-code-exists').style.display = 'block';
          } else {
            document.querySelector('#category-code-exists').style.display = 'none';
          }
        });
      });
    }

    const listenOptions = function() {
      document.addEventListener('click', function(event) {
        event.preventDefault();
        if (event.target.classList.contains('edit-category')) {
          fetch(`http://127.0.0.1:8000/api/categories/${event.target.id}`, {
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
            if (result.statusCode == 200) {
              document.querySelector('#form-update-category').setAttribute('action', `http://127.0.0.1:8000/categories/${event.target.id}`);
              document.querySelector('#category-update-code').setAttribute('value', result.data.code);
              document.querySelector('#category-update-name').setAttribute('value', result.data.category);
              document.querySelector('#category-update-id').setAttribute('value', result.data.categoryId);
            }
          })
          .catch(err => {
          })
        } else if (event.target.id === "btn-update-category") {
          document.querySelector('#form-update-category').submit();
        } else if (event.target.classList.contains('delete-category')) {
          Swal.fire({
            title: 'Anda yakin data ini mau dihapus?',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: 'Hapus',
            denyButtonText: 'Batal',
          })
          .then(result => {
            if (result.isConfirmed) {
              document.querySelector('#form-delete-category').setAttribute('action', `http://127.0.0.1:8000/categories/${event.target.id}/delete`);
              document.querySelector('#category-delete-id').setAttribute('value', event.target.id);
              document.querySelector('#form-delete-category').submit();
            }
          })
        }
      });
    }

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

      validateFormaAddCategory();
      listenOptions();
    });
  </script>
@endsection
