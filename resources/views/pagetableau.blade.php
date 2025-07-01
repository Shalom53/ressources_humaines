@extends('layout')

@section('title')
    DRH | Tableau de bord
@endsection

@section('css')


@endsection




@section('contenu')



  @include('tableau.content')



 @endsection

 @section('js')

<!-- ApexChart JS -->
<script src="{{asset('admin')}}/assets/plugins/apexchart/apexcharts.min.js" type="971c37a9497d43b5d76f2274-text/javascript"></script>
<script src="{{asset('admin')}}/assets/plugins/apexchart/chart-data.js" type="971c37a9497d43b5d76f2274-text/javascript"></script>

<!-- Chart JS -->
<script src="{{asset('admin')}}/assets/plugins/chartjs/chart.min.js" type="971c37a9497d43b5d76f2274-text/javascript"></script>
<script src="{{asset('admin')}}/assets/plugins/chartjs/chart-data.js" type="971c37a9497d43b5d76f2274-text/javascript"></script>

<!-- Daterangepikcer JS -->
<script src="{{asset('admin')}}/assets/js/moment.min.js" type="971c37a9497d43b5d76f2274-text/javascript"></script>
<script src="{{asset('admin')}}/assets/plugins/daterangepicker/daterangepicker.js" type="971c37a9497d43b5d76f2274-text/javascript"></script>

<!-- Select2 JS -->
<script src="{{asset('admin')}}/assets/plugins/select2/js/select2.min.js" type="971c37a9497d43b5d76f2274-text/javascript"></script>

<!-- Color Picker JS -->
<script src="{{asset('admin')}}/assets/plugins/%40simonwep/pickr/pickr.es5.min.js" type="971c37a9497d43b5d76f2274-text/javascript"></script>



@endsection
