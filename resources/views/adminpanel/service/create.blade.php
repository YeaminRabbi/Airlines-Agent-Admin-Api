@extends('layouts.adminpanel.master')

@section('content')    
<div class="container-xxl flex-grow-1 container-p-y">
    @if (\Session::has('success'))
      <div class="row">
          <div class="col-md-12">
              <div id="notificationAlert" style="display: block;">
                  <div class="alert alert-warning">
                      <span style="color:black;">
                          {!! \Session::get('success') !!}
                      </span>
                  </div>
              </div>
          </div>
      </div>
    @endif
    
    @if ($errors->any())
        <div class="row">
            <div class="col-md-12">
                <div id="errorAlert" style="display: block;">
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Service / </span> Create</h4>
    <div class="row">
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Service Information</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('service.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-title">Title</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="basic-default-title" placeholder="Enter title"
                                    name="title" required />
                            </div>
                        </div>
                      
                       
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-image">Image</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control upload__inputfile" id="basic-default-image" name="file" required/>
                            </div>
                        </div>  
                     

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-content">content</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" id="basic-default-content" rows="3" name="content"></textarea>
                            </div>
                        </div>

                       
                        <div class="row justify-content-end">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                                <a href="{{ route('service.index') }}" class="btn btn-dark btn-sm">Back to List</a>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>

    </div>

</div>

@endsection

@section('footer_js')
<script src="https://cdn.ckeditor.com/ckeditor5/35.2.1/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create( document.querySelector( '#basic-default-content' ) )
        .catch( error => {
            console.error( error );
        } );
</script>
<script>
    $('#notificationAlert').delay(3000).fadeOut('slow');
</script>

@endsection