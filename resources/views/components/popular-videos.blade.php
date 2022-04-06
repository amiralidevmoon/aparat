<h1 class="new-video-title"><i class="fa fa-bolt"></i> محبوب‌ترین‌ها</h1>
<div class="row">

    @foreach ($popularVideos as $video)
        <x-video-box :video="$video"/>
    @endforeach

</div>
