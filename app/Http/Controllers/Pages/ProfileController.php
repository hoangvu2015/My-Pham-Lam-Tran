<?php

namespace Antoree\Http\Controllers\Pages;

use Antoree\Http\Controllers\ViewController;

use Illuminate\Http\Request;
use Antoree\Http\Requests;

use Antoree\Models\Conversation;
use Antoree\Models\Course;
use Antoree\Models\Helpers\AppHelper;
use Antoree\Models\Helpers\CallableObject;
use Antoree\Models\Helpers\DateTimeHelper;
use Antoree\Models\Helpers\PaginationHelper;
use Antoree\Models\Helpers\QueryStringBuilder;
use Antoree\Models\Helpers\StoredAudio;
use Antoree\Models\Review;
use Antoree\Models\Role;
use Antoree\Models\Student;
use Antoree\Models\Teacher;
use Antoree\Models\WorkingFields;
use Antoree\Models\Topic;
use Antoree\Models\User;
use Antoree\Models\UserEducation;
use Antoree\Models\UserRecord;
use Antoree\Models\UserWork;
use Antoree\Models\PaymentInfo;
use Antoree\Models\PaymentType;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileController extends ViewController
{
    public function profile(Request $request)
    {
        if($this->auth_user->hasRole('teacher')){

            $teacher = $this->auth_user->teacherProfile;
            $teacher->average = $teacher->PointedAverageRate;
            $teacher->total_review = sizeof($teacher->reviews()->get());
            $user_articles = $this->auth_user->articles()
            ->ofBlog()->published()//->translatedIn($this->locale)
            ->orderBy('created_at', 'desc')->take(4)->get();
            $fields = WorkingFields::all();
            $fields = $fields->sortBy("name");
            $fields = $fields->toArray();

            $this->theme->title([trans('pages.page_profile_title')],false);
            $this->theme->description(trans('pages.page_profile_desc'));
            $array_payment = $this->paymentDetail();
            // dd($array_payment);
            // dd($teacher);
            return view($this->themePage('profile.profile_teacher'), [
                'max_upload_filesize' => maxUploadFileSize(),
                'topics' => Topic::all(),
                'fields' => $fields,
                'teacher_profile' => $teacher,
                'teacher_topics' => $teacher->topics,
                'teacher_fields' => $teacher->fields,
                'user_profile' => $this->auth_user,
                'user_works' => $this->auth_user->works,
                'user_educations' => $this->auth_user->educations->where('type', null),
                'user_teach_ex' => $this->auth_user->educations->where('type', 'teach_ex'),
                'user_certificates' => $this->auth_user->records()->ofCertificate()->get(),
                'date_js_format' => DateTimeHelper::shortDatePickerJsFormat(),
                'is_owner' => true,
                'max_size' => asKb(maxUploadFileSize()),
                'max_size_byte' => asByte(maxUploadFileSize()),
                'max_rate' => Review::MAX_RATE,
                'about_me_max_length' => AppHelper::MEDIUM_TEACHER_ABOUT_LENGTH,
                'user_articles' => $user_articles,
                'international_locale' => AppHelper::INTERNATIONAL_LOCALE_CODE,
                'shorten_length' => AppHelper::BLOG_ARTICLE_SHORTEN_LENGTH,
                'array_payment' => $array_payment,
                ]);
        }else {
            $user_articles = $this->auth_user->articles()
            ->ofBlog()->published()//->translatedIn($this->locale)
            ->orderBy('created_at', 'desc')->take(4)->get();

            $this->theme->title([trans('pages.page_profile_title')],false);
            $this->theme->description(trans('pages.page_profile_desc'));
            return view($this->themePage('profile.profile_student'), [
                'user_articles' => $user_articles,
                'max_upload_filesize' => maxUploadFileSize(),
                'user_profile' => $this->auth_user,
                'date_js_format' => DateTimeHelper::shortDatePickerJsFormat(),
                'is_owner' => true,
                'max_size' => asKb(maxUploadFileSize()),
                'max_size_byte' => asByte(maxUploadFileSize()),
                'international_locale' => AppHelper::INTERNATIONAL_LOCALE_CODE,
                'shorten_length' => AppHelper::BLOG_ARTICLE_SHORTEN_LENGTH,
                ]);
        }
    }

    private function paymentDetail()
    {
        $user_id = authUser()->id;
        $data_payment = PaymentInfo::where("user_id",$user_id)->first();
        $data = array();
        $country = "";
        $text_class = "";
        $payments_group = 0;

        $payment_BA1 = $this->getData($user_id,Paymenttype::BANK_ACCOUNT,1);
        $payment_BA2 = $this->getData($user_id,Paymenttype::BANK_ACCOUNT,2);
        $payment_BA3 = $this->getData($user_id,Paymenttype::BANK_ACCOUNT,3);
        $payment_PP = $this->getData($user_id,Paymenttype::PAYPAL);
        $payment_PO = $this->getData($user_id,Paymenttype::PAYONEER);
        $payment_SK = $this->getData($user_id,Paymenttype::SKRILL);
        $payment_OPM = $this->getData($user_id,Paymenttype::OTHER);

        if (count($data_payment) > 0) {
            $data["payments_group"] = intval($data_payment->group);
            $data["country"] = $data_payment->national;
            $data["text_class"] = $country != "VN" ? "active" : "";
        }
        // dd($payment_BA1,$payment_BA2,$payment_BA3,$payment_PP,$payment_PO,$payment_SK,$payment_OPM);
        return array(
            'payment_BA1' => $payment_BA1,
            'payment_BA2' => $payment_BA2,
            'payment_BA3' => $payment_BA3,
            'payment_PP' => $payment_PP,
            'payment_PO' => $payment_PO,
            'payment_SK' => $payment_SK,
            'payment_OPM' => $payment_OPM,
            'data' => $data
            );
    }
    
    public function getData($user_id, $payment_type, $national = null)
    {
        return PaymentInfo::getPayOfUser($user_id,$payment_type,$national)->first();
    }

    private function setActiveClass($payment)
    {
        if ($payment["class"] == "") return "active";
        return $payment["class"];
    }
}
