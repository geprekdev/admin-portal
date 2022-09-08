@extends('layouts.main')

@section('title')
  <title>Rekap Kehadiran Sekolah Guru/Karyawan | Siamawolu Admin</title>
@endsection

@section('css')
  <link rel="stylesheet" href="{{ asset('assets/css/select2/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/datatables/dataTables.bootstrap4.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/datatables/responsive.bootstrap4.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/datatables/buttons.bootstrap4.min.css') }}" />
@endsection

@section('header')
  <h1 class="m-0">Rekap Kehadiran Sekolah Guru/Karyawan</h1>
@endsection

@section('content')
  <div class="col-12">
    <div class="card">
      {{-- <div class="card-tools d-flex flex-column flex-md-row justify-content-end mt-3 mx-4">
        <form class="d-flex flex-column flex-md-row" action="{{ route('recaps.non-student-attendance') }}" method="get">

          <button type="submit" class="btn btn-outline-secondary mt-3 mt-md-0" style="height: fit-content;">
            Submit
          </button>
        </form>
      </div> --}}

      <div class="card-body">
        <table id="non-student-attendances-table" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>#</th>
              <th>Nama</th>
              <th>Role</th>
              <th>Status</th>
              <th>Tanggal</th>
              <th>Masuk</th>
              <th>Keluar</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($attendances as $attendance)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $attendance->first_name }}</td>
                <td>
                  <span
                    class="badge @if ($attendance->role === 'GRU') {{ 'badge-info' }} @elseif ($attendance->role === 'KWN') {{ 'badge-dark' }} @endif">
                    @if ($attendance->role === 'GRU')
                      {{ 'GURU' }}
                    @elseif ($attendance->role === 'KWN')
                      {{ 'KARYAWAN' }}
                    @endif
                  </span>
                </td>
                <td>
                  <span
                    class="badge @if ($attendance->status === 'H') {{ 'badge-success' }} @elseif ($attendance->status === 'T') {{ 'badge-warning' }} @endif">
                    @if ($attendance->status === 'H')
                      {{ 'Hadir' }}
                    @elseif ($attendance->status === 'T')
                      {{ 'Terlambat' }}
                    @endif
                  </span>
                </td>
                <td>{{ Carbon\Carbon::parse($attendance->date)->format('d F Y') }}</td>
                <td>{{ Carbon\Carbon::parse($attendance->clock_in)->format('H:i:s') }}</td>
                <td>
                  {{ $attendance->clock_out !== null ? Carbon\Carbon::parse($attendance->clock_out)->format('H:i:s') : '' }}
                </td>
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

      $("#non-student-attendances-table")
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
        .appendTo("#non-student-attendances-table_wrapper .col-md-6:eq(0)");
    });
  </script>
@endsection
