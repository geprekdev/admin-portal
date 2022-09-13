@extends('layouts.main')

@section('title')
  <title>Rekap Izin Guru | Siamawolu Admin</title>
@endsection

@section('css')
  <link rel="stylesheet" href="{{ asset('assets/css/select2/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/datatables/dataTables.bootstrap4.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/datatables/responsive.bootstrap4.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/datatables/buttons.bootstrap4.min.css') }}" />
@endsection

@section('header')
  <h1 class="m-0">Rekap Izin Guru</h1>
@endsection

@section('content')
  <div class="col-12">
    <div class="card">
      {{-- <div class="card-tools d-flex flex-column flex-md-row justify-content-end mt-3 mx-4">
        <form class="d-flex flex-column flex-md-row" action="{{ route('recaps.leave') }}" method="get">

          <button type="submit" class="btn btn-outline-secondary mt-3 mt-md-0" style="height: fit-content;">
            Filter
          </button>
        </form>
      </div> --}}

      <div class="card-body">
        @if (session()->has('success'))
          <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-check"></i> Success!</h5>
            {{ session()->get('success') }}
          </div>
        @endif
        <table id="leave-table" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>#</th>
              <th>Nama</th>
              <th>Jenis</th>
              <th>Kategori</th>
              <th>Status</th>
              <th>Alasan</th>
              <th>Lampiran</th>
              <th>Tanggal</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($leaves as $leave)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $leave->first_name }}</td>
                <td>
                  <span
                    class="badge 
                    @switch($leave->leave_mode)
                      @case(0)
                        @php
                          $mode = 'Full Day';
                        @endphp
                        {{ 'badge-info' }}
                        @break
                      @case(1)
                        @php
                          $mode = 'Half Day';
                        @endphp
                        {{ 'badge-success' }}
                        @break
                    @endswitch">
                    {{ $mode }}
                  </span>
                </td>
                <td>
                  <span
                    class="badge 
                    @switch($leave->leave_type)
                      @case(0)
                        @php
                          $type = 'Izin';
                        @endphp
                        {{ 'badge-warning' }}
                        @break
                      @case(1)
                        @php
                          $type = 'Sakit';
                        @endphp
                        {{ 'badge-info' }}
                        @break
                      @case(2)
                        @php
                          $type = 'Keperluan Sekolah';
                        @endphp
                        {{ 'badge-dark' }}
                      @break
                    @endswitch">
                    {{ $type }}
                  </span>
                </td>
                <td>
                  <span
                    class="badge 
                    @if ($leave->approve === 1) 
                      @php
                        $approve = 'Diterima';
                      @endphp
                      {{ 'badge-success' }}
                    @elseif ($leave->approve === 0)
                      @php
                        $approve = 'Ditolak';
                      @endphp
                      {{ 'badge-danger' }}
                    @else 
                      @php
                        $approve = 'Menunggu konfirmasi';
                      @endphp
                      {{ 'badge-warning' }} 
                    @endif">
                    {{ $approve }}
                  </span>
                </td>
                <td>{{ $leave->reason }}</td>
                <td>
                  @if ($leave->attachment !== '')
                    <a target="_blank" href="https://api.erpeelisme.my.id/m/{{ $leave->attachment }}"
                      class="btn btn-outline-dark">
                      Buka Lampiran
                    </a>
                  @else
                    {{ 'Tidak ada lampiran' }}
                  @endif
                </td>
                <td>{{ Carbon\Carbon::parse($leave->created_at)->format('d F Y H:i:s') }}</td>
                <td class="dropdown">
                  <a class="btn dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
                  <div class="dropdown-menu">
                    <form action="{{ route('recaps.leave.accept', ['leave' => $leave->id]) }}" method="post">
                      @csrf
                      @method('PUT')
                      <button type="submit" class="dropdown-item" tabindex="-1">
                        <i class="fas fa-check"></i>&nbsp; Terima
                      </button>
                    </form>

                    <div class="dropdown-divider"></div>

                    <form action="{{ route('recaps.leave.decline', ['leave' => $leave->id]) }}" method="post">
                      @csrf
                      @method('PUT')
                      <button type="submit" class="dropdown-item" tabindex="-1">
                        <i class="fas fa-times"></i>&nbsp; Tolak
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>

        <div class="mt-3 mx-3">
          {{ $leaves->links() }}
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

      $("#leave-table")
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
        .appendTo("#leave-table_wrapper .col-md-6:eq(0)");
    });
  </script>
@endsection
