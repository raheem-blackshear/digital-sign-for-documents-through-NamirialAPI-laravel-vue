@extends('layouts.app')
@section('content')
    <div class="container">
        Content Goes Right Here
    </div>

    <div id="app-2">
            <span>
              @{{ message }}
            </span>
          </div>
@endsection

@section('scripts')
<script>

        var app2 = new Vue({
            el: '#app-2',
            data: {
              message: 'testetsetset '
            }
          });
</script>
@endsection
