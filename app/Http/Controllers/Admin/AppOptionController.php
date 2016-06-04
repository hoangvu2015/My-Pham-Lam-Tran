<?php

namespace Antoree\Http\Controllers\Admin;

use Antoree\Http\Controllers\MultipleLocaleContentController;
use Antoree\Models\AppOption;
use Antoree\Models\Helpers\AppHelper;
use Antoree\Models\Helpers\AppOptionHelper;
use Antoree\Models\Helpers\PaginationHelper;
use Antoree\Models\Helpers\QueryStringBuilder;
use Antoree\Models\Helpers\StoredPhoto;
use Illuminate\Http\Request;

use Antoree\Http\Requests;
use Mews\Purifier\Facades\Purifier;

class AppOptionController extends MultipleLocaleContentController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        if ($request->has('delete')) {
            $this->destroy($request, $request->input('delete'));
        }

        $options = AppOption::paginate(AppHelper::DEFAULT_ITEMS_PER_PAGE);
        $query = new QueryStringBuilder([
            'page' => $options->currentPage(),
            'delete' => null,
        ], localizedAdminURL('app-options'));
        return view($this->themePage('app_option.list'), [
            'options' => $options,
            'query' => $query,
            'page_helper' => new PaginationHelper($options->lastPage(), $options->currentPage(), $options->perPage()),
            'value_max_length' => AppHelper::MEDIUM_TEACHER_ABOUT_LENGTH
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy(Request $request, $key)
    {
        $option = AppOption::where('key', $key)->firstOrFail();

        $redirect_url = localizedAdminURL('app-options');
        $rdr = $request->session()->pull(AppHelper::SESSION_RDR, '');
        if (!empty($rdr)) {
            $redirect_url = $rdr;
        }

        return $option->delete() === true ? redirect($redirect_url) : redirect($redirect_url)->withErrors([trans('error.database_delete')]);
    }

//    public function editCompanyAddress()
//    {
//        $data = [];
//        $data['company_address'] = [];
//        foreach (allSupportedLocales() as $localeCode => $properties) {
//            $data['company_address'][$localeCode] = AppOptionHelper::get('company_address', '', $localeCode);
//        }
//        return view($this->themePage('app_option.company_address'), $data);
//    }
//
//    public function updateCompanyAddress(Request $request)
//    {
//        $this->validateMultipleLocaleData($request, ['company_address'], [], $data, $successes, $fails, $old);
//        foreach ($data as $locale => $inputs) {
//            foreach ($inputs as $name => $value) {
//                $key = AppOptionHelper::fullKey($name, $locale);
//                AppOptionHelper::set($key, clean($value, 'blog'));
//            }
//        }
//        return redirect(localizedAdminURL('app-options/company-address'));
//    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function editHomepage()
    {
        $data = [];
        $data['max_size'] = asKb(maxUploadFileSize());
        $data['cover_picture'] = [];
        $data['cover_heading'] = [];
        $data['cover_subheading'] = [];
        $data['slide_picture'] = [];
        $data['slide_content'] = [];
        $data['max_slides'] = [];
        foreach (allSupportedLocales() as $localeCode => $properties) {
            $data['cover_picture'][$localeCode] = AppOptionHelper::get('homepage_cover_picture', '', $localeCode);
            $data['cover_heading'][$localeCode] = AppOptionHelper::get('homepage_cover_heading', '', $localeCode);
            $data['cover_subheading'][$localeCode] = AppOptionHelper::get('homepage_cover_subheading', '', $localeCode);

            $slidePictures = AppOptionHelper::get('homepage_slide_picture', [], $localeCode, true);
            $slideContents = AppOptionHelper::get('homepage_slide_content', [], $localeCode, true);
            $data['slide_picture'][$localeCode] = array_values($slidePictures);
            $data['slide_content'][$localeCode] = array_values($slideContents);
            $data['max_slides'][$localeCode] = max(count($data['slide_picture'][$localeCode]), count($data['slide_content'][$localeCode]));
        }
        return view($this->themePage('app_option.homepage'), $data);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function updateHomepage(Request $request)
    {
        if ($request->has('pages')) {
            $this->validateMultipleLocaleData($request, ['cover_picture_old', 'cover_picture', 'cover_heading', 'cover_subheading'], [], $data, $successes, $fails, $old);
            foreach ($data as $locale => $inputs) {
                foreach ($inputs as $name => $value) {
                    if ($name == 'cover_picture_old') continue;

                    $key = AppOptionHelper::fullKey('homepage_' . $name, $locale);
                    if ($name == 'cover_picture' && !empty($value)) {
                        $storedPhoto = new StoredPhoto();;
                        if ($storedPhoto->fromUploadedFile($value)) {
                            if ($storedPhoto->move('options')) {
                                $value = $storedPhoto->targetFileAsset;
                            } else {
                                $value = '';
                            }
                        } else {
                            $value = '';
                        }
                    }
                    if ($name == 'cover_picture' && empty($value)) {
                        $value = $data[$locale]['cover_picture_old'];
                    }
                    AppOptionHelper::set($key, $value);
                }
            }
            AppOptionHelper::set('homepage_view', 'cover');
        }

        if ($request->has('trial')) {
            $this->validateMultipleLocaleData($request, ['slide_picture_old', 'slide_picture', 'slide_content'], [], $data, $successes, $fails, $old);
            foreach ($data as $locale => $inputs) {
                $prepared_options = [];
                foreach ($inputs as $name => $values) {
                    if ($name == 'slide_picture_old') continue;

                    $k = 'homepage_' . $name;
                    AppOptionHelper::un_set($k, $locale, true);

                    for ($i = 0, $loop = count($values); $i < $loop; ++$i) {
                        $key = AppOptionHelper::fullKey($k, $locale, $i + 1);
                        $value = $values[$i];
                        if ($name == 'slide_picture' && !empty($value)) {
                            $storedPhoto = new StoredPhoto();;
                            if ($storedPhoto->fromUploadedFile($value)) {
                                if ($storedPhoto->move('options')) {
                                    $value = $storedPhoto->targetFileAsset;
                                } else {
                                    $value = '';
                                }
                            } else {
                                $value = '';
                            }
                        }
                        if ($name == 'slide_picture' && empty($value)) {
                            $value = $data[$locale]['slide_picture_old'][$i];
                        }
                        $prepared_options[$i][$key] = $value;
                    }
                }
                foreach ($prepared_options as $prepared_option) {
                    if (!isEmptyAll($prepared_option)) {
                        foreach ($prepared_option as $key => $value) {
                            AppOptionHelper::set($key, $value, '', true);
                        }
                    }
                }
            }
            AppOptionHelper::set('homepage_view', 'slideshow');

            return redirect(localizedAdminURL('app-options/homepage') . '#homepage-slideshow');
        }

        return redirect(localizedAdminURL('app-options/homepage') . '#homepage-cover');
    }
}
