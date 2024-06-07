<div class="col-lg-6">
    <div style="position: relative;">
    <form action="{{ route('product.search') }}">
        <div class="input-group">
            <input type="text" name="q" wire:model.debounce.300ms="q" class="form-control" placeholder="Tìm kiếm sản phẩm..." value="{{ $q }}">
            <div class="input-group-append">
                <span class="input-group-text bg-transparent text-primary">
                    <i class="fa fa-search"></i>
                </span>
            </div>
        </div>
        </form>

        @if(!empty($products))
            <ul class="list-group position-absolute mt-2" style="width: 100%; max-height: 300px; overflow-y: auto; z-index: 1000;">
                @foreach($products as $product)
                    <li class="list-group-item d-flex align-items-center">
                    @php
                        $images = explode(',', $product->image);
                        $firstImage = $images[0];
                    @endphp
                        <img src="{{ asset('img/products/products/' . $firstImage) }}" alt="{{ $product->name }}" class="img-thumbnail mr-2" style="width: 50px; height: 50px; object-fit: cover;">
                        <div>
                            <a href="{{route('product.details', ['slug' => $product->slug])}}">{{ $product->name }}</a>
                            <p class="mb-0 text-muted">{{ number_format($product->regular_price) }} đ</p>
                        </div>
                    </li>
                @endforeach
            </ul>
        @elseif(strlen($q) > 1)
            <div class="mt-2">
                <!-- <p class="text-muted">No products found matching "{{ $q }}".</p> -->
            </div>
        @endif
    </div>
</div>
