@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            @foreach ($errors->all() as $error )
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif