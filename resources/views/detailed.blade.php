
@extends('layouts.registerSale')

@section('content')

<div id="app">
        @if(Auth::check())
            <registersale logged_in = "1"/>
            <!-- <userDetails user_deatiail = $ -->
        @else
            <registersale logged_in = "0"/>
        @endif

</div>
@endsection

@section('scripts')
<script src="https://rawgit.com/cristijora/vue-form-wizard/master/dist/vue-form-wizard.js"></script>
<script src="assets/js/script.min.js"></script>
<script src="assets/js/iban.js"></script>
@endsection

@section('css')
<link rel="stylesheet" href="https://rawgit.com/lykmapipo/themify-icons/master/css/themify-icons.css">
<link rel="stylesheet" href="https://rawgit.com/cristijora/vue-form-wizard/master/dist/vue-form-wizard.min.css">
<link rel="stylesheet" href="assets/css/main.css">

@endsection
