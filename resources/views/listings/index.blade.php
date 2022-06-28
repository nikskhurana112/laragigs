<x-layout>
@include('partials._hero')
@include('partials._search')

<div class="lg:grid lg:grid-cols-2 gap-4 space-y-4 md:space-y-0 mx-4">   
@if(count($listings) == 0)
    <p>No Listing found!</p>

@else
    @foreach ($listings as $listing)
    <!-- Item 1 -->
    <x-listing-card :listing='$listing'/>
    @endforeach
</div>


@endif
<div class="mt-6 p-4">
    {{$listings->links()}}
</div>
</x-layout>