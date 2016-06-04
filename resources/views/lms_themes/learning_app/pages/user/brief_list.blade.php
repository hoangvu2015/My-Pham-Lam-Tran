<ul class="list-inline">
    <li class="margin-v-0-10">
        <span class="label label-danger">{{ trans('label._member_since', ['time' => $user_profile->memberSince]) }}</span>
    </li>
    <li class="margin-v-0-10">
        <span class="label label-success">{{ trans_choice('label._day', $user_profile->memberDays, ['count' => $user_profile->memberDays]) }}</span>
    </li>
    @if($user_profile->hasRole('admin'))
        @if($is_owner)
            <li class="margin-v-0-10">
                <a class="text-underline-none" href="{{ adminHomeURL() }}">
                    <span class="label label-primary">{{ trans('roles.admin') }}</span>
                </a>
            </li>
        @else
            <li class="margin-v-0-10">
                <span class="label label-primary">{{ trans('roles.admin') }}</span>
            </li>
        @endif
    @endif
    @if($user_profile->hasRole('learning-manager'))
        @if($is_owner)
            <li class="margin-v-0-10">
                <a class="text-underline-none" href="{{ adminHomeURL() }}">
                    <span class="label label-info bg-orange-900">{{ trans('roles.learning_manager') }}</span>
                </a>
            </li>
        @else
            <li class="margin-v-0-10">
                <span class="label label-info bg-orange-900">{{ trans('roles.learning_manager') }}</span>
            </li>
        @endif
    @endif
    @if($user_profile->hasRole('learning-editor'))
        @if($is_owner)
            <li class="margin-v-0-10">
                <a class="text-underline-none" href="{{ adminHomeURL() }}">
                    <span class="label label-info bg-orange-700">{{ trans('roles.learning_editor') }}</span>
                </a>
            </li>
        @else
            <li class="margin-v-0-10">
                <span class="label label-info bg-orange-700">{{ trans('roles.learning_editor') }}</span>
            </li>
        @endif
    @endif
    @if($user_profile->hasRole('blog-editor'))
        @if($is_owner)
            <li class="margin-v-0-10">
                <a class="text-underline-none" href="{{ adminHomeURL() }}">
                    <span class="label label-info bg-aqua-900">{{ trans('roles.blog_editor') }}</span>
                </a>
            </li>
        @else
            <li class="margin-v-0-10">
                <span class="label label-info bg-aqua-900">{{ trans('roles.blog_editor') }}</span>
            </li>
        @endif
    @endif
    @if($user_profile->hasRole('blog-contributor'))
        @if($is_owner)
            <li class="margin-v-0-10">
                <a class="text-underline-none" href="{{ localizedURL('blog/add') }}">
                    <span class="label label-info bg-cyan-700">{{ trans('roles.blog_contributor') }}</span>
                </a>
            </li>
        @else
            <li class="margin-v-0-10">
                <span class="label label-info bg-cyan-700">{{ trans('roles.blog_contributor') }}</span>
            </li>
        @endif
    @endif
    @if($user_profile->hasRole('supporter'))
        @if($is_owner)
            <li class="margin-v-0-10">
                <a class="text-underline-none" href="{{ localizedURL('support-channel/{id?}', ['id' => null]) }}">
                    <span class="label label-info bg-deep-purple-500">{{ trans('roles.supporter') }}</span>
                </a>
            </li>
        @else
            <li class="margin-v-0-10">
                <a class="text-underline-none" href="{{ localizedURL('supporter/{id?}', ['id' => $user_profile->id]) }}">
                    <span class="label label-info bg-deep-purple-500">{{ trans('roles.supporter') }}</span>
                </a>
            </li>
        @endif
    @endif
    @if($user_profile->hasRole('teacher') && $user_profile->teacherProfile->isPublicizable())
        <li class="margin-v-0-10">
            <a class="text-underline-none" href="{{ localizedURL('teacher/{id?}', ['id' => $user_profile->teacherProfile->id]) }}">
                <span class="label label-info bg-indigo-900">{{ trans('roles.teacher') }}</span>
            </a>
        </li>
    @endif
    @if($user_profile->hasRole('student'))
        <li class="margin-v-0-10">
            <a class="text-underline-none" href="{{ localizedURL('student/{id?}', ['id' => $user_profile->studentProfile->id]) }}">
                <span class="label label-info bg-indigo-700">{{ trans('roles.student') }}</span>
            </a>
        </li>
    @endif
</ul>