<div id="{{ $html_id }}" class="widget-intro-video-links">
    @foreach($items as $item)
    <h1>
       <i class="fa fa-fw fa-youtube-play"></i> <a  href="#introVideoModal" data-toggle="modal" >{{ $item->description }}</a>
    </h1>
    <?php
    parse_str( parse_url( $item->link, PHP_URL_QUERY ), $array_of_vars );
    $video_id = $array_of_vars['v'];
    ?>
    <div id="introVideoModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <iframe id="introVideo" width="640" height="360" src="//www.youtube.com/embed/{{$video_id}}" frameborder="0" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@section('extended_scripts')
<script>
    $(document).ready(function(){
        /* Get iframe src attribute value i.e. YouTube video url
        and store it in a variable */
        var url = $("#introVideo").attr('src');

        /* Assign empty url value to the iframe src attribute when
        modal hide, which stop the video playing */
        $("#introVideoModal").on('hide.bs.modal', function(){
            $("#introVideo").attr('src', '');
        });

        /* Assign the initially stored url back to the iframe src
        attribute when modal is displayed again */
        $("#introVideoModal").on('show.bs.modal', function(){
            $("#introVideo").attr('src', url);
        });
    });
</script>
@endsection