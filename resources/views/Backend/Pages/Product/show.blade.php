@extends('Backend.index')
@section('title','Product Management')
@section('page_content')

<div class="container-fluid" id="app">
   <!-- Page Heading -->
   <h1 class="h3 mb-2 text-gray-800">Product Management</h1>
   <!-- DataTales Example -->
   <product-management :product="{{json_encode($product)}}"></product-management>
</div>
@endsection