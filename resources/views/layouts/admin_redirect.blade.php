@extends('layouts.admin')
@section('javascript')
    <script>
        $(document).ready(function() {
            gotoUrl("{!! url()->full() !!}",1,);
        });
    </script>
@endsection