<div class="media v-middle media-clearfix-xs">
    <div class="media-left">
        <a class="user-link-1-{{ $user_profile->id }}" href="{{ $user_url }}">
            <img class="img-circle width-120 height-120" src="{{ $user_profile->profile_picture }}" alt="people">
        </a>
    </div>
    <div class="media-body">
        <h4 class="text-headline margin-top-none margin-bottom-none">
            <a class="user-link-2-{{ $user_profile->id }}" href="{{ $user_url }}">
                {{ $user_profile->name }}
            </a>
        </h4>

        <p>
            @include('lms_themes.learning_app.pages.user.brief_list')
        </p>
    </div>
</div>