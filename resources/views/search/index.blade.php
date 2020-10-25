@extends('front.layout')
@section('pageTitle', 'صفحه جستجو')
@section('body')

    <div id="basicExample">
        @foreach($photos as $photo)
                <a href="{{ url($photo->user->user_name.'/photo/'.$photo->p_hash) }}" id="{{ $photo->id }}">
                    <img commentCount="{{ count($photo->comments) }}" count="{{ $photo->rate }}" id="{{ $photo->id }}" alt="caption for image 1" src="{{ url($photo->gallery_sources) }}"/>
                </a>
        @endforeach
    </div>

@endsection

@section('js')
    <script>
        $(document).ready(function () {
            // alert($('#count').text())
        });
        // alert($('#count').text())
        $('.cap'+19+' #count').text('data');
        function rate(event,id,val){
            event.preventDefault();
            $.ajax({
                type: 'POST',
                url: '{{ route('rate.add') }}',
                data: {'_token': '<?php echo csrf_token()?>', 'id': id, 'val':val},
                success: function (data) {
                    $('.cap'+id+' #count').text(data);
                    if( val == 0){
                        $('.cap'+id+' #like i').removeAttr('hidden');
                        $('.cap'+id+' #like').removeAttr('hidden');
                        $('.cap'+id+' #dis_like i').attr('hidden', 'hidden');
                        $('.cap'+id+' #dis_like').attr('hidden','hidden');
                    }else{
                        $('.cap'+id+' #dis_like i').removeAttr('hidden');
                        $('.cap'+id+' #dis_like').removeAttr('hidden');
                        $('.cap'+id+' #like i').attr('hidden', 'hidden');
                        $('.cap'+id+' #like').attr('hidden','hidden');
                    }
                }
            })
        }
        $('#gal1').galereya();
        $("#basicExample").justifiedGallery({
            'rowHeight': 200,
            'maxRowHeight': 250,
            /*'sizeRangeSuffixes':{'lt100':'_t',
                'lt240':'_m',
                'lt320':'_n',
                'lt500':'',
                'lt640':'_z',
                'lt1024':'_b'}*/
            'lastRow': 'justify',
            'captions': true,
            'margins': 3,
            // 'waitThumbnailsLoad': false,
            'randomize': true,
            // 'filter': false,
            'rtl': true,
            'refreshTime': 100,
            // 'target': '_blank',
            'cssAnimation': true,
            'captionSettings': { animationDuration: 800,
                visibleOpacity: 0.7,
                nonVisibleOpacity: 0.0 }


        });
        // $('#basicExample2').justifiedGallery({
        //     rowHeight : 70,
        //     lastRow : 'nojustify',
        //     margins : 3
        // });
    </script>
@endsection
