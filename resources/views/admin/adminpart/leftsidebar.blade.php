<!--left side bar -->
@section('admin_left_menu')
<aside id="leftsidebar" class="sidebar">
    <!-- User Info -->
    <div class="user-info">
        <div class="image">
            <img src="{{ get_cur_user_image() }}" width="48" height="48" alt="User" />
        </div>
        <div class="info-container">
            <div class="name" data-toggle="dropdown">{!! get_cur_user_name() !!}</div>
            <div class="btn-group user-helper-dropdown">
                <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"
                    role="button"> keyboard_arrow_down </i>
                <ul class="dropdown-menu slideUp">
                    <li><a href="{{url('admin/profile')}}"><i class="material-icons">person</i>Profile</a></li>
                    <li class="divider"></li>
                    <li><a href="{{url('admin/changepwd')}}"><i class="material-icons">lock</i>Change Password </a></li>
                    <li class="divider"></li>
                    <li><a href="javascript:void(0)" class="admin-logout"><i class="material-icons">input</i>Sign
                            Out</a></li>
                </ul>
            </div>
            <div class="email">{!! get_cur_user_srt_email() !!}</div>
        </div>
    </div>
    <!-- #User Info -->
    <!-- Menu -->
    <div class="menu">
        <ul class="list">
            <li class="header">MAIN NAVIGATION</li>
            <li>
                <a href="{{url('/admin')}}">
                    <i class="material-icons">home</i><span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="material-icons">flight</i>
                    <span>Flight</span>
                </a>
                <ul class="ml-menu">
                    <a href="javascript:void(0);" class="menu-toggle">Airlines</a>
                    <ul class="ml-menu">
                        <li class="active">
                            <a href="{{url('/admin/airline/')}}">All Airlines</a>
                        </li>
                        <li class="active">
                            <a href="{{url('/admin/airline/create')}}">Add Airlines</a>
                        </li>
                    </ul>
                    <a href="javascript:void(0);" class="menu-toggle">Flights</a>
                    <ul class="ml-menu">
                        <li class="active">
                            <a href="{{url('/admin/flight')}}">Flights</a>
                        </li>
                        <li class="active">
                            <a href="{{url('/admin/flight/create')}}">AddFlight</a>
                        </li>
                    </ul>
                    <a href="javascript:void(0);" class="menu-toggle">Flights Schedule</a>
                    <ul class="ml-menu">
                        <li class="active">
                            <a href="{{url('/admin/flight-schedule')}}">Flights Schedule</a>
                        </li>
                        <li class="active">
                            <a href="{{url('/admin/flight-schedule/create')}}">Add Flight Schedule</a>
                        </li>
                    </ul>
                </ul>
            </li>
            <li>
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="material-icons">local_hotel</i>
                    <span>Hotels</span>
                </a>
                <ul class="ml-menu">
                    <a href="javascript:void(0);" class="menu-toggle">Hotel</a>
                    <ul class="ml-menu">
                        <li class="active">
                            <a href="{{url('/admin/hotel')}}">Hotels</a>
                        </li>
                        <li class="active">
                            <a href="{{url('/admin/hotel/create')}}">Add Hotel</a>
                        </li>
                        <li class="active">
                            <a href="{{url('/admin/hotel/trash')}}">Private Hotel</a>
                        </li>
                    </ul>
                    <a href="javascript:void(0);" class="menu-toggle">Room</a>
                    <ul class="ml-menu">
                        <li class="active">
                            <a href="{{url('/admin/room')}}">Rooms</a>
                        </li>
                        <li class="active">
                            <a href="{{url('/admin/room/create')}}">Add Rooms</a>
                        </li>
                    </ul>
                    <a href="javascript:void(0);" class="menu-toggle">Hotel Type</a>
                    <ul class="ml-menu">
                        <li class="active">
                            <a href="{{url('/admin/hotel-type')}}">All Hotel Type</a>
                        </li>
                        <li class="active">
                            <a href="{{url('/admin/hotel-type/create')}}">Add Hotel Type</a>
                        </li>
                    </ul>
                    <a href="javascript:void(0);" class="menu-toggle">Room Type</a>
                    <ul class="ml-menu">
                        <li class="active">
                            <a href="{{url('/admin/room-type')}}">All Room Type</a>
                        </li>
                        <li class="active">
                            <a href="{{url('/admin/room-type/create')}}">Add Rooms Type</a>
                        </li>
                    </ul>
                    <a href="javascript:void(0);" class="menu-toggle">Hotel Amenities</a>
                    <ul class="ml-menu">
                        <li class="active">
                            <a href="{{url('/admin/hotel-amenities')}}">All Amenities</a>
                        </li>
                        <li class="active">
                            <a href="{{url('/admin/hotel-amenities/create')}}">Add Amenity</a>
                        </li>
                    </ul>
                    <a href="javascript:void(0);" class="menu-toggle">Hotel Features</a>
                    <ul class="ml-menu">
                        <li class="active">
                            <a href="{{url('/admin/hotel-features')}}">All Features</a>
                        </li>
                        <li class="active">
                            <a href="{{url('/admin/hotel-features/create')}}">Add Feature</a>
                        </li>
                    </ul>
                    <a href="javascript:void(0);" class="menu-toggle">Hotel Reviews</a>
                    <ul class="ml-menu">
                        <li class="active">
                            <a href="{{url('/admin/review')}}">All Reviews</a>
                        </li>
                        <li class="active">
                            <a href="{{url('/admin/review/create')}}">Add Reviews</a>
                        </li>
                    </ul>
                </ul>
            </li>
            <li>
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="material-icons">directions_car</i>
                    <span>Car</span>
                </a>
                <ul class="ml-menu">
                    <a href="javascript:void(0);" class="menu-toggle"><span>Car Supplier</span>
                    </a>
                    <ul class="ml-menu">
                        <li class="active">
                            <a href="{{url('/admin/car-suplier/create')}}">Add Car Supplier</a>
                        </li>
                        <li class="active">
                            <a href="{{url('/admin/car-suplier')}}">All Car Supplier</a>
                        </li>
                    </ul>
                    <a href="javascript:void(0);" class="menu-toggle">
                        <span>Car</span>
                    </a>
                    <ul class="ml-menu">
                        <li class="active">
                            <a href="{{url('/admin/car/create')}}">Add Car</a>
                        </li>
                        <li class="active">
                            <a href="{{url('/admin/car')}}">All Car</a>
                        </li>
                    </ul>
                    <a href="javascript:void(0);" class="menu-toggle">
                        <span>Car Features</span>
                    </a>
                    <ul class="ml-menu">
                        <li class="active">
                            <a href="{{url('/admin/car-features/create')}}">Add Car Features</a>
                        </li>
                        <li class="active">
                            <a href="{{url('/admin/car-features')}}">All Car Features</a>
                        </li>
                    </ul>
                </ul>
            </li>
            <li>
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="material-icons">card_giftcard</i>
                    <span>Packages</span>
                </a>
                <ul class="ml-menu">
                    <li class="active">
                        <a href="{{url('/admin/package/create')}}">Add Packages</a>
                    </li>
                    <li class="active">
                        <a href="{{url('/admin/package')}}">All Packages</a>
                    </li>
                    <li class="active">
                        <a href="{{url('/admin/package/package-page-placeholders')}}">Package Page Placeholders</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="material-icons">credit_card</i>
                    <span>Cards</span>
                </a>
                <ul class="ml-menu">
                    <li class="active">
                        <a href="{{url('/admin/card/create')}}">Add Card</a>
                    </li>
                    <li class="active">
                        <a href="{{url('/admin/card')}}">All Cards</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="material-icons">insert_emoticon</i>
                    <span>Testimonials</span>
                </a>
                <ul class="ml-menu">
                    <li class="active">
                        <a href="{{url('/admin/testimonial')}}">All Testimonials</a>
                    </li>
                    <li class="">
                        <a href="{{url('/admin/testimonial/create')}}">Add Testimonials</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="material-icons">local_florist</i>
                    <span>Attractions</span>
                </a>
                <ul class="ml-menu">
                    <li class="active">
                        <a href="{{url('/admin/attraction')}}">All Attractions</a>
                    </li>
                    <li class="">
                        <a href="{{url('/admin/attraction/create')}}">Add Attractions</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="material-icons">location_on</i>
                    <span>Locations</span>
                </a>
                <ul class="ml-menu">
                    <li class="active">
                        <a href="{{url('admin/location/create')}}">Add Location</a>
                    </li>
                    <li class="active">
                        <a href="{{url('admin/location')}}">All Locations</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="material-icons">border_color</i>
                    <span>Orders</span>
                </a>
                <ul class="ml-menu">
                    <li class="active">
                        <a href="{{url('admin/orders-detail')}}">Orders Details</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="material-icons">pages</i>
                    <span>More Pages</span>
                </a>
                <ul class="ml-menu">
                <li class="">
                        <a href="{{url('admin/bans')}}">Ban People</a>
                    </li>
                    <li class="">
                        <a href="{{url('admin/page')}}">Pages</a>
                    </li>
                    <li class="">
                        <a href="{{url('admin/page/create')}}">Add Page</a>
                    </li>
                    <li class="">
                        <a href="{{url('admin/gallery')}}">Add Images for pages</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="material-icons">settings</i><span>Settings</span>
                </a>
                <ul class="ml-menu">
                    <a href="javascript:void(0);" class="menu-toggle">Language Setting</a>
                    <ul class="ml-menu">
                        <li class="active">
                            <a href="{{url('/admin/setting/language_setting')}}">Language Setting</a>
                        </li>
                    </ul>
                    <a href="javascript:void(0);" class="menu-toggle">Currency Setting</a>
                    <ul class="ml-menu">
                        <li class="active">
                            <a href="{{url('/admin/setting/currency_rate')}}">Currency Rate</a>
                        </li>
                    </ul>
                    <a href="javascript:void(0);" class="menu-toggle">Home Page </a>
                    <ul class="ml-menu">
                        <li class="active">
                            <a href="{{url('/admin/setting/homepage')}}">Home Page Setting</a>
                        </li>
                        <li class="active">
                            <a href="{{url('/admin/setting/homepage_meta')}}">Home Page Meta Data</a>
                        </li>
                    </ul>
                    <a href="javascript:void(0);" class="menu-toggle">Notification</a>
                    <ul class="ml-menu">
                        <li class="active">
                            <a href="{{url('/admin/setting/notification')}}">Email/Phone</a>
                        </li>
                    </ul>
                </ul>
            </li>
        </ul>
    </div>
    <!-- #Menu -->
</aside>
@show
<!--left side bar -->