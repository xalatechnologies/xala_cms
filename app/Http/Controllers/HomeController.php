<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Models\Popup;
use App\Models\Tag;
use App\Models\TopicTag;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\App;
use App\Models\Banner;
use App\Mail\NotificationEmail;
use App\Models\Comment;
use App\Models\Contact;
use App\Models\Section;
use App\Models\Setting;
use App\Models\Topic;
use App\Models\TopicCategory;
use App\Models\TopicField;
use App\Models\User;
use App\Models\Webmail;
use App\Models\WebmasterSection;
use App\Models\WebmasterSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Mail;
use Redirect;
use Helper;
use Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        // check if script not installed yet and redirect to "/install"
        if (!File::exists(storage_path('/installed'))) {
            Redirect::to('/install')->send();
        }

        // check if website is closed or active
        $this->website_status();
    }

    private function set_language($lang): void
    {
        App::setLocale($lang);
        session(['locale' => $lang]);
    }

    public function seo($part1 = "", $part2 = "", $part3 = "", $part4 = "", $part5 = "", $part6 = "")
    {
        $languages_codes = Language::where("status", 1)->pluck("code")->toarray();
        if (in_array(strtolower($part1), $languages_codes)) {
            // part1 is lang
            $lang = strtolower($part1);
            $this->set_language($lang);
            $part1 = $part2;
            $part2 = $part3;
            $part3 = $part4;
            $part4 = $part5;
            $part5 = $part6;
            $part6 = "";
        } else {
            // get default lang
            $lang = config('smartend.default_language');
            $this->set_language($lang);
        }

        if ($part1 == "") {
            // home page
            $Popup = [];
            if (Helper::GeneralWebmasterSettings("popups_status")) {
                $Popup = Popup::where("show_in", 1)->where("status", 1)->first();
                if (empty($Popup)) {
                    $Popup = Popup::where("show_in", 0)->where("status", 1)->first();
                }
            }
            return view("frontEnd.home", ["page_type" => "home", "Popup" => $Popup]);
        }

        $WebmasterSection = WebmasterSection::where('status', 1)->where("seo_url_slug_" . $lang, $part1)->first();
        if (empty($WebmasterSection)) {
            $WebmasterSection = WebmasterSection::where('status', 1)->where("title_" . $lang, $part1)->first();
        }
        if (empty($WebmasterSection)) {
            // for direct landing pages like "website.com/about"
            $Topic = Topic::where('status', 1)->where("webmaster_id", 1)->where("seo_url_slug_" . $lang, $part1)->first();
            if (!empty($Topic)) {
                return $this->post_page($lang, $Topic);
            }
        }
        if (!empty($WebmasterSection)) {

            // if private redirect back to home
            if ($WebmasterSection->type == 4) {
                return redirect()->route("NotFound");
            }
            // if public form redirect to form
            if ($WebmasterSection->type == 6) {
                return $this->public_form($lang, $WebmasterSection);
            }

            if ($part2 != '') {
                $Section1 = Section::where('status', 1)->where("seo_url_slug_" . $lang, $part2)->first();
                if (!empty($Section1)) {
                    if ($part3 != '') {
                        $Section3 = Section::where('status', 1)->where("seo_url_slug_" . $lang, $part3)->first();
                        if (empty($Section3)) {
                            $Section3 = Section::where('status', 1)->where("title_" . $lang, Helper::SlugToString($part3))->first();
                        }
                        if (!empty($Section3)) {
                            if ($part4 != "") {
                                $Section4 = Section::where('status', 1)->where("seo_url_slug_" . $lang, $part4)->first();
                                if (empty($Section4)) {
                                    $Section4 = Section::where('status', 1)->where("title_" . $lang, Helper::SlugToString($part4))->first();
                                }
                                if (!empty($Section4)) {
                                    if ($part5 != "") {
                                        $Topic5 = Topic::where('status', 1)->where("seo_url_slug_" . $lang, $part5)->first();
                                        if (empty($Topic5)) {
                                            $Topic5 = Topic::where('status', 1)->where("title_" . $lang, Helper::SlugToString($part5))->first();
                                        }
                                        if (!empty($Topic5)) {
                                            return $this->post_page($lang, $Topic5);
                                        }
                                    } else {
                                        return $this->list_page($lang, $WebmasterSection, $Section4);
                                    }
                                } else {
                                    $Topic4 = Topic::where('status', 1)->where("seo_url_slug_" . $lang, $part4)->first();
                                    if (empty($Topic4)) {
                                        $Topic4 = Topic::where('status', 1)->where("title_" . $lang, Helper::SlugToString($part4))->first();
                                    }
                                    if (!empty($Topic4)) {
                                        return $this->post_page($lang, $Topic4);
                                    }
                                }
                            } else {
                                return $this->list_page($lang, $WebmasterSection, $Section3);
                            }
                        } else {
                            $Topic3 = Topic::where('status', 1)->where("seo_url_slug_" . $lang, $part3)->first();
                            if (empty($Topic3)) {
                                $Topic3 = Topic::where('status', 1)->where("title_" . $lang, Helper::SlugToString($part3))->first();
                            }
                            if (!empty($Topic3)) {
                                return $this->post_page($lang, $Topic3);
                            }
                        }
                    } else {
                        return $this->list_page($lang, $WebmasterSection, $Section1);
                    }
                } else {
                    $Topic1 = Topic::where('status', 1)->where("seo_url_slug_" . $lang, $part2)->first();
                    if (!empty($Topic1)) {
                        return $this->post_page($lang, $Topic1);
                    } else {
                        $Section2 = Section::where('status', 1)->where("title_" . $lang, Helper::SlugToString($part2))->first();
                        if (!empty($Section2)) {
                            return $this->list_page($lang, $WebmasterSection, $Section2);
                        } else {
                            $Topic2 = Topic::where('status', 1)->where("title_" . $lang, Helper::SlugToString($part2))->first();
                            if (!empty($Topic2)) {
                                return $this->post_page($lang, $Topic2);
                            }
                        }
                    }
                }
            }
            return $this->list_page($lang, $WebmasterSection);
        }
        return $this->page_404();
    }

    public function list_page($lang, $WebmasterSection = [], $Category = [])
    {
        if (!empty($WebmasterSection)) {

            $page_type = "section";
            $page_id = $WebmasterSection->id;
            $search_word = request()->input("search_word");
            if ($search_word != "") {
                // remove any symbol
                $search_word = preg_replace('/[^\p{L}\p{N}\s]/u', '', $search_word);
            }

            // categories list
            if ($search_word != "" && $WebmasterSection->id == 1) {
                // general search
                $CategoriesList = [];
            } else {
                $CategoriesList = Section::where('webmaster_id', '=', $WebmasterSection->id)->where('father_id', '=', '0')->where('status', 1)->orderby('webmaster_id', 'asc')->orderby('row_no', 'asc')->get();
            }

            $category_topics = [];
            $TopicsList = [];
            $MostViewedTopics = [];
            if ($WebmasterSection->type == 7) {
                // search in topics by one field
                $field_id = 0;
                foreach ($WebmasterSection->customFields->whereIn("type", [0, 2]) as $customField) {
                    if (!empty($customField)) {
                        $field_id = $customField->id;
                        break;
                    }
                }
                $FValue = \request()->input('q');
                $FoundTopic = [];
                if ($field_id > 0 && $FValue != "") {
                    $FoundTopic = Topic::where([['webmaster_id', '=', $WebmasterSection->id], ['status',
                        1], ['expire_date', '>=', date("Y-m-d")], ['expire_date', '<>', null]])->orWhere([['webmaster_id', '=', $WebmasterSection->id], ['status', 1], ['expire_date', null]]);

                    $topics_ids = TopicField::select("topic_id")->where("field_id", $field_id)->where("field_value", $FValue);
                    $FoundTopic = $FoundTopic->wherein("id", $topics_ids);
                    $FoundTopic = $FoundTopic->first();
                }
                if (!empty($FoundTopic)) {
                    return $this->privateTopic($lang, $FoundTopic);
                }
            }
            if ($WebmasterSection->type != 8 && $WebmasterSection->type != 7) {
                // All other sections
                if (!empty($Category)) {
                    // update visits
                    $Category->visits = $Category->visits + 1;
                    $Category->timestamps = false;
                    $Category->save();
                }

                // topics list
                if ($search_word != "" && $WebmasterSection->id == 1) {
                    //general search
                    $TopicsList = Topic::where(function ($query) {
                        $query->where([['status', 1], ['expire_date', '>=', date("Y-m-d")], ['expire_date', '<>', null]])->orWhere([['status', 1], ['expire_date', null]]);
                    });
                } else {
                    $TopicsList = Topic::where(function ($query) use ($WebmasterSection) {
                        $query->where([['webmaster_id', '=', $WebmasterSection->id], ['status',
                            1], ['expire_date', '>=', date("Y-m-d")], ['expire_date', '<>', null]])->orWhere([['webmaster_id', '=', $WebmasterSection->id], ['status', 1], ['expire_date', null]]);
                    });
                }

                // search word
                if ($search_word != "") {
                    $topics_ids = TopicField::select("topic_id")->where("field_value", 'like', '%' . $search_word . '%');

                    $TopicsList = $TopicsList->where(function ($query) use ($search_word, $topics_ids) {
                        $query->where('title_' . Helper::currentLanguage()->code, 'like', '%' . $search_word . '%')
                            ->orwhere('seo_title_' . Helper::currentLanguage()->code, 'like', '%' . $search_word . '%')
                            ->orwhere('details_' . Helper::currentLanguage()->code, 'like', '%' . $search_word . '%')
                            ->orwherein("id", $topics_ids);
                    });
                }

                // filter by category
                if (!empty($Category)) {
                    $page_type = "category";
                    $page_id = $Category->id;
                    $cat_ids = [];
                    $cat_ids[] = $Category->id;
                    $SubCategories = Section::where("status", 1)->where("father_id", $Category->id)->pluck("id")->toarray();
                    foreach ($SubCategories as $SubCategory) {
                        $cat_ids[] = $SubCategory;
                        $SubCategories2 = Section::where("status", 1)->where("father_id", $SubCategory)->pluck("id")->toarray();
                        foreach ($SubCategories2 as $SubCategory2) {
                            $cat_ids[] = $SubCategory2;
                        }
                    }

                    // get this category topic ids
                    $category_topics = TopicCategory::whereIn('section_id', $cat_ids)->pluck("topic_id")->toarray();

                    $TopicsList = $TopicsList->whereIn('id', $category_topics);
                }

                // for search by custom fields
                if ($WebmasterSection->id > 1) {
                    foreach ($WebmasterSection->customFields as $customField) {
                        if ($customField->in_search) {
                            $FField_D = \request()->input('customField_' . $customField->id);
                            if ($FField_D != "") {
                                if ($customField->type == 5) {
                                    $FField_D = Helper::dateForDB($FField_D, 1);
                                } elseif ($customField->type == 4) {
                                    $FField_D = Helper::dateForDB($FField_D);
                                }

                                if ($customField->type == 7) {
                                    $topics_ids = TopicField::select("topic_id")->where("field_id", $customField->id)->whereRaw("FIND_IN_SET(" . $FField_D . ",REPLACE(`field_value`, ' ', ''))");
                                } else if ($customField->type == 6 || $customField->type == 13) {
                                    $topics_ids = TopicField::select("topic_id")->where("field_id", $customField->id)->where("field_value", $FField_D);
                                } else {
                                    $topics_ids = TopicField::select("topic_id")->where("field_id", $customField->id)->where("field_value", 'like', '%' . $FField_D . '%');
                                }

                                $TopicsList = $TopicsList->wherein("id", $topics_ids);
                            }
                        }
                    }
                }
                $MostViewedTopics = clone $TopicsList;

                // order and paginate
                $TopicsList = $TopicsList->orderby('date', config('smartend.frontend_topics_order'))->orderby('id', config('smartend.frontend_topics_order'))->paginate(config('smartend.frontend_pagination'));

                // Get Most Viewed Topics
                $MostViewedTopics = $MostViewedTopics->orderby('visits', 'desc')->limit(3)->get();
            }

            $statics = [];

            // return view
            $view = "topics";
            if ($WebmasterSection->type == 9) {
                $view = "docs";
            } elseif ($WebmasterSection->type == 8) {
                $view = "faq";
            } elseif ($WebmasterSection->type == 7) {
                $view = "search";
            } elseif ($WebmasterSection->type == 5) {
                $view = "table";
                // statics
                foreach ($WebmasterSection->customFields as $customField) {
                    if ($customField->in_statics && ($customField->type == 6 || $customField->type == 7)) {
                        $cf_details_var = "details_" . @Helper::currentLanguage()->code;
                        $cf_details_var2 = "details_" . env('DEFAULT_LANGUAGE');
                        if ($customField->$cf_details_var != "") {
                            $cf_details = $customField->$cf_details_var;
                        } else {
                            $cf_details = $customField->$cf_details_var2;
                        }
                        $cf_details_lines = preg_split('/\r\n|[\r\n]/', $cf_details);
                        $line_num = 1;
                        $statics_row = [];
                        foreach ($cf_details_lines as $cf_details_line) {
                            if ($customField->type == 6) {
                                $tids = TopicField::select("topic_id")->where("field_id", $customField->id)->where("field_value", $line_num);
                            } else {
                                $tids = TopicField::select("topic_id")->where("field_id", $customField->id)->where("field_value", 'like', '%' . $line_num . '%');
                            }
                            $Topics_count = Topic::where('webmaster_id', '=', $WebmasterSection->id)->wherein('id', $tids)->count();
                            $statics_row[$line_num] = $Topics_count;
                            $line_num++;
                        }
                        $statics[$customField->id] = $statics_row;
                    }
                }
            }

            // page meta tags
            $meta_tags = $this->get_meta_tags((!empty($Category)) ? $Category : $WebmasterSection, $lang);

            // count topics by Category
            $TopicsCountPerCat = $this->topics_count_per_category($WebmasterSection->id);

            // get popup
            $Popup = [];
            if (Helper::GeneralWebmasterSettings("popups_status")) {
                if (!empty($Category)) {
                    if ($Category->popup_id > 0) {
                        $Popup = Popup::where("status", 1)->find($Category->popup_id);
                    }
                }
                if (empty($Popup)) {
                    if ($WebmasterSection->popup_id > 0) {
                        $Popup = Popup::where("status", 1)->find($WebmasterSection->popup_id);
                    }
                }
                if (empty($Popup)) {
                    $Popup = Popup::where("show_in", 0)->where("status", 1)->first();
                }
            }

            return view('frontEnd.' . $view, [
                "PageTitle" => @$meta_tags["title"],
                "PageDescription" => @$meta_tags["desc"],
                "PageKeywords" => @$meta_tags["keywords"],
                "WebmasterSection" => $WebmasterSection,
                "Categories" => $CategoriesList,
                "Topics" => $TopicsList,
                "CurrentCategory" => $Category,
                "MostViewedTopics" => $MostViewedTopics,
                "TopicsCountPerCat" => $TopicsCountPerCat,
                "statics" => $statics,
                "page_type" => $page_type,
                "page_id" => $page_id,
                "search_word" => $search_word,
                "Popup" => $Popup,
            ]);
        }
        return $this->page_404();
    }

    public function post_page($lang, $Topic = [], $private_topic_view = 0)
    {
        if (!empty($Topic)) {
            $WebmasterSection = $Topic->webmasterSection;
            if (!empty($WebmasterSection)) {

                // if private redirect back to home
                if (!$private_topic_view) {
                    if ($WebmasterSection->type == 4 || $WebmasterSection->type == 7) {
                        return redirect()->route("NotFound");
                    }
                }
                // if public form redirect to form
                if ($WebmasterSection->type == 6) {
                    return $this->public_form($lang, $WebmasterSection);
                }

                // update visits
                $Topic->visits = $Topic->visits + 1;
                $Topic->timestamps = false;
                $Topic->save();

                // categories list
                $CategoriesList = Section::where('webmaster_id', '=', $WebmasterSection->id)->where('father_id', '=', '0')->where('status', 1)->orderby('webmaster_id', 'asc')->orderby('row_no', 'asc')->get();

                $Category = [];
                $TopicCategory = TopicCategory::where('topic_id', $Topic->id)->first();
                if (!empty($TopicCategory)) {
                    $Category = Section::find($TopicCategory->section_id);
                }

                $category_topics = [];
                if (!empty($Category)) {
                    // get this category topic ids
                    $category_topics = TopicCategory::where('section_id', $Category->id)->pluck("topic_id")->toarray();
                }

                // most viewed topics list
                $MostViewedTopics = Topic::where([['webmaster_id', '=', $WebmasterSection->id], ['status',
                    1], ['expire_date', '>=', date("Y-m-d")], ['expire_date', '<>', null]])->orWhere([['webmaster_id', '=', $WebmasterSection->id], ['status', 1], ['expire_date', null]]);

                // filter by category
                if (!empty($Category)) {
                    $MostViewedTopics = $MostViewedTopics->whereIn('id', $category_topics);
                }

                // Get Most Viewed Topics
                $MostViewedTopics = $MostViewedTopics->orderby('visits', 'desc')->limit(3)->get();

                // page meta tags
                $meta_tags = $this->get_meta_tags($Topic, $lang);


                // return view
                $view = "topic";
                if ($Topic->id == Helper::GeneralWebmasterSettings("contact_page_id")) {
                    $view = "contact";
                }

                // count topics by Category
                $TopicsCountPerCat = $this->topics_count_per_category($WebmasterSection->id);

                // overwrite page to custom code
                if (@File::exists('core/resources/views/frontEnd/custom/' . $Topic->id . ".blade.php")) {
                    $view = "custom." . $Topic->id;
                }

                // get popup
                $Popup = [];
                if (Helper::GeneralWebmasterSettings("popups_status")) {
                    if ($Topic->popup_id > 0) {
                        $Popup = Popup::where("status", 1)->find($Topic->popup_id);
                    }
                    if (empty($Popup) && !empty($Category)) {
                        if ($Category->popup_id > 0) {
                            $Popup = Popup::where("status", 1)->find($Category->popup_id);
                        }
                    }
                    if (empty($Popup)) {
                        if ($WebmasterSection->popup_id > 0) {
                            $Popup = Popup::where("status", 1)->find($WebmasterSection->popup_id);
                        }
                    }
                    if (empty($Popup)) {
                        $Popup = Popup::where("show_in", 0)->where("status", 1)->first();
                    }
                }

                return view('frontEnd.' . $view, [
                    "PageTitle" => @$meta_tags["title"],
                    "PageDescription" => @$meta_tags["desc"],
                    "PageKeywords" => @$meta_tags["keywords"],
                    "WebmasterSection" => $WebmasterSection,
                    "Categories" => $CategoriesList,
                    "Topic" => $Topic,
                    "CurrentCategory" => $Category,
                    "MostViewedTopics" => $MostViewedTopics,
                    "TopicsCountPerCat" => $TopicsCountPerCat,
                    "page_type" => "topic",
                    "page_id" => $Topic->id,
                    "Popup" => $Popup
                ]);
            }
        }
        return $this->page_404();
    }

    public function tag($tag_slug = "")
    {
        $lang = \request()->input('lang');
        if ($lang != "") {
            $languages_codes = Language::where("status", 1)->pluck("code")->toarray();
            if (in_array(strtolower($lang), $languages_codes)) {
                // part1 is lang
                $lang = strtolower($lang);
                $this->set_language($lang);
            } else {
                return $this->page_404();
            }
        }

        if ($tag_slug != "") {
            $DBTag = Tag::where("seo_url", $tag_slug)->first();
            if (!empty($DBTag)) {
                $TopicIds = TopicTag::where("tag_id", $DBTag->id)->pluck("topic_id")->toArray();
                $TopicsList = Topic::where(function ($query) {
                    $query->where([['status', 1], ['expire_date', '>=', date("Y-m-d")], ['expire_date', '<>', null]])->orWhere([['status', 1], ['expire_date', null]]);
                });

                $TopicsList = $TopicsList->wherein("id", $TopicIds);
                // order and paginate
                $TopicsList = $TopicsList->orderby('date', config('smartend.frontend_topics_order'))->orderby('id', config('smartend.frontend_topics_order'))->paginate(config('smartend.frontend_pagination'));

                $lang = @Helper::currentLanguage()->code;

                return view('frontEnd.topics', [
                    "PageTitle" => @$DBTag->title,
                    "PageDescription" => (@$DBTag->details != "") ? @$DBTag->details : Helper::GeneralSiteSettings("site_desc_" . $lang),
                    "PageKeywords" => Helper::GeneralSiteSettings("site_keywords_" . $lang),
                    "WebmasterSection" => [],
                    "Categories" => [],
                    "Topics" => $TopicsList,
                    "CurrentCategory" => [],
                    "MostViewedTopics" => [],
                    "TopicsCountPerCat" => [],
                    "statics" => [],
                    "page_type" => "tag",
                    "page_id" => @$DBTag->id,
                    "search_word" => "",
                    "DBTag" => $DBTag
                ]);
            }
        }
        return $this->page_404();
    }

    public function public_form($lang, $WebmasterSection)
    {
        if (!empty($WebmasterSection)) {
            // page meta tags
            $meta_tags = $this->get_meta_tags($WebmasterSection, $lang);

            return view('frontEnd.form_page', [
                "PageTitle" => @$meta_tags["title"],
                "PageDescription" => @$meta_tags["desc"],
                "PageKeywords" => @$meta_tags["keywords"],
                "WebmasterSection" => $WebmasterSection,
                "page_type" => "section",
                "page_id" => $WebmasterSection->id
            ]);
        }
        return $this->page_404();
    }

    public function contact_submit(Request $request)
    {
        $validation = [
            'contact_name' => 'required',
            'contact_email' => 'required|email',
            'contact_phone' => 'required',
            'contact_subject' => 'required',
            'contact_message' => 'required'
        ];
        if (config('smartend.nocaptcha_status')) {
            $validation['g-recaptcha-response'] = 'required|captcha';
        }
        $validator = Validator::make($request->all(), $validation);
        if ($validator->passes()) {

            $site_title_var = "site_title_" . @Helper::currentLanguage()->code;
            $site_email = @Helper::GeneralSiteSettings("site_webmails");

            $Webmail = new Webmail;
            $Webmail->cat_id = 0;
            $Webmail->group_id = null;
            $Webmail->title = strip_tags($request->contact_subject);
            $Webmail->details = strip_tags($request->contact_message);
            $Webmail->date = date("Y-m-d H:i:s");
            $Webmail->from_email = strip_tags($request->contact_email);
            $Webmail->from_name = strip_tags($request->contact_name);
            $Webmail->from_phone = @str_replace("+", "", strip_tags($request->contact_phone_full));
            $Webmail->to_email = $site_email;
            $Webmail->to_name = @Helper::GeneralSiteSettings($site_title_var);
            $Webmail->status = 0;
            $Webmail->flag = 0;
            $Webmail->save();

            // subscribe to newsletter if active
            Helper::news_letter_subscribe($Webmail->from_email, @explode(" ", $Webmail->from_name)[0], @explode(" ", $Webmail->from_name)[1]);

            // SEND Notification Email
            if (@Helper::GeneralSiteSettings('notify_messages_status')) {
                try {
                    $recipient = explode(",", str_replace(" ", "", $site_email));
                    $message_details = __('frontend.name') . ": " . strip_tags($request->contact_name) . "<hr>" . __('frontend.phone') . ": " . strip_tags($request->contact_phone) . "<hr>" . __('frontend.email') . ": " . strip_tags($request->contact_email) . "<hr>" . __('frontend.message') . ":<br>" . nl2br(strip_tags($request->contact_message));

                    Mail::to($recipient)->send(new NotificationEmail(
                        [
                            "title" => strip_tags($request->contact_subject),
                            "details" => $message_details,
                            "from_email" => strip_tags($request->contact_email),
                            "from_name" => strip_tags($request->contact_name)
                        ]
                    ));
                } catch (\Exception $e) {

                }
            }

            return response()->json(['stat' => 'success', 'msg' => __('frontend.youMessageSent')]);
        }
        return response()->json(['stat' => 'error', 'msg' => __('frontend.youMessageNotSent')]);
    }

    public function subscribe_submit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subscribe_email' => 'required|email'
        ]);
        if ($validator->passes()) {
            // General Webmaster Settings
            $WebmasterSettings = WebmasterSetting::find(1);

            $Contacts = Contact::where('email', strip_tags($request->subscribe_email))->get();
            if (count($Contacts) > 0) {
                return response()->json(['stat' => 'error', 'msg' => __('frontend.subscribeToOurNewsletterError')]);
            } else {
                $Contact = new Contact;
                $Contact->group_id = $WebmasterSettings->newsletter_contacts_group;
                $Contact->first_name = @explode("@", strip_tags($request->subscribe_email))[0];
                $Contact->email = strip_tags($request->subscribe_email);
                $Contact->status = 1;
                $Contact->save();

                // subscribe to newsletter if active
                Helper::news_letter_subscribe($Contact->email, $Contact->first_name, "");

                return response()->json(['stat' => 'success', 'msg' => __('frontend.subscribeToOurNewsletterDone')]);
            }
        }
        return response()->json(['stat' => 'error', 'msg' => __('frontend.enterYourEmail')]);
    }

    public function comment_submit(Request $request)
    {
        $validation = [
            'comment_name' => 'required',
            'comment_message' => 'required',
            'topic_id' => 'required',
            'comment_email' => 'required|email'
        ];
        if (config('smartend.nocaptcha_status')) {
            $validation['g-recaptcha-response'] = 'required|captcha';
        }
        $validator = Validator::make($request->all(), $validation);
        if ($validator->passes()) {

            // Topic details
            $Topic = Topic::where('status', 1)->find($request->topic_id);
            if (!empty($Topic)) {
                $next_nor_no = Comment::where('topic_id', '=', $request->topic_id)->max('row_no');
                if ($next_nor_no < 1) {
                    $next_nor_no = 1;
                } else {
                    $next_nor_no++;
                }

                $Comment = new Comment;
                $Comment->row_no = $next_nor_no;
                $Comment->name = strip_tags($request->comment_name);
                $Comment->email = strip_tags($request->comment_email);
                $Comment->comment = strip_tags($request->comment_message);
                $Comment->topic_id = strip_tags($request->topic_id);
                $Comment->date = date("Y-m-d H:i:s");
                $Comment->status = (@Helper::GeneralWebmasterSettings('new_comments_status')) ? 1 : 0;
                $Comment->save();

                // subscribe to newsletter if active
                Helper::news_letter_subscribe($Comment->email, @explode(" ", $Comment->name)[0], @explode(" ", $Comment->name)[1]);

                $site_email = @Helper::GeneralSiteSettings("site_webmails");

                $tpc_title_var = "title_" . @Helper::currentLanguage()->code;
                $tpc_title = $Topic->$tpc_title_var;

                // SEND Notification Email
                if (@Helper::GeneralSiteSettings('notify_comments_status')) {
                    try {
                        $recipient = explode(",", str_replace(" ", "", $site_email));
                        $message_details = __('frontend.name') . ": " . strip_tags($request->comment_name) . "<hr>" . __('frontend.email') . ": " . strip_tags($request->comment_email) . "<hr>" . __('frontend.comment') . ":<br>" . nl2br(strip_tags($request->comment_message));

                        Mail::to($recipient)->send(new NotificationEmail(
                            [
                                "title" => "Comment: " . $tpc_title,
                                "details" => $message_details,
                                "from_email" => strip_tags($request->comment_email),
                                "from_name" => strip_tags($request->comment_name)
                            ]
                        ));
                    } catch (\Exception $e) {

                    }
                }

                return response()->json(['stat' => 'success', 'msg' => __('frontend.youCommentSent')]);
            }
        }
        return response()->json(['stat' => 'error', 'msg' => __('frontend.youMessageNotSent')]);
    }

    public function order_submit(Request $request)
    {
        $validation = [
            'order_name' => 'required',
            'order_phone' => 'required',
            'topic_id' => 'required',
            'order_email' => 'required|email',
        ];
        if (config('smartend.nocaptcha_status')) {
            $validation['g-recaptcha-response'] = 'required|captcha';
        }
        $validator = Validator::make($request->all(), $validation);
        if ($validator->passes()) {

            $site_title_var = "site_title_" . @Helper::currentLanguage()->code;
            $site_email = @Helper::GeneralSiteSettings("site_webmails");

            $Topic = Topic::where('status', 1)->find($request->topic_id);
            if (!empty($Topic)) {
                $tpc_title_var = "title_" . @Helper::currentLanguage()->code;
                $tpc_title = $Topic->$tpc_title_var;

                $Webmail = new Webmail;
                $Webmail->cat_id = 0;
                $Webmail->group_id = 2;
                $Webmail->contact_id = null;
                $Webmail->father_id = null;
                $Webmail->title = "ORDER: " . $Topic->$tpc_title_var;
                $Webmail->details = strip_tags($request->order_message);
                $Webmail->date = date("Y-m-d H:i:s");
                $Webmail->from_email = strip_tags($request->order_email);
                $Webmail->from_name = strip_tags($request->order_name);
                $Webmail->from_phone = @str_replace("+", "", strip_tags($request->order_phone_full));
                $Webmail->to_email = $site_email;
                $Webmail->to_name = @Helper::GeneralSiteSettings($site_title_var);
                $Webmail->status = 0;
                $Webmail->flag = 0;
                $Webmail->save();


                // subscribe to newsletter if active
                Helper::news_letter_subscribe($Webmail->from_email, @explode(" ", $Webmail->from_name)[0], @explode(" ", $Webmail->from_name)[1]);

                // SEND Notification Email
                if (@Helper::GeneralSiteSettings('notify_orders_status')) {
                    try {
                        $recipient = explode(",", str_replace(" ", "", $site_email));
                        $message_details = __('frontend.name') . ": " . strip_tags($request->order_name) . "<hr>" . __('frontend.phone') . ": " . strip_tags($request->order_phone) . "<hr>" . __('frontend.email') . ": " . strip_tags($request->order_email) . "<hr>" . __('frontend.notes') . ":<br>" . nl2br(strip_tags($request->order_message));

                        Mail::to($recipient)->send(new NotificationEmail(
                            [
                                "title" => "Order: " . $tpc_title,
                                "details" => $message_details,
                                "from_email" => strip_tags($request->order_email),
                                "from_name" => strip_tags($request->order_name)
                            ]
                        ));
                    } catch (\Exception $e) {

                    }
                }

                return response()->json(['stat' => 'success', 'msg' => __('frontend.youOrderSent')]);
            }
        }
        return response()->json(['stat' => 'error', 'msg' => __('frontend.youMessageNotSent')]);
    }

    public function form_submit(Request $request)
    {

        // validate required  custom fields
        $validate_inputs = [
            'WebmasterSectionId' => 'required',
            'photo_file' => 'image',
            'audio_file' => 'mimes:mpga,wav,mp3', // mpga = mp3
            'video_file' => 'mimes:mp4,ogv,webm'
        ];

        if (config('smartend.nocaptcha_status')) {
            $validate_inputs['g-recaptcha-response'] = 'required|captcha';
        }

        $WebmasterSection = WebmasterSection::find(decrypt($request->WebmasterSectionId));
        if (!empty($WebmasterSection)) {
            $CustomFields = $WebmasterSection->customFields;
            if (count($CustomFields) > 0) {
                foreach ($CustomFields->whereNotIn("type",[99])->where("required", 1) as $customField) {
                    // check permission
                    $add_permission_groups = [];
                    if ($customField->add_permission_groups != "") {
                        $add_permission_groups = explode(",", $customField->add_permission_groups);
                    }
                    if (in_array(0, $add_permission_groups) || $customField->add_permission_groups == "") {
                        $validate_inputs["customField_" . $customField->id] = 'required';
                    }
                }
            }

            if (count($validate_inputs) > 0) {
                $this->validate($request, $validate_inputs);
            }

            $webmasterId = $WebmasterSection->id;
            $uploadPath = "uploads/topics/";
            $next_nor_no = Topic::where('webmaster_id', '=', $webmasterId)->max('row_no');
            if ($next_nor_no < 1) {
                $next_nor_no = 1;
            } else {
                $next_nor_no++;
            }

            // Start of Upload Files
            $formFileName = "photo_file";
            $fileFinalName = "";
            if ($request->$formFileName != "") {
                $fileFinalName = time() . rand(1111,
                        9999) . '.' . $request->file($formFileName)->getClientOriginalExtension();
                $request->file($formFileName)->move($uploadPath, $fileFinalName);
            }


            $formFileName = "attach_file";
            $attachFileFinalName = "";
            if ($request->$formFileName != "") {
                $attachFileFinalName = time() . rand(1111,
                        9999) . '.' . $request->file($formFileName)->getClientOriginalExtension();
                $request->file($formFileName)->move($uploadPath, $attachFileFinalName);
            }

            // End of Upload Files


            // create new topic
            $Topic = new Topic;

            // Save topic details
            $Topic->row_no = $next_nor_no;
            foreach (Helper::languagesList() as $ActiveLanguage) {
                if ($ActiveLanguage->box_status) {
                    $Topic->{"title_" . $ActiveLanguage->code} = strip_tags($request->title);
                    $Topic->{"details_" . $ActiveLanguage->code} = strip_tags($request->details);

                    // meta info
                    $Topic->{"seo_title_" . $ActiveLanguage->code} = strip_tags($request->title);
                    $Topic->{"seo_description_" . $ActiveLanguage->code} = mb_substr(strip_tags(stripslashes($request->details)), 0, 165, 'UTF-8');
                    $Topic->{"seo_url_slug_" . $ActiveLanguage->code} = Helper::URLSlug(strip_tags($request->title), "topic", 0);

                }
            }
            $Topic->date = Helper::dateForDB($request->date);
            if (@$request->expire_date != "") {
                $Topic->expire_date = Helper::dateForDB($request->expire_date);
            }
            if ($fileFinalName != "") {
                $Topic->photo_file = $fileFinalName;
            }
            if ($attachFileFinalName != "") {
                $Topic->attach_file = $attachFileFinalName;
            }
            $Topic->icon = $request->icon;
            $Topic->video_type = $request->video_type;
            $Topic->webmaster_id = $webmasterId;
            $Topic->created_by = @Auth::user()->id;
            $Topic->visits = 0;
            $Topic->section_id = 0;
            $Topic->status = 0;
            $Topic->topic_id = @$request->TopicID;
            $Topic->save();

            if ($request->section_id > 0) {
                // Save categories
                $TopicCategory = new TopicCategory;
                $TopicCategory->topic_id = $Topic->id;
                $TopicCategory->section_id = $request->section_id;
                $TopicCategory->save();
            }

            // Save additional Fields
            if (count($CustomFields) > 0) {
                foreach ($CustomFields as $customField) {
                    $field_value_var = "customField_" . $customField->id;

                    if ($request->$field_value_var != "") {
                        if ($customField->type == 8 || $customField->type == 9 || $customField->type == 10) {
                            // upload file
                            if ($request->$field_value_var != "") {
                                $uploadedFileFinalName = time() . rand(1111,
                                        9999) . '.' . $request->file($field_value_var)->getClientOriginalExtension();
                                $request->file($field_value_var)->move($uploadPath, $uploadedFileFinalName);
                                $field_value = $uploadedFileFinalName;
                            }
                        } elseif ($customField->type == 15) {
                            $field_value = @str_replace("+", "", $request->{$field_value_var . "_phone_full"});
                        } elseif ($customField->type == 14) {
                            $field_value = ($request->$field_value_var == 1) ? 1 : 0;
                        } elseif ($customField->type == 5) {
                            if ($request->$field_value_var != "") {
                                $field_value = Helper::dateForDB($request->$field_value_var, 1);
                            }
                        } elseif ($customField->type == 4) {
                            if ($request->$field_value_var != "") {
                                $field_value = Helper::dateForDB($request->$field_value_var);
                            }
                        } elseif ($customField->type == 7) {
                            // if multi check
                            $field_value = implode(", ", $request->$field_value_var);
                        } else {
                            $field_value = strip_tags($request->$field_value_var);
                        }
                        $TopicField = new TopicField;
                        $TopicField->topic_id = $Topic->id;
                        $TopicField->field_id = $customField->id;
                        $TopicField->field_value = $field_value;
                        $TopicField->save();


                        // subscribe to newsletter if active
                        if ($customField->type == 3) {
                            Helper::news_letter_subscribe($field_value, @explode("@", $field_value)[0], @explode("@", $field_value)[1]);
                        }

                    }
                }
            }

            // SEND Notification Email
            $this->send_notification($WebmasterSection, $Topic, "New");


            return redirect()->back()->with('doneMessage', __('backend.submitDone'));
        }
        return redirect()->action('HomeController@HomePage');
    }

    public function send_notification($WebmasterSection, $Topic, $Case = "")
    {
        try {
            $site_email = @Helper::GeneralSiteSettings("site_webmails");
            $recipient = explode(",", str_replace(" ", "", $site_email));

            $no_reply_email = @Helper::GeneralWebmasterSettings("mail_no_replay");
            $site_title_var = "site_title_" . @Helper::currentLanguage()->code;
            $site_title = @Helper::GeneralSiteSettings($site_title_var);

            $tpc_title = @$Topic->{'title_' . @Helper::currentLanguage()->code};

            $FromTopicTitle = "";
            if (@$Topic->topic_id > 0) {
                $FromTopic = Topic::find(@$Topic->topic_id);
                $FromTopicTitle = @$FromTopic->{'title_' . @Helper::currentLanguage()->code};
            }

            $fields_details = "";
            try {
                if (count($Topic->webmasterSection->customFields) > 0) {
                    $fields_details .= "<hr>";
                    $cf_title_var = "title_" . @Helper::currentLanguage()->code;
                    $cf_title_var2 = "title_" . config('smartend.default_language');
                    $i = 0;
                    foreach ($Topic->webmasterSection->customFields as $customField) {
                        if ($customField->$cf_title_var != "") {
                            $cf_title = $customField->$cf_title_var;
                        } else {
                            $cf_title = $customField->$cf_title_var2;
                        }

                        $cf_saved_val = "";
                        $cf_saved_val_array = array();
                        if (count($Topic->fields) > 0) {
                            foreach ($Topic->fields as $t_field) {
                                if ($t_field->field_id == $customField->id) {
                                    if ($customField->type == 7) {
                                        // if multi check
                                        $cf_saved_val_array = explode(", ", $t_field->field_value);
                                    } else {
                                        $cf_saved_val = $t_field->field_value;
                                    }
                                }
                            }
                        }
                        if (($cf_saved_val != "" || count($cf_saved_val_array) > 0) && ($customField->lang_code == "all" || $customField->lang_code == @Helper::currentLanguage()->code)) {
                            if ($customField->type == 12) {
                                //
                            } elseif ($customField->type == 11) {
                                //
                            } elseif ($customField->type == 10) {
                                //
                            } elseif ($customField->type == 9) {
                                //
                            } elseif ($customField->type == 8) {
                                //
                            } elseif ($customField->type == 7) {
                                $cf_details_var = "details_" . @Helper::currentLanguage()->code;
                                $cf_details_var2 = "details_" . config('smartend.default_language');
                                if ($customField->$cf_details_var != "") {
                                    $cf_details = $customField->$cf_details_var;
                                } else {
                                    $cf_details = $customField->$cf_details_var2;
                                }
                                $cf_details_lines = preg_split('/\r\n|[\r\n]/', $cf_details);
                                $line_num = 1;

                                $fields_details .= "<div><strong>" . $cf_title . " : </strong>";
                                foreach ($cf_details_lines as $cf_details_line) {
                                    if (in_array($line_num, $cf_saved_val_array)) {
                                        $fields_details .= "<div>" . $cf_details_line . "</div>";
                                    }
                                    $line_num++;
                                }
                                $fields_details .= "</div>";
                            } elseif ($customField->type == 6) {
                                $cf_details_var = "details_" . @Helper::currentLanguage()->code;
                                $cf_details_var2 = "details_" . config('smartend.default_language');
                                if ($customField->$cf_details_var != "") {
                                    $cf_details = $customField->$cf_details_var;
                                } else {
                                    $cf_details = $customField->$cf_details_var2;
                                }
                                $cf_details_lines = preg_split('/\r\n|[\r\n]/', $cf_details);
                                $line_num = 1;
                                $fields_details .= "<div><strong>" . $cf_title . " : </strong>";
                                foreach ($cf_details_lines as $cf_details_line) {
                                    if ($line_num == $cf_saved_val) {
                                        $fields_details .= "<div>" . $cf_details_line . "</div>";
                                    }
                                    $line_num++;
                                }
                                $fields_details .= "</div>";
                            } elseif ($customField->type == 5) {
                                $fields_details .= "<div><strong>" . $cf_title . " : </strong>" . Helper::dateForDB($cf_saved_val, 1) . "</div>";
                            } elseif ($customField->type == 4) {
                                $fields_details .= "<div><strong>" . $cf_title . " : </strong>" . Helper::dateForDB($cf_saved_val) . "</div>";
                            } else {
                                if ($tpc_title == "") {
                                    $tpc_title = $cf_saved_val;
                                }
                                $fields_details .= "<div><strong>" . $cf_title . " : </strong>" . $cf_saved_val . "</div>";
                            }
                        }
                        $i++;
                    }
                }
            } catch (\Exception $e) {

            }

            $message_details = "<h3>" . $tpc_title . "</h3>" . $FromTopicTitle . $fields_details . "<hr><a href='" . route("topicsEdit", [@$WebmasterSection->id, @$Topic->id]) . "'>View All Details</a>";

            Mail::to($recipient)->send(new NotificationEmail(
                [
                    "title" => $Case . ": " . (($FromTopicTitle != "") ? $FromTopicTitle : $tpc_title),
                    "details" => $message_details,
                    "from_email" => $no_reply_email,
                    "from_name" => $site_title
                ]
            ));
        } catch (\Exception $e) {

        }
    }

    public function website_status()
    {
        // Check the website Status
        if (!Auth::check()) {
            $site_status = Helper::GeneralSiteSettings("site_status");
            if ($site_status == 0) {
                echo view("frontEnd.closed", ["close_message" => Helper::GeneralSiteSettings("close_msg")])->render();
                exit();
            }
        }
    }

    public function page_404($lang = "")
    {
        if ($lang != "") {
            $languages_codes = Language::where("status", 1)->pluck("code")->toarray();
            if (in_array(strtolower($lang), $languages_codes)) {
                $lang = strtolower($lang);
                $this->set_language($lang);
            }
        }

        // uncomment the next line if you want to redirect to the homepage instead of 404
        return redirect()->route("frontendRoute", ["part1" => $lang]);

        // uncomment the next line if you want to show 404 page and comment the previous line of homepage
        //return view('errors.404', ["PageTitle" => "404", "page_type" => "404"]);
    }

    private function get_meta_tags($Record = [], $lang = ""): array
    {
        try {
            if ($lang == "") {
                $lang = @Helper::currentLanguage()->code;
            }
            if (!empty($Record)) {
                $PageTitle = $Record->{"seo_title_" . $lang};
                $PageDescription = $Record->{"seo_description_" . $lang};
                $PageKeywords = $Record->{"seo_keywords_" . $lang};
                if ($PageTitle == "") {
                    $PageTitle = @$Record->{"title_" . $lang};
                }
            }
            if ($PageTitle == "") {
                $PageTitle = Helper::GeneralSiteSettings("title_" . $lang);
            }
            if ($PageDescription == "") {
                $PageDescription = Helper::GeneralSiteSettings("site_desc_" . $lang);
            }
            if ($PageKeywords == "") {
                $PageKeywords = Helper::GeneralSiteSettings("site_keywords_" . $lang);
            }
        } catch (\Exception $e) {
            $PageTitle = "";
            $PageDescription = "";
            $PageKeywords = "";
        }
        return [
            "title" => $PageTitle,
            "desc" => $PageDescription,
            "keywords" => $PageKeywords
        ];
    }

    private function privateTopic($lang, $privateTopic)
    {
        if ($lang != "") {
            $languages_codes = Language::where("status", 1)->pluck("code")->toarray();
            if (in_array(strtolower($lang), $languages_codes)) {
                $lang = strtolower($lang);
                $this->set_language($lang);
            }
        }
        return $this->post_page($lang, $privateTopic, 1);
    }

    private function topics_count_per_category($webmaster_id = 0): array
    {
        $CategoriesList = Section::where('webmaster_id', '=', $webmaster_id)->where('status', 1)->orderby('webmaster_id', 'asc')->orderby('row_no', 'asc')->get();

        $TopicsCountPerCat = [];
        if (count($CategoriesList) > 0) {
            foreach ($CategoriesList as $CAT) {
                $cat_ids = [];
                $cat_ids[] = $CAT->id;
                $SubCategories = Section::where("status", 1)->where("father_id", $CAT->id)->pluck("id")->toarray();
                foreach ($SubCategories as $SubCategory) {
                    $cat_ids[] = $SubCategory;
                    $SubCategories2 = Section::where("status", 1)->where("father_id", $SubCategory)->pluck("id")->toarray();
                    foreach ($SubCategories2 as $SubCategory2) {
                        $cat_ids[] = $SubCategory2;
                    }
                }
                $category_topics = TopicCategory::whereIn('section_id', $cat_ids)->pluck("topic_id")->toarray();

                $Topics = Topic::where([['webmaster_id', '=', $webmaster_id], ['status', 1], ['expire_date', '>=', date("Y-m-d")], ['expire_date', '<>', null]])->orWhere([['webmaster_id', '=', $webmaster_id], ['status', 1], ['expire_date', null]])->whereIn('id', $category_topics)->orderby('row_no', 'asc')->get();
                $TopicsCountPerCat[$CAT->id] = count($Topics);
            }
        }
        return $TopicsCountPerCat;
    }

}
