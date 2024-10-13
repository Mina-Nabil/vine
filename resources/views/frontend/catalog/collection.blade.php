@extends('layouts.site')

@section('content')
<section id="content" class="clearfix">
    <div id="collection">

        <div class="title-breadcrumb">
            <div class="container">
                <div class="col-md-12">
                    <!-- Collection Listing Title -->
                    <div class="collection-listing-title">
                        <h2 class="collection-title">{{$title}}</h2>
                    </div>
                    <!-- Begin breadcrumb -->
                    <div class="breadcrumb clearfix">
                        @foreach($breadcumbs as $breadcump)
                        <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
                            <a href="{{$breadcump->url}}" title="{{env('APP_NAME')}}" itemprop="url">
                                <span itemprop="title">{{$breadcump->title}}</span>
                            </a>
                        </span>
                        @if(!$loop->last)
                        <span class="arrow-space">
                            <i class="fa fa-angle-right"></i>
                        </span>
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="container" id="collection-content">

            <div class="col-md-12">
                <form method="POST">
                    @csrf
                    <div class="clearfix">
                        <!-- ToolBar -->
                        <div class="collection-toolbar">
                            <!-- Tags Filter -->
                            <div class="tags-filter">
                                <button id="showTagsFilter" type="button">Filter <i class="fa fa-angle-down"></i></button>
                            </div>
                            <!-- Showing -->
                            <div class="showing-number">
                                Showing {{min( $products->total(), ($products->currentPage()-1) * $products->perPage() + 1 )}} - {{min(($products->currentPage() * $products->perPage()), $products->total())}} of {{$products->total()}}
                                results
                            </div>

                            <div class="list-inline text-right">
                                <!-- Sort by -->
                                <div class="sortBy">
                                    <div id="sortButtonWarper" class="dropdown-toggle" data-toggle="dropdown">
                                        <button id="sortButton">
                                            <span class="name" id=sortingSpan>{{$sort_by_title ?? "Default Sorting"}}</span><i class="fa fa-caret-down"></i>
                                        </button>
                                        <i class="sub-dropdown1"></i>
                                        <i class="sub-dropdown"></i>
                                    </div>
                                    <div id="sortBox" class="control-container dropdown-menu">
                                        <ul id="sortForm" class="list-unstyled option-set text-left list-styled" data-option-key="sortBy">
                                            <input type="hidden" value={{$sort_by_value??'default'}} name="sort_by_value" id=sortInput>
                                            @foreach ($sortingOptions as $value => $title)
                                            <li class="sort"><a href="javascript:void(0)" onclick="setSorting('{{$value}}', '{{$title}}')">{{$title}}</a></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <script>
                                        function setSorting(value, title){
                                            $('.sortBy #sortingSpan').html(title)  
                                            $('.sortBy #sortInput').val(value)  
                                            $('.sortBy #sortBox').css("display", "none")  
                                        }   
                                    </script>
                                </div>

                                <!-- Number product per page -->

                                <div class="show-per-page">
                                    <div id="showButtonWarper" class="dropdown-toggle" data-toggle="dropdown">
                                        <button id="showButton">
                                            <span class="name" id=showSpan>{{$products->perPage()}} products per page</span>
                                            <i class="fa fa-caret-down"></i>
                                        </button>
                                        <i class="sub-dropdown1"></i>
                                        <i class="sub-dropdown"></i>
                                    </div>
                                    <div id="showBox" class="control-container dropdown-menu">
                                        <ul id="showForm" class="list-unstyled text-left list-styled">
                                            <input name=per_page id=showInput value='{{$products->perPage()}}' type="hidden">
                                            @foreach($pageAmountOptions as $amount)
                                            <li class="show {{$products->perPage() == $amount ? 'active': ''}}">
                                                <a href="javascript:void(0)" onclick="setPageCount({{$amount}})">{{$amount}} products per page</a>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <script>
                                        function setPageCount(count){
                                            $('.show-per-page #showSpan').html(count + " products per page")  
                                            $('.show-per-page #showInput').val(count)  
                                            $('.show-per-page #showBox').css("display", "none")  
                                        }
                                    </script>
                                </div>

                                <!-- View as -->

                                <div class="grid_list">
                                    <ul class="list-inline option-set hidden-xs" data-option-key="layoutMode">
                                        <li data-option-value="fitRows" id="goGrid" class="goAction  active" data-toggle="tooltip" data-placement="top" title="Grid">
                                            <i class="fa fa fa-th"></i>
                                        </li>
                                        <li data-option-value="straightDown" id="goList" class="goAction " data-toggle="tooltip" data-placement="top" title="List">
                                            <i class="fa fa-th-list"></i>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div id="tags-filter-content" class="tags-closed">
                            <!-- filter tags group -->
                            <div class="filter-tag-group">
                                <!-- tags groupd 0 -->
                                <div class="tag-group col-md-4" id="coll-filter-1">
                                    <p class="title">Sizes</p>
                                    <div class="swatch clearfix" data-option-index="1">
                                        @foreach($available_sizes as $size)
                                        <div class="swatch-element {{$size->code}} available ">
                                            <input id="swatch-1-{{$size->code}}" type="checkbox" name="size_filters[]" 
                                            value="{{$size->id}}" 
                                            {{(isset($applied_size_filters) &&  in_array($size->id, $applied_size_filters)) ? 'checked' : ""}}/>
                                            <label for="swatch-1-{{$size->code}}">
                                                {{$size->code}}
                                                <img class="crossed-out" />
                                            </label>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- tags groupd 1 -->
                                <div class="tag-group col-md-4" id="coll-filter-2">
                                    <p class="title">Colors</p>
                                    <div class="swatch color clearfix" data-option-index="0">
                                        @foreach($available_colors as $color)
                                        <div class="swatch-element color {{$color->class_code}} available ">
                                            <div class="tooltip">{{$color->name}}</div>
                                            <input id="swatch-0-{{$color->id}}" type="checkbox" name="color_filters[]" value="{{$color->id}}" 
                                            {{(isset($applied_color_filters) &&  in_array($color->id, $applied_color_filters)) ? 'checked' : ""}}
                                            />
                                            <label for="swatch-0-{{$color->id}}" style="background-color: {{$color->code}}; border-color: black;">
                                            </label>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- tags groupd 2 -->
                                {{-- <div class="tag-group col-md-3" id="coll-filter-3">
                                    <p class="title">Price Range</p>
                                    <div class="swatch clearfix" data-option-index="2">
                                        @foreach($price_filters as $value => $title)
                                        <div class="swatch-element {{$value}} available ">
                                            <div class="tooltip">{{$title}}</div>
                                            <input id="swatch-0-{{$value}}" type="checkbox" name="price_filters[]" value="{{$value}}"
                                            {{(isset($applied_price_filters) && in_array($value, $applied_price_filters)) ? 'checked' : ""}} />
                                            <label for="swatch-0-{{$value}}"> {{$title}}
                                            </label>
                                        </div>
                                        @endforeach
                                    </div>
                                </div> --}}

                                <!-- tags groupd 3 -->
                                <div class="tag-group col-md-4 text-center align-middle" style="padding: 0%" id="coll-filter-4">
                                    <button id="applyFilters" type="submit">Apply Filters</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>

            <div class="col-md-12">
                <div id="sandBox" class="products">

                    @foreach($products as $product)
                    <div class="element no_full_width" data-alpha="Donec aliquam ante non" data-price="25000" style="padding-left: 15px; padding-right:15px">
                        <x-product-list-tile :model="$product" />
                    </div>
                    @endforeach
                </div>
            </div>
        </div>


        <div class="col-md-12">
            <div class="pagination">
                <li class="prev">
                    <a class="disabled" @if($products->onFirstPage())
                        href="javascript:void(0)"
                        @else
                        href="{{$products->previousPageUrl()}}"
                        @endif
                        >
                        <i class="fa fa-angle-double-left"></i>
                    </a>
                </li>

                @foreach($products->getUrlRange(1, $products->lastPage()) as $page)
                <?php $isCurrent = $products->currentPage() == $loop->index+1; ?>
                <li @class(['active'=> $isCurrent])>
                    <a @if($isCurrent) href="javascript:void(0)" @else href="{{$page}}" @endif>{{$loop->index+1}}</a>
                </li>
                @endforeach

                <li class="next">
                    <a @if($products->onLastPage())
                        href="javascript:void(0)"
                        @else
                        href="{{$products->url($products->lastPage())}}"
                        @endif>
                        <i class="fa fa-angle-double-right"></i>
                    </a>
                </li>
            </div>
        </div>

    </div>

    <!--Group-content-center-->
    <x-quick-view-modal :prod-url="$loadProductJsonUrl" />
</section>
@endsection