<?php

namespace Antoree\Http\Controllers\Admin;

use Antoree\Http\Controllers\MultipleLocaleContentController;
use Antoree\Models\Helpers\AppHelper;
use Antoree\Models\Helpers\PaginationHelper;
use Antoree\Models\Helpers\QueryStringBuilder;
use Antoree\Models\Teacher;
use Illuminate\Http\Request;
use Antoree\Http\Requests;
use Antoree\Models\Topic;
use Illuminate\Support\Facades\Validator;

class TopicController extends MultipleLocaleContentController
{
    #region Generated Code
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $topics = Topic::orderBy('created_at', 'desc')->paginate(AppHelper::DEFAULT_ITEMS_PER_PAGE);
        $query = new QueryStringBuilder([
            'page' => $topics->currentPage()
        ], localizedAdminURL('topics'));
        return view($this->themePage('topic.list'), [
            'topics' => $topics,
            'query' => $query,
            'page_helper' => new PaginationHelper($topics->lastPage(), $topics->currentPage(), $topics->perPage()),
            'rdr_param' => rdrQueryParam($request->fullUrl()),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view($this->themePage('topic.add'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validateMultipleLocaleData($request, ['name', 'description'], [
            'name' => 'required'
        ], $data, $successes, $fails, $old);

        $error_redirect = redirect(localizedAdminURL('topics/add'))
            ->withInput($old);

        if (count($successes) <= 0 && count($fails) > 0) {
            return $error_redirect->withErrors($fails[0]);
        }

        $topic = new Topic();
        foreach ($successes as $locale) {
            $transData = $data[$locale];
            $trans = $topic->translateOrNew($locale);
            $trans->name = $transData['name'];
            $trans->slug = toSlug($transData['name'], $topic->id . '-' . $locale);
            $trans->description = !empty($transData['description']) ? $transData['description'] : '';
        }
        if ($topic->save() === false) {
            return $error_redirect->withErrors([trans('error.database_insert')]);
        }

        return redirect(localizedAdminURL('topics'));
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
    public function edit(Request $request, $id)
    {
        return view($this->themePage('topic.edit'), [
            'topic' => Topic::findOrFail($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  int $id
     * @return Response
     */
    public function update(Request $request)
    {
        $topic = Topic::findOrFail($request->input('id'));

        $redirect = redirect(localizedAdminURL('topics/{id}/edit', ['id' => $topic->id]));

        $this->validateMultipleLocaleData($request, ['name', 'description'], [
            'name' => 'required'
        ], $data, $successes, $fails, $old);

        if (count($successes) <= 0 && count($fails) > 0) {
            return $redirect->withErrors($fails[0]);
        }

        foreach ($successes as $locale) {
            $transData = $data[$locale];
            $trans = $topic->translateOrNew($locale);
            $trans->name = $transData['name'];
            $trans->slug = toSlug($transData['name'], $topic->id);
            $trans->description = !empty($transData['description']) ? $transData['description'] : '';
        }
        if ($topic->save() === false) {
            return $redirect->withErrors([trans('error.database_update')]);
        }

        return $redirect;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy(Request $request, $id)
    {
        $topic = Topic::findOrFail($id);

        $redirect_url = localizedAdminURL('topics');
        $rdr = $request->session()->pull(AppHelper::SESSION_RDR, '');
        if (!empty($rdr)) {
            $redirect_url = $rdr;
        }

        return $topic->delete() === true ? redirect($redirect_url) : redirect($redirect_url)->withErrors([trans('error.database_delete')]);
    }

    #endregion

    public function teachers(Request $request, $id)
    {
        $show = $request->input('show', 'all');
        if (!in_array($show, ['chosen', 'all'])) {
            $show = 'all';
        }
        $topic = Topic::findOrFail($id);

        $teachers = $show == 'all' ? Teacher::paginate(AppHelper::DEFAULT_ITEMS_PER_PAGE) : $topic->teachers()->paginate(AppHelper::DEFAULT_ITEMS_PER_PAGE);
        $query = new QueryStringBuilder([
            'page' => $teachers->currentPage(),
            'show' => $show
        ], localizedAdminURL('topics/{id}/teachers', ['id' => $id]));
        return view($this->themePage('topic.teachers'), [
            'show' => $show,
            'topic' => $topic,
            'teachers' => $teachers,
            'topic_teachers' => $topic->teachers,
            'query' => $query,
            'page_helper' => new PaginationHelper($teachers->lastPage(), $teachers->currentPage(), $teachers->perPage())
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  int $id
     * @return Response
     */
    public function updateTeachers(Request $request)
    {
        $topic = Topic::findOrFail($request->input('id'));

        $validator = Validator::make($request->all(), [
            'teachers' => 'sometimes|array|exists:users,id',
            'show' => 'required|alpha|in:all,chosen',
            'page' => 'required|integer|min:1'
        ]);
        if ($validator->fails()) {
            return redirect(localizedAdminURL('topics/{id}/teachers', ['id' => $topic->id]))
                ->withErrors($validator);
        }

        $current_teachers = $request->input('show') == 'all' ?
            Teacher::skip(($request->input('page') - 1) * AppHelper::DEFAULT_ITEMS_PER_PAGE)->take(AppHelper::DEFAULT_ITEMS_PER_PAGE)->get() :
            $topic->teachers()->skip(($request->input('page') - 1) * AppHelper::DEFAULT_ITEMS_PER_PAGE)->take(AppHelper::DEFAULT_ITEMS_PER_PAGE)->get();

        $topic->teachers()->detach($current_teachers->pluck('id')->all());
        if (count($request->input('teachers')) > 0) {
            $topic->teachers()->attach($request->input('teachers'));
        }

        return redirect(localizedAdminURL('topics/{id}/teachers', ['id' => $topic->id]));
    }
}
