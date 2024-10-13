@extends('layouts.site')

@section('content')
<section id="content" class="clearfix">
    <div id="page-404">
        <div class="title-breadcrumb">
            <div class="container">
                <div class="col-md-12">
                    <!-- Page Title -->
                    <div class="page-listing-title">
                        <h2 class="page-title">Search </h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="content-404 col-md-12">
                <h1>What are you looking for?</h1>
                <p>Maybe we can help</p>
                <div class="search-field">
                    <form class="search" action="{{url('search/results')}}">
                        <input type="image" src="{{asset('assets/images/icon-search.webp')}}" alt="Go" id="go">
                        <input type="text" name="q" class="search_box" placeholder="search our store" value="" />
                    </form>
                </div>
            </div>


</section>

@endsection