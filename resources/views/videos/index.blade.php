@extends('layouts.master')

@section('content')

    <!-- category videos -->
    <x-category-videos :videos="$videos" :categoryTitle="$categoryTitle"/>

    <div class="text-center mt-4 change-dir-to-ltr">
        {{ $videos->onEachSide(5)->links() }}
    </div>
@endsection

