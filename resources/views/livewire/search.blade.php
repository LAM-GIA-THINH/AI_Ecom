<style>
    .search-style-1 {
        text-align: left; 
    }

    .search-style-1 form {
        display: inline-block;
    }

    .search-style-1 input[type="text"] {
        width: 600px;
        padding: 10px;
    }
</style>

<div class="search-style-1">
    <form action="">
        
    </form>
</div>
<div class="col-lg-6">
                <form action="{{ route('product.search') }}">
                    <div class="input-group">
                    <input type="text" name="q" class="form-control" placeholder="Tìm kiếm sản phẩm..." value="{{ $q }}">
                        <div class="input-group-append">
                            <span class="input-group-text bg-transparent text-primary">
                                <i class="fa fa-search"></i>
                            </span>
                        </div>
                    </div>
                </form>
            
            </div>