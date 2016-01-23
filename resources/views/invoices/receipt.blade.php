@extends($layout)
@section('stylesheets')

@stop
@section('scripts')
    <script src="/assets/js/invoices/receipt.js"></script>
@stop

@section('content')
    {!!$receipt_html!!}
@stop