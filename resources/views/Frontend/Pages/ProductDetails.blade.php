@extends('Frontend.layouts')
@section('page_content')
<div class="ps-product--detail pt-60" id="app">
    <div class="ps-container">
            <div class="row">
            <product-details :product="{{json_encode($product)}}"></product-details>
            </div>
        </div>
</div>
@endsection