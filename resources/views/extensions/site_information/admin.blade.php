<!-- Custom Tabs -->
<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        @foreach(allSupportedLocales() as $locale => $properties)
            <li{!! $locale == $site_locale ? ' class="active"' : '' !!}>
                <a href="#tab_{{ $locale }}" data-toggle="tab">
                    {{ $properties['native'] }}
                </a>
            </li>
        @endforeach
    </ul>
    <div class="tab-content">
        @foreach(allSupportedLocales() as $locale => $properties)
            <div class="tab-pane{{ $locale == $site_locale ? ' active' : '' }}" id="tab_{{ $locale }}">
                <div class="form-group">
                    <label for="inputTitle_{{ $locale }}">{{ trans('label.title') }}</label>
                    <input class="form-control" id="inputTitle_{{ $locale }}" name="title[{{ $locale }}]"
                           placeholder="{{ trans('label.title') }}" type="text"
                           value="{{ $extension->getProperty('title', $locale) }}">
                </div>
                <div class="form-group">
                    <label for="inputDescription_{{ $locale }}">{{ trans('label.description') }}</label>
                    <textarea rows="5" class="form-control" id="inputDescription_{{ $locale }}" name="description[{{ $locale }}]"
                              placeholder="{{ trans('label.description') }}">{{ $extension->getProperty('description', $locale) }}</textarea>
                </div>
                <div class="form-group">
                    <label for="inputAuthor_{{ $locale }}">{{ trans('label.author') }}</label>
                    <input class="form-control" id="inputAuthor_{{ $locale }}" name="author[{{ $locale }}]"
                           placeholder="{{ trans('label.tag_line') }}" type="text"
                           value="{{ $extension->getProperty('author', $locale) }}">
                </div>
                <div class="form-group">
                    <label for="inputKeywords_{{ $locale }}">{{ trans_choice('label.keyword', 2) }}</label>
                    <textarea rows="5" class="form-control" id="inputKeywords_{{ $locale }}" name="keywords[{{ $locale }}]"
                              placeholder="{{ trans_choice('label.keyword', 2) }}">{{ $extension->getProperty('keywords', $locale) }}</textarea>
                    <p class="help-block">{{ trans('label._single_line_typing', ['name' => trans_choice('label.keyword', 1)]) }}</p>
                </div>
            </div><!-- /.tab-pane -->
        @endforeach
    </div><!-- /.tab-content -->
</div><!-- nav-tabs-custom -->

<h4>Website Verification Services</h4>
<div class="form-group">
    <label for="inputGoogleWebmasterTools">Google Webmaster Tools</label>
    <input class="form-control" id="inputGoogleWebmasterTools" name="google_webmaster_tools" type="text"
           value="{{ $extension->getProperty('google_webmaster_tools') }}">
</div>
<div class="form-group">
    <label for="inputBingWebmasterCenter">Bing Webmaster Center</label>
    <input class="form-control" id="inputBingWebmasterCenter" name="bing_webmaster_center" type="text"
           value="{{ $extension->getProperty('bing_webmaster_center') }}">
</div>
<div class="form-group">
    <label for="inputPinterestSiteVerification">Pinterest Site Verification</label>
    <input class="form-control" id="inputPinterestSiteVerification" name="pinterest_site_verification" type="text"
           value="{{ $extension->getProperty('pinterest_site_verification') }}">
</div>
<div class="form-group">
    <label for="inputYandexWebmaster">Yandex Webmaster</label>
    <input class="form-control" id="inputYandexWebmaster" name="yandex_webmaster" type="text"
           value="{{ $extension->getProperty('yandex_webmaster') }}">
</div>