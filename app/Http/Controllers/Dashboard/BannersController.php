<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Http\Requests;
use App\Models\Menu;
use App\Models\WebmasterBanner;
use App\Models\WebmasterSection;
use Auth;
use File;
use Helper;
use Illuminate\Config;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Redirect;

class BannersController extends Controller
{

    private $uploadPath = "uploads/banners/";

    // Define Default Variables

    public function __construct()
    {
        $this->middleware('auth');

        // Check Permissions
        if (!@Auth::user()->permissionsGroup->banners_status || !Helper::GeneralWebmasterSettings("banners_status")) {
            return Redirect::to(route('NoPermission'))->send();
        }
    }

    public function index()
    {
        //
        // General for all pages
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        // General END

        //List of Banners Sections
        $WebmasterBanners = WebmasterBanner::where('status', '=', '1')->orderby('row_no', 'asc')->get();

        if (@Auth::user()->permissionsGroup->view_status) {
            $Banners = Banner::where('created_by', '=', Auth::user()->id)->orderby('section_id',
                'asc')->orderby('row_no',
                'asc')->paginate(config('smartend.backend_pagination'));
        } else {
            $Banners = Banner::orderby('section_id', 'asc')->orderby('row_no',
                'asc')->paginate(config('smartend.backend_pagination'));
        }
        return view("dashboard.banners.list", compact("Banners", "GeneralWebmasterSections", "WebmasterBanners"));
    }

    public function create($sectionId)
    {
        // Check Permissions
        if (!@Auth::user()->permissionsGroup->add_status) {
            return Redirect::to(route('NoPermission'))->send();
        }
        //
        // General for all pages
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        // General END

        //Banner Sections Details
        $WebmasterBanner = WebmasterBanner::find($sectionId);

        return view("dashboard.banners.create", compact("GeneralWebmasterSections", "WebmasterBanner"));
    }

    public function store(Request $request)
    {
        // Check Permissions
        if (!@Auth::user()->permissionsGroup->add_status) {
            return Redirect::to(route('NoPermission'))->send();
        }


        $next_nor_no = Banner::max('row_no');
        if ($next_nor_no < 1) {
            $next_nor_no = 1;
        } else {
            $next_nor_no++;
        }

        $WebmasterBanner = WebmasterBanner::find($request->section_id);
        if (!empty($WebmasterBanner)) {
            $Banner = new Banner;
            $Banner->row_no = $next_nor_no;
            $Banner->section_id = $request->section_id;
            $Banner->code = $request->code;
            foreach (Helper::languagesList() as $ActiveLanguage) {
                if ($ActiveLanguage->box_status) {
                    $Banner->{"title_" . $ActiveLanguage->code} = strip_tags($request->{"title_" . $ActiveLanguage->code});
                    $Banner->{"details_" . $ActiveLanguage->code} = $request->{"details_" . $ActiveLanguage->code};
                    $Banner->{"link_" . $ActiveLanguage->code} = $request->{"link_" . $ActiveLanguage->code};

                    // Start of Upload Files
                    $formFileName = "file_" . $ActiveLanguage->code;
                    $fileFinalName = "";
                    if ($request->$formFileName != "") {
                        $this->validate($request, [
                            $formFileName => 'image'
                        ]);

                        $fileFinalName = time() . rand(1111,
                                9999) . '.' . $request->file($formFileName)->getClientOriginalExtension();
                        $path = $this->uploadPath;
                        $request->file($formFileName)->move($path, $fileFinalName);

                        // resize & optimize
                        Helper::imageResize($path . $fileFinalName, @$WebmasterBanner->width, @$WebmasterBanner->height);
                        Helper::imageOptimize($path . $fileFinalName);
                    }
                    if ($fileFinalName == "") {
                        $formFileName = "file2_" . $ActiveLanguage->code;
                        if ($request->$formFileName != "") {
                            $this->validate($request, [
                                $formFileName => 'mimes:mp4,ogv,webm'
                            ]);
                            $fileFinalName = time() . rand(1111,
                                    9999) . '.' . $request->file($formFileName)->getClientOriginalExtension();
                            $path = $this->uploadPath;
                            $request->file($formFileName)->move($path, $fileFinalName);
                        }
                    }
                    //save file name
                    $Banner->{"file_" . $ActiveLanguage->code} = $fileFinalName;
                }
            }

            $Banner->icon = $request->icon;
            $Banner->video_type = $request->video_type;
            if ($request->video_type == 2) {
                $Banner->youtube_link = $request->vimeo_link;
            } else {
                $Banner->youtube_link = $request->youtube_link;
            }
            $Banner->link_url = $request->link_url;
            $Banner->visits = 0;
            $Banner->status = 1;
            $Banner->created_by = Auth::user()->id;
            $Banner->save();

            return redirect()->action('Dashboard\BannersController@index')->with('doneMessage', __('backend.addDone'));
        }
        return redirect()->action('Dashboard\BannersController@index')->with('errorMessage', __('backend.error'));
    }

    public function edit($id)
    {
        // Check Permissions
        if (!@Auth::user()->permissionsGroup->edit_status) {
            return Redirect::to(route('NoPermission'))->send();
        }
        //
        // General for all pages
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        // General END

        if (@Auth::user()->permissionsGroup->view_status) {
            $Banners = Banner::where('created_by', '=', Auth::user()->id)->find($id);
        } else {
            $Banners = Banner::find($id);
        }
        if (!empty($Banners)) {

            foreach (Helper::languagesList() as $ActiveLanguage) {
                try {
                    $code = $ActiveLanguage->code;
                    // menus table
                    Schema::table('banners', function (Blueprint $table) use ($code) {
                        $table->string('link_' . $code)->nullable();
                    });

                    // copy data to new language columns
                    Banner::where('id', '>', 0)->update(['link_' . $code => DB::raw('link_url')]);
                } catch (\Exception $e) {
                }
            }

            //Banner Sections Details
            $WebmasterBanner = WebmasterBanner::find($Banners->section_id);

            return view("dashboard.banners.edit", compact("Banners", "GeneralWebmasterSections", "WebmasterBanner"));
        } else {
            return redirect()->action('Dashboard\BannersController@index');
        }
    }

    public function update(Request $request, $id)
    {
        // Check Permissions
        if (!@Auth::user()->permissionsGroup->add_status) {
            return Redirect::to(route('NoPermission'))->send();
        }
        //
        $Banner = Banner::find($id);
        if (!empty($Banner)) {
            $WebmasterBanner = WebmasterBanner::find($request->section_id);
            if (!empty($WebmasterBanner)) {


                $Banner->section_id = $request->section_id;
                $Banner->code = $request->code;

                foreach (Helper::languagesList() as $ActiveLanguage) {
                    if ($ActiveLanguage->box_status) {
                        $Banner->{"title_" . $ActiveLanguage->code} = strip_tags($request->{"title_" . $ActiveLanguage->code});
                        $Banner->{"details_" . $ActiveLanguage->code} = $request->{"details_" . $ActiveLanguage->code};
                        $Banner->{"link_" . $ActiveLanguage->code} = $request->{"link_" . $ActiveLanguage->code};

                        // Start of Upload Files
                        $formFileName = "file_" . $ActiveLanguage->code;
                        $fileFinalName = "";
                        if ($request->$formFileName != "") {
                            $this->validate($request, [
                                $formFileName => 'image'
                            ]);

                            $fileFinalName = time() . rand(1111,
                                    9999) . '.' . $request->file($formFileName)->getClientOriginalExtension();
                            $path = $this->uploadPath;
                            $request->file($formFileName)->move($path, $fileFinalName);

                            // resize & optimize
                            Helper::imageResize($path . $fileFinalName, @$WebmasterBanner->width, @$WebmasterBanner->height);
                            Helper::imageOptimize($path . $fileFinalName);
                        }
                        if ($fileFinalName == "") {
                            $this->validate($request, [
                                $formFileName => 'mimes:mp4,ogv,webm'
                            ]);

                            $formFileName = "file2_" . $ActiveLanguage->code;
                            if ($request->$formFileName != "") {
                                $fileFinalName = time() . rand(1111,
                                        9999) . '.' . $request->file($formFileName)->getClientOriginalExtension();
                                $path = $this->uploadPath;
                                $request->file($formFileName)->move($path, $fileFinalName);
                            }
                        }
                        //save file name
                        if ($fileFinalName != "") {
                            // Delete a banner file
                            if ($Banner->{"file_" . $ActiveLanguage->code} != ""  && $Banner->{"file_" . $ActiveLanguage->code} != "noimg.png") {
                                File::delete($this->uploadPath . $Banner->{"file_" . $ActiveLanguage->code});
                            }

                            $Banner->{"file_" . $ActiveLanguage->code} = $fileFinalName;
                        }
                    }
                }

                $Banner->video_type = $request->video_type;
                if ($request->video_type == 2) {
                    $Banner->youtube_link = $request->vimeo_link;
                } else {
                    $Banner->youtube_link = $request->youtube_link;
                }
                $Banner->link_url = $request->link_url;
                $Banner->icon = $request->icon;
                $Banner->status = $request->status;
                $Banner->updated_by = Auth::user()->id;
                $Banner->save();
                return redirect()->action('Dashboard\BannersController@edit', $id)->with('doneMessage', __('backend.saveDone'));
            }
        }
        return redirect()->action('Dashboard\BannersController@index')->with('errorMessage', __('backend.error'));

    }

    public function destroy($id = 0)
    {
        // Check Permissions
        if (!@Auth::user()->permissionsGroup->delete_status) {
            return Redirect::to(route('NoPermission'))->send();
        }
        //
        if (@Auth::user()->permissionsGroup->view_status) {
            $Banner = Banner::where('created_by', '=', Auth::user()->id)->find($id);
        } else {
            $Banner = Banner::find($id);
        }
        if (!empty($Banner)) {
            // Delete a banner file
            foreach (Helper::languagesList() as $ActiveLanguage) {
                if ($ActiveLanguage->box_status) {
                    if ($Banner->{"file_" . $ActiveLanguage->code} != ""   && $Banner->{"file_" . $ActiveLanguage->code} != "noimg.png") {
                        File::delete($this->uploadPath . $Banner->{"file_" . $ActiveLanguage->code});
                    }
                }
            }

            $Banner->delete();
            return redirect()->action('Dashboard\BannersController@index')->with('doneMessage', __('backend.deleteDone'));
        } else {
            return redirect()->action('Dashboard\BannersController@index');
        }
    }

    public function updateAll(Request $request)
    {
        //
        if ($request->action == "order") {
            foreach ($request->row_ids as $rowId) {
                $Banner = Banner::find($rowId);
                if (!empty($Banner)) {
                    $row_no_val = "row_no_" . $rowId;
                    $Banner->row_no = $request->$row_no_val;
                    $Banner->save();
                }
            }

        } else {
            if ($request->ids != "") {
                if ($request->action == "activate") {
                    Banner::wherein('id', $request->ids)
                        ->update(['status' => 1]);

                } elseif ($request->action == "block") {
                    Banner::wherein('id', $request->ids)
                        ->update(['status' => 0]);

                } elseif ($request->action == "delete") {
                    // Check Permissions
                    if (!@Auth::user()->permissionsGroup->delete_status) {
                        return Redirect::to(route('NoPermission'))->send();
                    }
                    // Delete banners files
                    $Banners = Banner::wherein('id', $request->ids)->get();
                    foreach ($Banners as $banner) {
                        foreach (Helper::languagesList() as $ActiveLanguage) {
                            if ($ActiveLanguage->box_status) {
                                if ($banner->{"file_" . $ActiveLanguage->code} != ""   && $banner->{"file_" . $ActiveLanguage->code} != "noimg.png") {
                                    File::delete($this->uploadPath . $banner->{"file_" . $ActiveLanguage->code});
                                }
                            }
                        }
                    }

                    Banner::wherein('id', $request->ids)
                        ->delete();

                }
            }
        }
        return redirect()->action('Dashboard\BannersController@index')->with('doneMessage', __('backend.saveDone'));
    }


}
