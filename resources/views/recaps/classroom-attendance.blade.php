@extends('layouts.main')

@section('title')
  <title>Rekap Kehadiran Kelas {{ isset($class) && isset($date) ? "{$class} - {$date}" : 'Siswa' }} | Siamawolu Admin
  </title>
@endsection

@section('css')
  <link rel="stylesheet" href="{{ asset('assets/css/select2/select2.min.css') }}">
@endsection

@section('header')
  <h1 class="m-0">Rekap Kehadiran Kelas {{ $class ?? 'Siswa' }}</h1>
@endsection

@section('content')
  <div class="container">
    <div class="card">
      <div class="card-tools d-flex flex-column flex-md-row justify-content-end mt-3 mx-4">
        <form class="d-flex flex-column flex-md-row" action="{{ route('recaps.classroom-attendance') }}" method="get">
          <div class="form-group mr-0 mr-md-3 mt-3 mt-md-0">
            <select class="form-control select2" name="classroom" style="width: 100%;">
              <option disabled
                {{ request()->query('classroom') === '' || request()->query('classroom') === null ? 'selected' : '' }}>--
                Pilih Kelas --</option>
              @foreach ($classrooms as $classroom)
                <option value="{{ $classroom->grade }}"
                  {{ request()->query('classroom') == $classroom->grade ? 'selected' : '' }}>{{ $classroom->grade }}
                </option>
              @endforeach
            </select>
          </div>

          <div class="form-group mr-0 mr-md-3 mt-3 mt-md-0">
            <input class="form-control" type="date" name="date"
              value="{{ request()->query('date') ?? today()->format('Y-m-d') }}">
          </div>

          <button type="submit" class="btn btn-outline-secondary mt-3 mt-md-0" style="height: fit-content;">
            Filter
          </button>
        </form>
      </div>

      @if (isset($attendances))
        <div class="card-body">
          @foreach ($attendances as $subject => $times)
            <h4>{{ $subject }}</h4>
            <div class="row">
              @foreach ($times as $time => $absences)
                <div class="col-md-6">
                  <h5>
                    {{ Carbon\Carbon::parse($time)->format('H:i') . ' - ' . Carbon\Carbon::parse($absences[0]->end_time)->format('H:i') }}
                  </h5>
                  <table class="table table-bordered table-striped mb-5">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($absences as $absence)
                        <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ $absence->first_name }}</td>
                          <td>
                            <span
                              class="badge 
                              @switch($absence->status)
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
                              {{ $absence->status }}
                            </span>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              @endforeach
            </div>
          @endforeach
        </div>
      @else
        <div class="card-body text-center">
          <h3>Silahkan pilih kelas dan tanggal terlebih dahulu.</h3>
        </div>
      @endif
    </div>
  </div>
@endsection

@section('js')
  <script src="{{ asset('assets/js/select2/select2.full.min.js') }}"></script>

  <script>
    $(document).ready(function() {
      $(".select2").select2();
    });
  </script>
@endsection
