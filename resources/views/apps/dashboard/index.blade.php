@extends('apps.layouts.app')

@section('content')
<div class="row page-titles mx-0">
    <div class="col p-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Home</a></li>
        </ol>
    </div>
</div>


<div class="container-fluid mt-3">
  <div class="row">
    <div class="col-lg-3 col-sm-6">
      <div class="card gradient-1">
        <div class="card-body">
          <h3 class="card-title text-white">Products Sold</h3>
          <div class="d-inline-block">
            <h2 class="text-white">4565</h2>
            <p class="text-white mb-0">Jan - March 2019</p>
          </div>
          <span class="float-right display-5 opacity-5">
            <i class="fa fa-shopping-cart"></i>
          </span>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-sm-6">
      <div class="card gradient-2">
        <div class="card-body">
          <h3 class="card-title text-white">Net Profit</h3>
          <div class="d-inline-block">
            <h2 class="text-white">$ 8541</h2>
            <p class="text-white mb-0">Jan - March 2019</p>
          </div>
          <span class="float-right display-5 opacity-5">
            <i class="fa fa-money"></i>
          </span>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-sm-6">
      <div class="card gradient-3">
        <div class="card-body">
          <h3 class="card-title text-white">New Customers</h3>
          <div class="d-inline-block">
            <h2 class="text-white">4565</h2>
            <p class="text-white mb-0">Jan - March 2019</p>
          </div>
          <span class="float-right display-5 opacity-5">
            <i class="fa fa-users"></i>
          </span>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-sm-6">
      <div class="card gradient-4">
        <div class="card-body">
          <h3 class="card-title text-white">Customer Satisfaction</h3>
          <div class="d-inline-block">
            <h2 class="text-white">99%</h2>
            <p class="text-white mb-0">Jan - March 2019</p>
          </div>
          <span class="float-right display-5 opacity-5">
            <i class="fa fa-heart"></i>
          </span>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
