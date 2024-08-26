@extends(config('schoolviser.admin_layout'))

@section('module-page-heading', 'Update Term Details')

@section('pageheaderDescription', 'Configure your terms')

@section('module-links')
@endsection

@section('content')

<div class="row">
 @include('admin.includes.alerts.updated')
</div>

<form action="{{ route('settings.terms.update', ['id' => $term->id]) }}" method="POST" class="row">
 @csrf

 <div class="col-lg-4 mb-3">
  <label for="" class="">Year</label>
  <select name="year" id="" class="form-control">
    @foreach ($years as $year)
        <option value="{{ $year->id }}" {{ ($term->academic_year_id == $year->id) ? 'selected' : '' }}>{{ $year->name }}</option>
    @endforeach
  </select>
</div>

 <div class="col-lg-4 mb-3">
   <label for="" class="">Term</label>
   <select name="term" id="" class="form-control text-danger rounded-0">
     <option value="1" {{ ($term->term == 1) ? 'selected' : '' }}>Term One</option>
     <option value="2" {{ ($term->term == 2) ? 'selected' : '' }}>Term Two</option>
     <option value="3" {{ ($term->term == 3) ? 'selected' : '' }}>Term Three</option>
   </select>
 </div>

 <div class="col-lg-4 mb-3">
  <label for="start_date">Start Date</label>
  <input type="date" name="start_date" class="form-control" value="{{ old('start_date') ?? $term->start_date }}" >
 </div>

 <div class="col-lg-4 mb-3">
  <label for="start_date">End Date</label>
  <input type="date" name="end_date" class="form-control" value="{{ old('end_date') ?? $term->end_date }}" >
 </div>

 <div class="col-lg-12 my-5">
  <button type="submit" class="btn btn-md btn-primary w-100 rounded-5">Update</button>
 </div>
</form>

@endsection
