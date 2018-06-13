@if(count($errors))
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>

        <h4 class="alert-heading">Validation Errors</h4>
        <hr />

        @foreach($errors as $error)
            @foreach($error as $item)
                {{ $item }} <br />
            @endforeach
        @endforeach
    </div>
@endif