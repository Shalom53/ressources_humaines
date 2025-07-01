


@extends('layout')

@section('title')

    Ressources Humaines | Tableau de bord

@endsection

@section('css')






        <link rel="stylesheet" href="{{asset('app')}}/assets/plugins/daterangepicker/daterangepicker.css">

        <link rel="stylesheet" href="{{asset('app')}}/assets/plugins/tabler-icons/tabler-icons.css">


        <link rel="stylesheet" href="{{asset('app')}}/assets/plugins/jvectormap/jquery-jvectormap-2.0.5.css">




@endsection

@section('contenu')


 @include('tableau.content')



@endsection


@section('js')

   <script src="{{asset('app')}}/assets/plugins/apexchart/apexcharts.min.js" type="text/javascript"></script>
        <script src="{{asset('app')}}/assets/plugins/apexchart/chart-data.js" type="text/javascript"></script>

        <!-- Chart JS -->
        <script src="{{asset('app')}}/assets/plugins/chartjs/chart.min.js" type="text/javascript"></script>
        <script src="{{asset('app')}}/assets/plugins/chartjs/chart-data.js" type="text/javascript"></script>

        <!-- Chart JS -->
        <script src="{{asset('app')}}/assets/plugins/peity/jquery.peity.min.js" type="text/javascript"></script>
        <script src="{{asset('app')}}/assets/plugins/peity/chart-data.js" type="text/javascript"></script>

        <!-- Daterangepikcer JS -->
        <script src="{{asset('app')}}/assets/js/moment.min.js" type="text/javascript"></script>
        <script src="{{asset('app')}}/assets/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>

        




@endsection
