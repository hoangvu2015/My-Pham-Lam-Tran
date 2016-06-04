<?php

namespace Antoree\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Antoree\Http\Requests;
use Antoree\Http\Controllers\Controller;
use Antoree\Http\Controllers\ViewController;

use Antoree\Models\EmailSubscribe;
use Antoree\Models\Helpers\QueryStringBuilder;
use Antoree\Models\Helpers\AppHelper;
use Antoree\Models\Helpers\DateTimeHelper;
use Antoree\Models\Helpers\MailHelper;
use Antoree\Models\Helpers\PaginationHelper;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use Maatwebsite\Excel\Facades\Excel;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class EmailSubcribeController extends ViewController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
         $number_page = 20;
       $email_subscribe_list = null;
        if ($request->input('advanced_export_excel', 0) == 2) {
           return $this->epxportByTime($request);
       }
       if ($request->input('datetime_range')!= null) {
           $datetime_range = $request->input('datetime_range');
           $datetime_array = explode(' - ', $datetime_range);
           $time_format = DateTimeHelper::compoundFormat('shortDate', ' ', 'longTime');
           $time_start = fromFormattedTime($time_format, $datetime_array[0]);
           $time_end = fromFormattedTime($time_format, $datetime_array[1]);
           $email_subscribe_list = EmailSubscribe::filter($time_start, $time_end, null)->orderBy('created_at','desc')->paginate($number_page);
           // $email_subscribe_list = EmailSubscribe::orderBy('id','desc')->paginate($number_page);
       }
       else $email_subscribe_list = EmailSubscribe::orderBy('created_at','desc')->paginate($number_page);
       $datetime_range = $request->has('datetime_range') ? $request->input('datetime_range') : null;
       $startDate = false;
       $endDate = false;
       $fullFormat = DateTimeHelper::compoundFormat('shortDate', ' ', 'longTime');

       if ($datetime_range) {
        $datetime_ranges = explode(' - ', $datetime_range);
        if (count($datetime_ranges) == 2) {
            $startDate = fromFormattedTime($fullFormat, $datetime_ranges[0]);
            $endDate = fromFormattedTime($fullFormat, $datetime_ranges[1]);

            if ($startDate === false || $endDate === false) {
                $datetime_range = null;
                $startDate = $endDate = false;
            }
        } else {
            $datetime_range = null;
        }
    }

    $query = new QueryStringBuilder([
        'page' => $email_subscribe_list->currentPage(),
        'export_excel' => null,
        'advanced_export_excel' => null,
        ], localizedAdminURL('subscribe'));

    $datetime_js_format = DateTimeHelper::compoundJsFormat('shortDate', ' ', 'longTime');
    $page_helper = new PaginationHelper($email_subscribe_list->lastPage(), $email_subscribe_list->currentPage(), $email_subscribe_list->perPage());

    return view($this->themePage('subscribe.list'), [
        'email_subscribe_list' => $email_subscribe_list,
        'query' => $query,
        'page_helper' => $page_helper,
        'datetime_js_format' => $datetime_js_format,
        'datetime_js_24' => mb_strpos($datetime_js_format, 'a') !== false && mb_strpos($datetime_js_format, 'A') !== false ? 'false' : 'true',
        'start_date' => $startDate !== false ? formatTime($fullFormat, $startDate) : formatTime($fullFormat, 'now', -1),
        'end_date' => $endDate !== false ? formatTime($fullFormat, $endDate) : formatTime($fullFormat, 'now', 1),
        ]);
}

protected function formatRequest($requests)
{
    foreach ($requests as $request) {
        if(!empty($request->user_id)){

            $allRequestUser = EmailSubscribe::where('user_id',$request->user_id)->orderBy('id', 'asc')->get();
        }
    }
    return $requests;
}

protected function simpleExport($emailRequests)
{
    $emailRequests = $this->formatRequest($emailRequests);
    return Excel::create('EmailRequest', function ($excel) use ($emailRequests) {
        $excel->sheet('Sheet 1', function ($sheet) use ($emailRequests) {
            $data = [];
            $data[] = [
            'ID','Email','Tên','Số điện thoại','User id','Ngày đăng ký'
            ];
            foreach ($emailRequests as $emailRequest) {
                $required_email_subscribe = '';
                if (!empty($emailRequest->teacher_id)) {
                    $emailRequestSubscribe = $emailRequest->userProfile;
                    $required_email_subscribe = $emailRequestSubscribe->name . ' (' . $emailRequestSubscribe->email . ')';
                }
                if (empty($required_email_subscribe)) {
                    $data[] = [
                    $emailRequest->id,
                    $emailRequest->email,
                    $emailRequest->name,
                    $emailRequest->phone,
                    $emailRequest->user_id,
                    $emailRequest->created_at,
                    ];
                }
                else {
                    $data[] = [
                    $emailRequest->id,
                    $emailRequest->email,
                    $emailRequest->name,
                    $emailRequest->phone,
                    $emailRequest->user_id,
                    $emailRequest->created_at,
                    ];
                }
            }
            $sheet->fromArray($data, null, 'A1', true);
        });
    })->download('xls');
    return redirect($current_url)->withErrors([trans('error.no_action')]);
}

// protected function advancedExport(Request $request)
// {
//     if (!$request->has('current_url')) {
//         abort(404);
//     }
//     $current_url = $request->current_url;
//     $from_id = intval($request->input('export_from_id', 0));
//     $to_id = intval($request->input('export_to_id', 0));
//     if ($from_id > $to_id) {
//         $tmp_id = $from_id;
//         $from_id = $to_id;
//         $to_id = $tmp_id;
//     }
//     if (!($from_id <= 0 || $to_id <= 0)) {
//         $emailRequests = EmailSubscribe::where('id', '>=', $from_id)
//         ->where('id', '<=', $to_id)
//         ->orderBy('id', 'asc')->get();
//         return $this->simpleExport($emailRequests);
//     }
// }

protected function epxportByTime($request)
{
    date_default_timezone_set("Asia/Ho_Chi_Minh");
    if (!$request->has('current_url')) {
        abort(404);
    }
    $current_url = $request->input('current_url');
    $datetime_range = null;
    if ($request->has('export_datetime_range')) {
        $datetime_range = $request->input('export_datetime_range');
    }
    $datetime_array = explode(' - ', $datetime_range);
    $time_format = DateTimeHelper::compoundFormat('shortDate', ' ', 'longTime');
    $time_start = fromFormattedTime($time_format, $datetime_array[0]);
    $time_end = fromFormattedTime($time_format, $datetime_array[1]);
    $emailRequests = EmailSubscribe::filter($time_start, $time_end, null)->orderBy('created_at','asc')->get();
    $this->simpleExport($emailRequests);
}
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}