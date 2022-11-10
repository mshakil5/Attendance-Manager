@extends('layouts.master')
   
@section('content')


<section class='dashboard'>
    
    @include('admin.inc.sidebar')

    <div class="rightBar p-4">
        
        <div class="row report-section shadow-sm">

            @foreach ($data as $item)
            <div class="report-box">
                <div class="title">{{ $item->name }}</div>
                <div class="amount"><iconify-icon icon="mi:call"></iconify-icon><a href="tel:{{ $item->phone }}" style="text-decoration: none;color: #00b879;"> <span>{{ $item->phone }}</span></a></div>
            </div>
            @endforeach



        </div>
    </div>
    {{-- <iconify-icon icon="mi:call"></iconify-icon> --}}
</section>



@endsection