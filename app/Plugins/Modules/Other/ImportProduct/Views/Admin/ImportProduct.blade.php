@extends('admin.layout')

@section('main')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="col-md-12">
                <div class="process-alert">
                    {!! trans($pathPlugin.'::ImportProduct.note') !!}
                </div>
                <hr>
            </div>

            <form action="{{ route('admin_import_product.process') }}" method="post" accept-charset="UTF-8" class="form-horizontal" id="import-product" enctype="multipart/form-data">
                @csrf
                <div class="step">{!! trans($pathPlugin.'::ImportProduct.admin.process.step1') !!}</div>
                <div class="box-body">
                    <div class="fields-group">
                        <div class="form-group">
                            <label for="image" class="col-sm-2  control-label">
                                <a href="{{ route('admin_import_product.format') }}?type=import_product"><i class="fa fa-download" aria-hidden="true"></i> File format</a>
                            </label>
                            <div class="col-sm-6">
                                <div class="input-group">
                                    <input type="file" required="required" name="file" class="form-control" placeholder="" >
                                    <div class="btn input-group-addon button-upload">
                                        <i class="fa fa-file-excel-o"></i> {{ trans($pathPlugin.'::ImportProduct.admin.submit') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>

                <!-- /.box-footer -->
            </form>  
            
            <div class="response">
                @if($errors->has('file'))
                    <span class="text-red">{{ $errors->first('file') }}</span>
                @endif
                @if($errors->has('extension'))
                <span class="text-red">{{ $errors->first('extension') }}</span>
                @endif

                <div class="add_new_success">
                @if (Session::get('arrNew'))
                    <span><b>{!! trans($pathPlugin.'::ImportProduct.admin.process.add_new_sucess') !!}</b><br></span>
                    <div class="process-item">
                        @foreach (Session::get('arrNew') as $item)
                            {{ $item }}<br>
                        @endforeach
                    </div>
                @endif
                </div>

                <div class="update_success">
                @if (Session::get('arrUpdate'))
                    <span><b>{!! trans($pathPlugin.'::ImportProduct.admin.process.update_sucess') !!}</b><br></span>
                    <div class="process-item">
                        @foreach (Session::get('arrUpdate') as $item)
                        {{ $item }}<br>
                        @endforeach
                    </div>
                @endif
                </div>

                <div class="process_error">
                @if (Session::get('arrError'))
                <span><b>{!! trans($pathPlugin.'::ImportProduct.admin.process.error') !!}</b><br></span>
                <div class="process-item">
                    @foreach (Session::get('arrError') as $item)
                        {{ $item }}<br>
                    @endforeach
                </div>
                @endif  
                </div>
            
            </div>


            <hr>

            <form action="{{ route('admin_import_product.process_description') }}" method="post" accept-charset="UTF-8" class="form-horizontal" id="import-product-des" enctype="multipart/form-data">
                @csrf
                <div class="step">{!! trans($pathPlugin.'::ImportProduct.admin.process.step2') !!}</div>
                <div class="box-body">
                    <div class="fields-group">
                        <div class="form-group">
                            <label for="image" class="col-sm-2  control-label">
                                <a href="{{ route('admin_import_product.format') }}?type=import_product_description"><i class="fa fa-download" aria-hidden="true"></i> File format</a>
                            </label>
                            <div class="col-sm-6">
                                <div class="input-group">
                                    <input type="file" required="required" name="file_des" class="form-control" placeholder="" >
                                    <div class="btn input-group-addon button-upload-des">
                                        <i class="fa fa-file-excel-o"></i> {{ trans($pathPlugin.'::ImportProduct.admin.submit_des') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>

                <!-- /.box-footer -->
            </form>  
            
            <div class="response">
                @if($errors->has('file_des'))
                    <span class="text-red">{{ $errors->first('file_des') }}</span>
                @endif
                @if($errors->has('extension_des'))
                <span class="text-red">{{ $errors->first('extension_des') }}</span>
                @endif

                <div class="add_new_success">
                @if (Session::get('arrNewDes'))
                    <span><b>{!! trans($pathPlugin.'::ImportProduct.admin.process.add_new_sucess') !!}</b><br></span>
                    <div class="process-item">
                        @foreach (Session::get('arrNewDes') as $item)
                            {{ $item }}<br>
                        @endforeach
                    </div>
                @endif
                </div>

                <div class="update_success">
                @if (Session::get('arrUpdateDes'))
                    <span><b>{!! trans($pathPlugin.'::ImportProduct.admin.process.update_sucess') !!}</b><br></span>
                    <div class="process-item">
                        @foreach (Session::get('arrUpdateDes') as $item)
                        {{ $item }}<br>
                        @endforeach
                    </div>
                @endif
                </div>

                <div class="process_error">
                @if (Session::get('arrErrorDes'))
                <span><b>{!! trans($pathPlugin.'::ImportProduct.admin.process.product_notfound') !!}</b><br></span>
                <div class="process-item">
                    @foreach (Session::get('arrErrorDes') as $item)
                        {{ $item }}<br>
                    @endforeach
                </div>
                @endif  
                </div>
              

            </div>            


        </div>
    </div>
</div>


@endsection

@push('styles')
<style>
    .button-upload, .button-upload:hover,
    .button-upload-des, .button-upload-des:hover{
        background: #3c8dbc !important;
        color: #fff;
    }
    .response{
        padding: 5px 20px;
    }
    .update_success{
        color:blue;
    }
    .add_new_success{
        color:green;
    }
    .process_error{
        color:red;
    }
    .process-item{
        padding-left: 10px;
        font-style: italic;
    }
    .process-alert{
        margin-top: 10px;
    }
    .step{
        margin-left: 15px;
        font-size: 20px;
    }
</style>
@endpush

@push('scripts')
    <script>
        $('.button-upload').click(function(){
            $('#loading').show();
            $('#import-product').submit();
        });
        $('.button-upload-des').click(function(){
            $('#loading').show();
            $('#import-product-des').submit();
        });

    </script>
@endpush