
@extends(config('schoolviser.admin_layout'))

@section('module-page-heading', 'School Info')

@section('pageheaderDescription', 'A place to configure all your system configurations.')

@section('where-am-i')
<a href="" class="font-10 bg-light py-1 px-2 rounded-4 my-1 fw-bold">></a>
<a href="{{route('settings')}}" class="font-10 bg-light py-1 px-2 rounded-4 my-1">Settings</a>
@endsection

@section('module-links')
    
@endsection
    

@section('content')
<div class="row mt-3">
    <div class="col-lg-8">
        <div class="card">
            <form class="card-body row py-4" action="{{route('site.settings.school.info.update')}}" method="POST" enctype="multipart/form-data">
                @csrf
        
                <div class="col-lg-3">
                    <p class="m-lg-0">School Logo</p>
                </div>
                <div class="col-lg-9">
                    <div class="row">
                        <div class="col-lg-6"><input type="file" name="school_logo" id=""></div>
                    <div class="col-lg-6"><img src="{{ asset($schoolinfo->school_logo) }}" alt="School Logo" class="img" /></div>
                    </div>
                </div>

                <div class="col-lg-3 mt-lg-3">
                    <p class="m-lg-0">School Logo</p>
                </div>
                <div class="col-lg-9 mt-lg-3">
                    <input type="text" name="school_name" value="{{ old('school_name') ?? $schoolinfo->school_name }}" class="form-control" />
                </div>

                <div class="col-lg-5 pt-5">
                    <button type="submit" class="btn btn-primary btn-md w-100">Update</button>
                </div>
                
            </form>
        </div>
    </div>
</div>
@endsection
