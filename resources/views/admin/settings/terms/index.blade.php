@extends(config('schoolviser.admin_layout'))

@section('module-page-heading', (config('schoolviser.type','') == 'primary' || config('schoolviser.type','') == 'secondary') ? 'Terms' : 'Semesters')

@section('module-page-description', 'Configure your terms')

@section('module-links')
<a href="{{route('settings')}}">Back To Settings</a>
<a href="">Set Academic Year</a>
@endsection

@section('content')

<div class="row mt-3">
  
@if (count($terms))
<div class="col-lg-12">
  <div class="row">
    <div class="col-12">
      <div class="table">
        <table class="table table-hover table-bordered table-striped bg-primary" id="studentsTables">
          <thead class="">
            <th class="">SN</th>
              <th>Year</th>
              <th>Term</th>
              <th>Start Date</th>
              <th>End Date</th>
              <th>Next Term</th>
              <th class="text-center">Actions</th>
          </thead>
          <tbody>
              @foreach ($terms as $term)
                @if (term()->term == $term->term && term()->year == $term->year)
                <tr class="bg-primary">
                  <td>{{ $loop->index + 1 }}</td>
                  <td><small class="text-capitalize bg-warning px-2 py-1 rounded-5 font-12 fst-italic fw-bold">{{ $term->year }}</small></td>
                  <td><small class="text-capitalize bg-warning px-2 py-1 rounded-5 font-12 fst-italic fw-bold">{{ $term->term }}</small></td>
                  <td><small class="text-capitalize bg-warning px-2 py-1 rounded-5 font-12 fst-italic fw-bold">{{ $term->start_date }}</small></td>
                  <td><small class="text-capitalize bg-warning px-2 py-1 rounded-5 font-12 fst-italic fw-bold">{{ $term->end_date }}</small></td>
                  <td><small class="text-capitalize bg-warning px-2 py-1 rounded-5 font-12 fst-italic fw-bold">{{ $term->next_term_start_date }}</small></td>
                  <td><a href="{{route('settings.terms.show', ['id' => $term->id])}}"><i class="fa fa-edit"></i></a></td>
                  <td>
                  </td>
    
                </tr>
                @else
                <tr class="">
                  <td>{{ $loop->index + 1 }}</td>
                  <td><small class="text-capitalize">{{ $term->year }}</small></td>
                  <td><small class="text-capitalize ">{{ $term->term }}</small></td>
                  <td><small class="text-capitalize">{{ $term->start_date }}</small></td>
                  <td><small class="text-capitalize">{{ $term->end_date }}</small></td>
                  <td><small class="text-capitalize">{{ $term->next_term_start_date }}</small></td>
                </tr>
                @endif
               
              @endforeach
          </tbody>
        </table>
      </div>
    </div>
    <div class="col-lg-12 my-2">
      {{ $terms->links() }}
    </div>
  </div>
</div>


@else

@endif

<div class="col-lg-6">
  <form class="card-body row" action="{{ route('settings.terms.store') }}" method="POST">
    @csrf
    <div class="col-lg-6">
      <label for="" class="font-10 text-muted">Year</label>
      <select name="year" id="" class="form-control">
        @foreach ($years as $year)
            <option value="{{ $year->id }}">{{ $year->name }}</option>
        @endforeach
      </select>
    </div>
    <div class="col-lg-6">
      <label for="" class="font-10 text-muted">Term</label>
      <select name="term" id="" class="form-control text-danger rounded-0">
        <option value="1" {{ (request('term') == 1) ? 'selected' : '' }}>Term One</option>
        <option value="2" {{ (request('term') == 2) ? 'selected' : '' }}>Term Two</option>
        <option value="3" {{ (request('term') == 3) ? 'selected' : '' }}>Term Three</option>
      </select>
    </div>
    <div class="col-lg-6">
      <label for="" class="font-10 text-muted">Start Date</label>
      <input type="date" class="form-control" name="start_date" value="{{old('start_date')}}" />
      <small class="text-danger">{{ $errors->first('start_date') }}</small>
    </div>
    <div class="col-lg-6">
      <label for="" class="font-10 text-muted">Start Date</label>
      <input type="date" class="form-control" name="end_date" value="{{old('end_date')}}" />
      <small class="text-danger">{{ $errors->first('end_date') }}</small>
    </div>

    <div class="col-lg-12">
      <label for="" class="font-10 text-muted">Next Term Start Date</label>
      <input type="date" class="form-control" name="next_term_start_date" value="{{old('next_term_start_date')}}" />
      <small class="text-danger">{{ $errors->first('next_term_start_date') }}</small>
    </div>

    <div class="col-lg-12 my-2">
      <button type="submit" class="btn btn-primary btn-md rounded-5 w-100">Save Term</button>
    </div>
  </form>
</div>
</div>

@endsection
