@extends('layouts.main')

@section('title')
  <title>Rekap Jurnal Guru | Siamawolu Admin</title>
@endsection

@section('css')
  <link rel="stylesheet" href="{{ asset('assets/css/select2/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/datatables/dataTables.bootstrap4.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/datatables/responsive.bootstrap4.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/datatables/buttons.bootstrap4.min.css') }}" />
@endsection

@section('header')
  <h1 class="m-0">Rekap Jurnal Guru</h1>
@endsection

@section('content')
  <div class="col-12">
    <div class="card">
      {{-- <div class="card-tools d-flex flex-column flex-md-row justify-content-end mt-3 mx-4">
        <form class="d-flex flex-column flex-md-row" action="{{ route('recaps.journal') }}" method="get">

          <button type="submit" class="btn btn-outline-secondary mt-3 mt-md-0" style="height: fit-content;">
            Filter
          </button>
        </form>
      </div> --}}

      <div class="card-body">
        <table id="journal-table" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>#</th>
              <th>Nama</th>
              <th>Kelas</th>
              <th>Mapel</th>
              <th>Deskripsi</th>
              <th>Tanggal</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($journals as $journal)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $journal->first_name }}</td>
                <td>{{ $journal->classroom }}</td>
                <td>{{ $journal->subject }}</td>
                <td>{{ $journal->description }}</td>
                <td>{{ Carbon\Carbon::parse($journal->date)->format('d F Y') }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>

        <div class="mt-3 mx-3">
          {{ $journals->links() }}
        </div>
      </div>
    </div>
  </div>
@endsection

@section('js')
  <script src="{{ asset('assets/js/select2/select2.full.min.js') }}"></script>
  <script src="{{ asset('assets/js/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('assets/js/datatables/dataTables.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('assets/js/datatables/dataTables.responsive.min.js') }}"></script>
  <script src="{{ asset('assets/js/datatables/responsive.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('assets/js/datatables/dataTables.buttons.min.js') }}"></script>
  <script src="{{ asset('assets/js/datatables/buttons.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('assets/js/datatables/jszip.min.js') }}"></script>
  <script src="{{ asset('assets/js/datatables/pdfmake.min.js') }}"></script>
  <script src="{{ asset('assets/js/datatables/vfs_fonts.js') }}"></script>
  <script src="{{ asset('assets/js/datatables/buttons.html5.min.js') }}"></script>
  <script src="{{ asset('assets/js/datatables/buttons.print.min.js') }}"></script>

  <script>
    $(document).ready(function() {
      $(".select2").select2();

      $("#journal-table")
        .DataTable({
          searching: false,
          responsive: true,
          autoWidth: false,
          info: false,
          paging: false,
          buttons: ["excel", "pdf", "print"],
        })
        .buttons()
        .container()
        .appendTo("#journal-table_wrapper .col-md-6:eq(0)");
    });
  </script>
@endsection
