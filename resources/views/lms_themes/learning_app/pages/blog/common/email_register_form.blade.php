 <div class="bottom">
    @if(session('subscribe_email_key'))
    <p class="text-left">Đăng ký theo dõi thành công!</p>
    @else
    <div class="row">
        <div class="col-md-6 col-xs-12">
            <p class="text-left">
                {{trans('new_label.blog_headline_subscribe')}}
            </p>
        </div>
        <div class="col-md-6 col-xs-12">
            <form action="{{ localizedURL('blog/subscribe') }}" method="post" id="register">
                {!! csrf_field() !!}
                <input type="hidden" name="link" value="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$_SERVER["REQUEST_URI"];?> ">
                <input type="email" class="email" name="email" placeholder="{{trans('new_label.blog_placeholder_email')}}" >
                <input type="submit" class="register-btn" value="ĐĂNG KÝ" onclick="GA('<?php echo $pageName; ?>', 'ClickSubscribeButton', '<?php echo $pageName; ?>');" >
            </form>
        </div>
    </div>
    <div class="clearfix"></div>
    @endif
</div>
