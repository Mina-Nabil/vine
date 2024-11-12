<div class="card">
    <div id="carouselExampleIndicators3" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner" role="listbox">
            <div class="carousel-item active">
                <img class="img-fluid" src="{{$slide->image_url}}" alt="Slide">
                <div class="carousel-caption d-none d-md-block">
                    <h3 class="text-white">{{$slide->SLID_TITL}}</h3>
                    <p>{{$slide->SLID_SBTL}}</p>
                </div>
                <div class="row">
                    <div class="col-3">
                        <button class="btn btn-danger m-15" onclick="confirmAndDelete({{$slide->id}})">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>