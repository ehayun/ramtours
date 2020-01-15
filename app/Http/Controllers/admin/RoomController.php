<?php
namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\model\room;
use App\model\room_image;
use App\model\hotel;
use App\model\room_price;
use App\model\room_stock;
use App\model\room_type;
use App\Rules\ramiDatePrice;
use App\Rules\dateSlotRangeChecking;
use Validator;

class RoomController extends Controller
{
    public function __construct()
    {
      rami_setup_backend_language();
      $this->middleware('CheckRole');
    }
    public function index()
    {
        $data['rooms']=room::all();
        $data['all_count']=room::all()->count();
        $data['trash_count']=room::onlyTrashed()->count();
        $data['page_title']='All Room';
        $data['assets_admin']=url('assets/admin');
        return view('admin.room.all_room',$data);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['page_title']='Add Room';        
        $data['hotels']=hotel::all();
        $data['room_types']=room_type::all();
        $data['assets_admin']=url('assets/admin');
        return view('admin.room.add_room',$data);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $room=new room;
        $messages = [
        ];
        $this->validate($request, [
            'room_title' => 'required',
            'room_type' => 'required',
            'room_hotel' => 'required',
            'max_people'=>'required',
            'room_area'=>'required'
        ], $messages);            
        $room->room_title=$request->room_title;
        $room->old_room_id=$request->old_room_id;
        $room->room_desc=$request->room_desc;
        $room->room_area=$request->room_area;
        $room->room_type=$request->room_type;
        $room->max_people=$request->max_people;
        $room->room_hotel=$request->room_hotel;
        $room->save(); 
        if($request->go_to_next_page==0){
           set_flash_msg('flash_success','Room Inserted Successsfully.');
           return redirect('admin/room'); 
        }else{
           set_flash_msg('flash_success','Room Inserted Successsfully..Please add gallery.');
           return redirect('admin/room/gallery/'.$room->id); 
        } 
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['room']=room::find($id);
        $data['page_title']='Edit Room';
        $data['hotels']=hotel::all();
        $data['room_types']=room_type::all();
        $data['assets_admin']=url('assets/admin');
        return view('admin.room.edit_room',$data);
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
        $room=room::find($id);
        $messages = [
        ];
        $this->validate($request, [
            'room_title' => 'required',
            'room_type' => 'required',
            'room_hotel' => 'required',
            'max_people'=>'required',
            'room_area'=>'required'
        ], $messages);            
        $room->room_title=$request->room_title;
        $room->old_room_id=$request->old_room_id;
        $room->room_desc=$request->room_desc;
        $room->room_area=$request->room_area;
        $room->room_type=$request->room_type;
        $room->max_people=$request->max_people;
        $room->room_hotel=$request->room_hotel;
        $room->save(); 
        if($request->go_to_next_page==0){
           set_flash_msg('flash_success','Room Updated Successsfully.');
        return redirect('admin/room');
        }else{
           set_flash_msg('flash_success','Room Updated Successsfully..Please add gallery.');
           return redirect('admin/room/gallery/'.$room->id); 
        } 
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $room = room::find($id);
        $room->delete();
        set_flash_msg('flash_success','Room Deleted Successsfully.');
        return redirect('admin/room');
    }
    public function gallery($id){
        $data['images']=room_image::where(['room_id'=>$id])->orderBy('sequence','DESC')->get();
        $data['room_id']=$id;
        $data['page_title']='Room Gallery';
        $data['assets_admin']=url('assets/admin');
        return view('admin.room.gallery',$data);
    }
    public function add_image(Request $request, $id) {
        $room=room::find($id);
        $validator = Validator::make($request->all(),[
            'room_image' => 'required|image|max:5000',
        ]);
        if($validator){
            if(empty($room)){
                return response()->json(['status' => 'fail45'], 400);
            }
            $image = new room_image;
            $image->room_id = $id;
            $image->title = $room->room_title;
            $image->save();
            $file = rami_file_uploading($request->file('room_image'), 'room', $image->id, '');
            $image->image = $file;
            $image->save();
            return response()->json(['status' => 'success'], 200);
        }else{
            return response()->json(['status' => 'fail'], 400);
        }
    }
    public function edit_image($id) {
        $data['room_image']=room_image::find($id);
        $data['id']=$id;
        $data['page_title']='Edit Room Image';
        $data['assets_admin']=url('assets/admin');
        return view('admin.room.edit_room_image',$data);
    }
    public function update_image(Request $request, $id) {
        $room_image=room_image::find($id);
        $room_id=$room_image['room_id'];
        $messages = [            
        ];
        $this->validate($request, [
            'title' => 'required',
            'sequence' => 'required',
        ], $messages);
        $room_image->title=$request->title;
        $room_image->sequence=$request->sequence;
        $room_image->save();
        if($room_image->id){
            if($request->file('room_image')){
                if(!empty($room_image->image)){
                    rami_get_file_delete($room_image->image);
                }
                $room_img=rami_file_uploading($request->file('room_image'), 'room_image', $room_image->id, '');
                $room_image->image=$room_img;
                $room_image->save();
            }
        }
        set_flash_msg('flash_success','Room Image Updated Successsfully.');
        return redirect('admin/room/gallery/'.$room_id);        
    }
    public function delete_image($id)
    {
        $room_image = room_image::find($id);
        $room_image->delete();
        rami_get_file_delete($room_image->image);
        set_flash_msg('flash_success','Room Images Deleted Successsfully.');
        return redirect('admin/room/gallery/'.$room_image->room_id);
    }
    public function room_stock($room_id){
        $data['room_stocks']=room_stock::where(['room_id'=>$room_id])->get();
        $room=room::find($room_id);
        $data['room_name']=$room->room_title;        
        $data['all_count']=room_stock::where(['room_id'=>$room_id])->get()->count();
        $data['page_title']='Room Stock';
        $data['room_id']=$room_id;
        $data['assets_admin']=url('assets/admin');
        return view('admin.room.room_stock',$data);
    }
     public function room_stock_create($room_id){
        $data['room_prices']=room_price::where(['room_id'=>$room_id])->get();        
        $data['form_url']=url('admin/room/'.$room_id.'/room_stock');           
        $data['room_id']=$room_id;
        $room=room::find($room_id);
        if(empty($room)){
             set_flash_msg('flash_error','room not find.');
             return redirect('admin/room/');
        }
        $data['page_title']='Room Stock';
        $data['assets_admin']=url('assets/admin');
        return view('admin.room.add_room_stock',$data);
    }
        public function room_stock_store(Request $request, $room_id){
        $room=room::find($room_id);
        if(empty($room)){
            set_flash_msg('flash_success','Room did not found.');
            return redirect('admin/room');
        }
        $room_stock=new room_stock;
        $messages = [
        ];
        $valid_array=array(
            'stock_start_date' => ['required','date','date_format:Y-m-d','after:yesterday','before:stock_end_date'],
            'stock_end_date' => ['required','date','date_format:Y-m-d','after:yesterday','after:stock_start_date'],
            'room_available'=>'required',
        );       
        $this->validate($request,$valid_array,$messages);        
        $room_stock->stock_start_date=$request->stock_start_date;
        $room_stock->stock_end_date=$request->stock_end_date;
        $room_stock->room_available=$request->room_available;
        $room_stock->room_id=$room_id;
        $room_stock->save();
        if($request->go_to_next_page==0){
           set_flash_msg('flash_success','Room Stock Inserted Successsfully.');
           return redirect('admin/room/'.$request->room_id.'/room_stock');
        }else{
           set_flash_msg('flash_success','Room Price Inserted Successsfully..Please add Room alerts.');
           return redirect('admin/room-alert/'.$room->id); 
        }
    }
    public function room_stock_edit($stock_id){
        $data['room_stock']=room_stock::find($stock_id);        
        $data['form_url']=url('admin/room_stock');
        $room=room::find($data['room_stock']->room_id);
        if(empty($room)){
            set_flash_msg('flash_error','room not find.');
            return redirect('admin/room/');
        }
        $data['page_title']='Room Stock Edit';
        $data['assets_admin']=url('assets/admin');
        return view('admin.room.edit_room_stock',$data);
    }
    public function room_stock_update(Request $request,$price_id){
        $room_stock=room_stock::find($price_id);
        $room_id=$room_stock->room_id;
        $room=room::find($room_id);
        if(empty($room_stock)){
            set_flash_msg('flash_success','Something went wrong.');
            return redirect('admin/room');
        }
        $messages = [
        ];
        $valid_array=array(
            'stock_start_date' => ['required','date','date_format:Y-m-d','after:yesterday','before:stock_end_date'],
            'stock_end_date' => ['required','date','date_format:Y-m-d','after:yesterday','after:stock_start_date'],
            'room_available'=>'required',
        );
        $this->validate($request,$valid_array,$messages);
        $room_stock->stock_start_date=$request->stock_start_date;
        $room_stock->stock_end_date=$request->stock_end_date;
        $room_stock->room_available=$request->room_available;
        $room_stock->save();
        set_flash_msg('flash_success','Room Stock updated Successsfully.');
        return redirect('admin/room/'.$room_stock->room_id.'/room_stock');
    }
    public function room_stock_delete($stock_id){
        $room_stock = room_stock::find($stock_id);
        $room_id=$room_stock['room_id'];
        $room_stock->delete();
        set_flash_msg('flash_success','Room price Deleted Successsfully.');
        return redirect('admin/room/'.$room_id.'/room_stock');
    }       
    public function room_prices($room_id){
        $data['room_prices']=room_price::where(['room_id'=>$room_id])->get();
        $room=room::find($room_id);
        $data['room_name']=$room->room_title;        
        $data['all_count']=room_price::where(['room_id'=>$room_id])->get()->count();
        $data['page_title']='Room Prices';
        $data['room_id']=$room_id;
        $data['assets_admin']=url('assets/admin');
        return view('admin.room.room_price',$data);
    }
    public function room_price_create($room_id){      
        $data['form_url']=url('admin/room/'.$room_id.'/room_prices');           
        $data['room_id']=$room_id;
        $room=room::find(['id'=>$room_id])->first();
        $data['max_people']=$room['max_people'];
        if(empty($data['max_people'])){
            set_flash_msg('flash_error','Max People  details required before adding room price.Please update room details with max people.');
            return redirect('admin/room/'.$room_id.'/edit');
        }
        $data['page_title']='Room Price';
        $data['assets_admin']=url('assets/admin');
        return view('admin.room.add_room_price',$data);
    }
    public function room_price_store(Request $request){
        $room=room::find($request->room_id);
        if(empty($room)){
            set_flash_msg('flash_success','Room did not found.');
            return redirect('admin/room');
        }
        $room_price=new room_price;
        $messages = [
        ];
        $valid_array=array(
            'price_start_date' => ['required','date','date_format:Y-m-d','after:yesterday','before:price_end_date',new ramiDatePrice('room_prices',$request->room_id, 'room_id',''),new dateSlotRangeChecking('room_prices',$request->room_id, 'room_id',$request->price_start_date,$request->price_end_date,'')],
            'price_end_date' => ['required','date','date_format:Y-m-d','after:yesterday','after:price_start_date',new ramiDatePrice('room_prices',$request->room_id, 'room_id','')],
            'price_currency' => 'required',
        );
        if(!empty($room->max_people)){
            for($i=1;$i<=$room->max_people;$i++){
            $price_var='price_for_'.$i;
                $valid_array[$price_var]='required';                          
            }
        }           
        $this->validate($request,$valid_array,$messages);        
        $room_price->price_start_date=$request->price_start_date;
        $room_price->price_end_date=$request->price_end_date;
        $room_price->room_available=$request->room_available;
        for($i=1;$i<=20;$i++){
            $price_var='price_for_'.$i;
            if(empty($request->{$price_var})){
                 $room_price->{$price_var}=0;
            }else{
                $room_price->{$price_var}=$request->{$price_var};
            }
        }
        $room_price->price_currency=$request->price_currency;
        $room_price->room_id=$request->room_id;
        $room_price->save();
        if($request->go_to_next_page==0){
           set_flash_msg('flash_success','Room Price Inserted Successsfully.');
           return redirect('admin/room/'.$request->room_id.'/room_prices');
        }else{
           set_flash_msg('flash_success','Room Price Inserted Successsfully..Please add Room alerts.');
           return redirect('admin/room-alert/'.$room->id); 
        } 
                   
    }
    public function room_price_edit($price_id){
        $data['room_price']=room_price::find($price_id);        
        $data['form_url']=url('admin/room_prices');
        $data['room_id']=$data['room_price']->room_id;
        $room=room::find(['id'=>$data['room_id']])->first();
        $data['max_people']=$room['max_people'];
        if(empty($data['max_people'])){
            set_flash_msg('flash_error','Max People  details required before adding room price.Please update room details with max people.');
            return redirect('admin/room/'.$room_id.'/edit');
        }
        $data['price_id']=$data['room_price']->id;
        $data['page_title']='Room Price Edit';
        $data['assets_admin']=url('assets/admin');
        return view('admin.room.edit_room_price',$data);
    }
    public function room_price_update(Request $request,$price_id){
        $room_price=room_price::find($price_id);
        $room_id=$room_price->room_id;
        $room=room::find(['id'=>$room_id])->first();
        if(empty($room_price)){
            set_flash_msg('flash_success','Something went wrong.');
            return redirect('admin/room');
        }
        $messages = [
        ];
        $valid_array=array(
            'price_start_date' => ['required','date','date_format:Y-m-d','after:yesterday','before:price_end_date',new ramiDatePrice('room_prices',$room_price->room_id, 'room_id',$room_price->id),new dateSlotRangeChecking('room_prices',$request->room_id, 'room_id',$request->price_start_date,$request->price_end_date,$room_price->id)],

            'price_end_date' => ['required','date','date_format:Y-m-d','after:yesterday','after:price_start_date',new ramiDatePrice('room_prices',$room_price->room_id, 'room_id',$room_price->id),new dateSlotRangeChecking('room_prices',$request->room_id, 'room_id',$request->price_start_date,$request->price_end_date,$room_price->id)],
            'price_currency' => 'required',
        );
        if(!empty($room->max_people)){
            for($i=1;$i<=$room->max_people;$i++){
            $price_var='price_for_'.$i;
                $valid_array[$price_var]='required';
                          
            }
        }
        $this->validate($request,$valid_array,$messages);
        $room_price->price_start_date=$request->price_start_date;
        $room_price->price_end_date=$request->price_end_date;
        $room_price->room_available=$request->room_available;
        for($i=1;$i<=20;$i++){
            $price_var='price_for_'.$i;
            if(empty($request->{$price_var})){
                 $room_price->{$price_var}=0;
            }else{
                $room_price->{$price_var}=$request->{$price_var};
            }
        }        
        $room_price->price_currency=$request->price_currency;
        $room_price->room_id=$room_price->room_id;
        $room_price->save();

        set_flash_msg('flash_success','Room Price updated Successsfully.');
        return redirect('admin/room/'.$room_price->room_id.'/room_prices');        
    }
    public function room_price_delete($price_id){
        $room_price = room_price::find($price_id);
        $room_id=$room_price['room_id'];
        $room_price->delete();
        set_flash_msg('flash_success','Room price Deleted Successsfully.');
        return redirect('admin/room/'.$room_id.'/room_prices');
    }       
    public function trash_room(){
        $data['page_title']='All Trash Hotel';
        $data['trash_room']=room::onlyTrashed()->get();
        $data['all_count']=room::onlyTrashed()->count();
        $data['assets_admin']=url('assets/admin');        
        return view('admin.room.all_trashed_room',$data);     
    }
    public function restore_trash_room(){
        $room=room::onlyTrashed()->restore();
        if(!empty($room)){
          set_flash_msg('flash_success','Trash room Restore Successsfully.');
            return redirect('admin/room');  
        }else{
           set_flash_msg('flash_error','Trash room not Found for Restore.');
           return redirect('admin/room/trash');
        }
    }
    public function restore_single_room($id){        
        $room=room::onlyTrashed()->where(['id'=>$id])->restore();
        if(!empty($room)){
          set_flash_msg('flash_success','Trash room Restore Successsfully.');
            return redirect('admin/room');  
        }else{
           set_flash_msg('flash_error','Trash room not Found for Restore.');
           return redirect('admin/room/trash');
        }
    }
    public function force_delete_room($id){
        $room= room::onlyTrashed()->where(['id'=>$id]);
        $room->forceDelete();
        set_flash_msg('flash_success','Room deleted Successfully.');
        return redirect('admin/room/trash');
    }
    public function force_delete_all(){
        room::onlyTrashed()->forceDelete();        
        set_flash_msg('flash_success','All room deleted successfully');
        return redirect('admin/room/trash');
    }
    public function room_alert($id){
        $data['room']=room::find($id);
        if(empty($data['room'])){
            set_flash_msg('flash_error','Room not found.');
            return redirect('admin/room');
        }
        $data['assets_admin']=url('assets/admin'); 
        $data['page_title']='Room alerts';
        return view('admin/room/room_alert',$data);
    }
    public function store_room_alert(Request $request,$id)
    {
        $room=room::find($id);
        $messages = [
        ];
        $this->validate($request, [
            // 'booking_date' => 'required',
            // 'alert_date_1' => 'required',
            // 'alert_date_2' => 'required',
            // 'alert_date_3'=>'required',
            // 'alert_date_4'=>'required',
            // 'alert_date_5'=>'required'
        ], $messages);
        $room->booking_date=$request->booking_date;
        $room->alert_date_1=$request->alert_date_1;
        $room->alert_msg_1=$request->alert_msg_1;
        $room->alert_date_2=$request->alert_date_2;
        $room->alert_msg_2=$request->alert_msg_2;
        $room->alert_date_3=$request->alert_date_3;
        $room->alert_msg_3=$request->alert_msg_3;
        $room->alert_date_4=$request->alert_date_4;
        $room->alert_msg_4=$request->alert_msg_4;
        $room->alert_date_5=$request->alert_date_5;
        $room->alert_msg_5=$request->alert_msg_5;
        $room->save();
        set_flash_msg('flash_success','Room Alert Inserted Successsfully.');
        return redirect('admin/room-alert/'.$id);        
    }
}
