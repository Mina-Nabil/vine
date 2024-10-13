@extends('layouts.site')

@section('content')
<section id="content" class="clearfix">
    <div id="page-404">
        <div class="title-breadcrumb">
            <div class="container">
                <div class="col-md-12">
                    <!-- Page Title -->
                    <div class="page-listing-title">
                        <h2 class="page-title">Page not found </h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="content-404 col-md-12">
                <div class="notfound-image"><img src="https://cdn.shopify.com/s/files/1/0809/9475/files/img404.png?9840295977553883051" alt="404 - not fount" /></div>
                <h1>oops! That page can&#39;t be found</h1>
                <p>It looks like nothing was found at this location. Maybe try to use a search?</p>
                <div class="search-field">
                    <form class="search" action="{{url('search/results')}}">
                        <input type="image" src="{{asset('assets/images/icon-search.webp')}}" alt="Go" id="go">
                        <input type="text" name="q" class="search_box" placeholder="search our store" value="" />
                    </form>
                </div>
            </div>


</section>

@endsection