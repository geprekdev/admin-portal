@extends('layouts.main')

@section('title')
  <title>Rekap Kehadiran Kelas Siswa | Siamawolu Admin</title>
@endsection

@section('css')
  <link rel="stylesheet" href="{{ asset('assets/css/select2/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/datatables/dataTables.bootstrap4.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/datatables/responsive.bootstrap4.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/datatables/buttons.bootstrap4.min.css') }}" />
@endsection

@section('header')
  <h1 class="m-0">Rekap Kehadiran Kelas Siswa</h1>
@endsection

@section('content')
  <div class="col-12">
    <div class="card">
      {{-- <div class="card-tools d-flex flex-column flex-md-row justify-content-end mt-3 mx-4">
        <form class="d-flex flex-column flex-md-row" action="{{ route('recaps.classroom-attendance') }}" method="get">

          <button type="submit" class="btn btn-outline-secondary mt-3 mt-md-0" style="height: fit-content;">
            Filter
          </button>
        </form>
      </div> --}}

      <div class="card-body">
        <table id="classroom-attendances-table" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>#</th>
              <th>Nama</th>
              <th>Status</th>
              <th>Kelas</th>
              <th>Mapel</th>
              <th>Mulai</th>
              <th>Selesai</th>
              <th>Tanggal</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($attendances as $attendance)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $attendance->first_name }}</td>
                <td>
                  <span
                    class="badge 
                    @switch($attendance->status)
                      @case('ALPHA')
                        {{ 'badge-danger' }}
                        @break
                      @case('HADIR')
                        {{ 'badge-success' }}
                        @break
                      @case('IJIN')
                        {{ 'badge-warning' }}
                        @break
                      @case('SAKIT')
                        {{ 'badge-info' }}
                        @break    
                    @endswitch">
                    {{ $attendance->status }}
                  </span>
                </td>
                <td>{{ $attendance->classroom }}</td>
                <td>{{ $attendance->subject }}</td>
                <td>{{ Carbon\Carbon::parse($attendance->start_time)->format('H:i:s') }}</td>
                <td>{{ Carbon\Carbon::parse($attendance->end_time)->format('H:i:s') }}</td>
                <td>{{ Carbon\Carbon::parse($attendance->date)->format('d F Y') }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>

        <div class="mt-3 mx-3">
          {{ $attendances->links() }}
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

      $("#classroom-attendances-table")
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
        .appendTo("#classroom-attendances-table_wrapper .col-md-6:eq(0)");
    });
  </script>
@endsection
