@extends(config('student.layout', 'student::layouts.master'))


@section('module-page-heading', 'Dashboard')
@section('pageheaderDescription', 'Manage Students')



@section('requiredCss')
<style>
  .table-responsive {
    overflow-x: auto !important;
  }
</style>
@endsection

@section('requiredJs')
<script src="{{ asset('chart.js/Chart.min.js') }}" defer></script>
<script>
  var studentsPerCourseChartLabels = @json(array_keys($studentsPerCourse));
  var studentsPerCourseChartData = @json(array_values($studentsPerCourse));
</script>
<script src="{{ asset('js/dashboard.js') }}" defer></script>
@endsection


@section('content')

<div class="row mb-5">

 <div class="col-lg-6">

  <div class="row">
    <div class="col-lg-4 p-0">
      <div class="bg-light rounded-2 px-2 mx-1">
       <small class="text-muted">Total</small>
       <h2 class="">{{ $registrations->total }}</h2>
      </div>
     </div>
    
     <div class="col-lg-4 px-1">
      <div class="bg-light rounded-2 px-2">
       <small class="text-muted">Female</small>
      <h2>{{ $registrations->female }}</h2>
      </div>
     </div>
    
     <div class="col-lg-4 p-0">
      <div class="bg-light rounded-2 px-2 mx-1">
       <small class="text-muted">Male</small>
       <h2>{{ $registrations->male }}</h2>
      </div>
     </div>
  </div>

  <div class="row">
    <div class="col-lg-12 rounded-2 py-4"><canvas id="studentsPerCourseChart" height="200px"></canvas></div>
  </div>

 </div>


 <!-- Col 2 -->
 <div class="col-lg-6">

  <div class="row">
  </div>

 </div>

</div>


<div class="row mb-5">
 <div class="col-lg-6 rounded-2 py-4 d-none"><canvas id="studentsPerYearGroupChart" height="200px"></canvas></div>
</div>

<div class="row mb-5">
 <div class="col-lg-6 rounded-2 py-4"><canvas id="studentsPerSemesterChart" height="200px"></canvas></div>
 <div class="col-lg-6 rounded-2 py-4"><canvas id="studentsPerAcademicYearChart" height="200px"></canvas></div>
</div>



@endsection
