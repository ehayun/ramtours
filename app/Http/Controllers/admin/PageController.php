<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\model\Location;
use App\model\page;
use App\model\pagelink;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        rami_setup_backend_language();
        $this->middleware('CheckRole');
    }
    public function index()
    {
        $data['page_title'] = 'All Pages';
        $data['pages'] = page::orderBy('updated_at', 'desc')->get();
        $data['all_count'] = page::all()->count();
        $data['assets_admin'] = url('assets/admin');
        return view('admin.page.all_page', $data);
    }


    private function updateMeta($page, $request)
    {

        $slug = $page->slug;
        $title = $request->page_title;
        $description = strip_tags($request->pck_shot_desc);
        $now = \Carbon\Carbon::now()->format("Y-m-d H:i");

        // dd($request->all());
        $header = "
                    <link rel='profile' href='http://gmpg.org/xfn/11'>
                    <link rel='pingback' href=''>
                <script data-cfasync='false' type='text/javascript'>//<![CDATA[
                    var gtm4wp_datalayer_name = 'dataLayer';
                    var dataLayer = dataLayer || [];
                //]]>
                </script>
                <meta name='description' content='$description'/>
                <link rel='canonical' href='https://ramtours.com/$slug' />
                <meta property='og:locale' content='he_IL' />
                <meta property='og:type' content='article' />
                <meta property='og:title' content='$title' />
                <meta property='og:description' content='$description' />
                <meta property='og:url' content='https://ramtours.com/$slug' />
                <meta property='og:site_name' content='רם - תיירות ונסיעות' />
                <meta property='article:tag' content='$title' />
                <meta property='article:section' conten'$title' />
                <meta property='article:published_time' content='$now' />
                <meta property='article:modified_time' content='$now' />
                <meta property='og:updated_time' content='2018-11-15T10:54:36+00:00' />
                <meta name='twitter:card' content='summary_large_image' />
                <meta name='twitter:description' content='' />
                <meta name='twitter:title' content='' />
                <meta name='twitter:image' content='' />
                <script type='application/ld+json'>{'@context':'https://schema.org','@type':'Organization','url':'https://ramtours.com/','sameAs':[],'@id':'https://ramtours.com/#organization','name':'ramtours','logo':''}</script>
                <script type='application/ld+json'>
                {
                '@context':'https://schema.org',
                '@type':'BreadcrumbList',
                'itemListElement':[
                    {'@type':'ListItem','position':1,'item':
                    {'@id':'https://ramtours.com/',
                    'name':'$slug'}
                    },
                    {'@type':'ListItem','position':2,'item':{'@id':'https://ramtours.com/$slug'}}]}
                </script>
            ";

        $footer = '<script type="b9b0e8d2c75aeed76733c602-text/javascript">
            /* <![CDATA[ */
            var google_conversion_id = 1003871194;
            var google_custom_params = window.google_tag_params;
            var google_remarketing_only = true;
            /* ]]> */
            </script>
            <script type="b9b0e8d2c75aeed76733c602-text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
            </script>
            
            <noscript>
            <div style="display:inline;">
            <img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/1003871194/?guid=ON&script=0"/>
            </div>
            </noscript>';





        $page->page_header_custom_code = $header;
        $page->page_footer_custom_code = $footer;


        return $page;
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['page_title'] = 'Add Page';
        $data['assets_admin'] = url('assets/admin');
        $data['locations'] = Location::all();
        return view('admin.page.add_page', $data);
    }
    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $page = new page;
        $messages = [];
        $this->validate($request, [
            'page_title' => 'required',
            'page_disc' => 'required',
            'show_in_header_menu' => 'required',
            'show_in_footer_menu' => 'required',
            'page_status' => 'required',
            'page_img' => 'image|max:2048',
        ], $messages);
        $page->page_title = $request->page_title;
        $page->page_disc = $request->page_disc;
        $page->menu_title = $request->menu_title;
        $page->show_in_header_menu = $request->show_in_header_menu;
        $page->show_in_footer_menu = $request->show_in_footer_menu;
        $page->sequence = $request->sequence;
        $page->page_status = $request->page_status;
        $page->package_start_date = $request->package_start_date;
        $page->package_end_date = $request->package_end_date;
        $page->package_flight_location = $request->package_flight_location;




        if (!$request->slug) {
            // $page->slug = implode(mb_split(" ", $request->page_title), "-");
            $page->slug = str_replace(" ", "-", $request->page_title);
        }

        $page = $this->updateMeta($page, $request);

        $page->pck_shot_desc = $request->pck_shot_desc;



        $page->page_title_text = $request->page_title;
        $page->save();
        if ($page->id) {
            if ($request->file('page_img')) {
                $page_img = rami_file_uploading($request->file('page_img'), 'page', $page->id, '');
                $page->page_img = $page_img;
                $page->save();
            }
        }
        set_flash_msg('flash_success', 'Page Inserted Successfully.');
        return redirect("admin/page/" . $page->id . "/edit");
    }
    /**
     * Show the form for editing the specified resource.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['page'] = page::find($id);
        $data['page_title'] = 'edit Page';
        $data['assets_admin'] = url('assets/admin');
        $data['locations'] = Location::all();
        return view('admin.page.edit_page', $data);
    }
    /**
     * Update the specified resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $page = page::find($id);
        $messages = [];
        $this->validate($request, [
            'page_title' => 'required',
            'page_disc' => 'required',
            'show_in_header_menu' => 'required',
            'show_in_footer_menu' => 'required',
            'page_status' => 'required',
            'page_img' => 'image|max:2048',
        ], $messages);
        $page->page_title = $request->page_title;
        $page->page_disc = $request->page_disc;
        $page->pck_shot_desc = $request->pck_shot_desc;
        $page->menu_title = $request->menu_title;
        $page->show_in_header_menu = $request->show_in_header_menu;
        $page->show_in_footer_menu = $request->show_in_footer_menu;
        $page->sequence = $request->sequence;
        $page->having_right_link = $request->is_having_link;
        $page->page_status = $request->page_status;
        $page->package_start_date = $request->package_start_date;
        $page->package_end_date = $request->package_end_date;
        $page->package_flight_location = $request->package_flight_location;

        $page = $this->updateMeta($page, $request);

        $page->save();
        if ($page->id) {
            if ($request->file('page_img')) {
                $page_img = rami_file_uploading($request->file('page_img'), 'page', $page->id, '');
                $page->page_img = $page_img;
                $page->save();
            }
        }
        set_flash_msg('flash_success', 'Page Updated Successfully.');
        return redirect('admin/page');
    }
    /**
     * Remove the specified resource from storage.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $page = page::find($id);
        $page->delete();
        set_flash_msg('flash_success', 'Page Deleted Successfully.');
        return redirect('admin/page');
    }
    public function page_links($page_id)
    {
        $data['page_title'] = 'All Page Links';
        $data['page_id'] = $page_id;
        $data['page_links'] = pagelink::where([['page_id', $page_id]])->get();
        $data['all_count'] = pagelink::where([['page_id', $page_id]])->count();
        $data['assets_admin'] = url('assets/admin');
        return view('admin.page.otherpage_links', $data);
    }
    public function create_link($page_id)
    {
        $data['page_id'] = $page_id;
        $data['page_title'] = 'Add OtherPage Link';
        $data['assets_admin'] = url('assets/admin');
        return view('admin.page.add_otherpage_link', $data);
    }
    public function store_link(Request $request, $page_id)
    {
        $pagelink = new pagelink;
        $messages = [];
        $this->validate($request, [
            'pagelink_title' => 'required',
            'pagelink_url' => 'required',
        ], $messages);
        $pagelink->page_id = $page_id;
        $pagelink->pagelink_title = $request->pagelink_title;
        $pagelink->pagelink_url = $request->pagelink_url;
        $pagelink->save();
        set_flash_msg('flash_success', 'Other Page Link Created Successfully.');
        return redirect('admin/pagelink/' . $page_id);
    }
    /**
     * Show the form for editing the specified resource.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit_link($pagelink_id)
    {
        $data['pagelink'] = pagelink::find($pagelink_id);
        $data['page_id'] = $data['pagelink']->page_id;
        $data['page_title'] = 'Edit PageLink';
        $data['assets_admin'] = url('assets/admin');
        return view('admin.page.edit_pagelink', $data);
    }
    /**
     * Update the specified resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_link(Request $request, $page_id, $pagelink_id)
    {
        $pagelink = pagelink::find($pagelink_id);
        $messages = [];
        $this->validate($request, [
            'pagelink_title' => 'required',
            'pagelink_url' => 'required',
        ], $messages);
        $pagelink->page_id = $request->page_id;
        $pagelink->pagelink_title = $request->pagelink_title;
        $pagelink->pagelink_url = $request->pagelink_url;
        $pagelink->save();
        set_flash_msg('flash_success', 'Pagelink details Updated Successfully.');
        return redirect('admin/pagelink/' . $pagelink->page_id);
    }
    /**
     * Remove the specified resource from storage.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy_link($pagelink_id)
    {
        $pagelink = pagelink::find($pagelink_id);
        $pagelink->delete();
        set_flash_msg('flash_success', 'Pagelink details Deleted Successfully.');
        return redirect('admin/pagelink/' . $pagelink->page_id);
    }
    public function add_page_meta_data($id)
    {
        $data['page'] = page::find($id);
        if (empty($data['page'])) {
            set_flash_msg('flash_error', 'Page not found.');
            return redirect('admin/page');
        }
        $data['page_title'] = 'Add Page meta data';
        $data['assets_admin'] = url('assets/admin');
        return view('admin.page.add_page_meta_data', $data);
    }
    public function save_page_meta_data(Request $request, $id)
    {
        $page = page::find($id);
        $page->slug = $request->slug;
        $page->page_title_text = $request->page_title_text;
        $page->page_header_custom_code = $request->page_header_custom_code;
        $page->page_footer_custom_code = $request->page_footer_custom_code;
        $page->save();
        set_flash_msg('flash_success', 'Page meta data updated successfully');
        return redirect('admin/page-meta/' . $id);
    }
}
