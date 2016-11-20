@if(count($errors) > 0)

    @foreach($errors->all() as $error)
    <div class="alert alert-warning alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-info"></i> Alert!</h4>
       {{ $error }}
    </div>
    @endforeach
@endif