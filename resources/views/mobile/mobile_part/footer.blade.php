      @section('rami_mobile_footer')
      <footer>
          <div id="rt_warning" class="modal fade" aria-modal="true" style="padding-right: 17px;">
		    <div class="modal-dialog">
		        <div class="modal-content">
		            <div class="modal-header">
		                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		                <h4 class="modal-title">Error</h4>
		            </div>
		            <div class="modal-body">
						<p class="rt_errormsg">Error Message Here...</p>
		               
		            </div>
		        </div>
		    </div>
		</div>
         <div class="container footer_secbar">
            <div class="row">
               <div class="col-6 col-sm-6 footerFB">
                  <ul class="rt_socialico">
                     <li>
                       <span class="sf_src"><i class="fa fa-search" aria-hidden="true"></i></span>
                       <div class="search-sec">
                           <form action="{{ url('search')}}" method="POST" accept-charset="utf-8" id="search_form_header" enctype="multipart/form-data">
                           {{ csrf_field() }}
                           <span class="sf_close"><i class="fa fa-times" aria-hidden="true"></i></span>
                           <input type="text" placeholder="חפש באתר..." class="form-control sf_input" name="hotel_code">
                           <button class="sf_search"><i class="fa fa-search" aria-hidden="true"></i></button>
                           </form>
                       </div>
                         </li>
                     <li><a href="{{ url('/contact') }}"><i class="fa fa-envelope" aria-hidden="true"></i></a></li>
                     <li><a href="https://www.facebook.com/RmNsywtWtyyrwt"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                  </ul>
               </div>
               <div class="col-6 col-sm-6 footer-number">
                  <p class="footer-number-text"><a href="tel:072-372-6240">072-372-6240<i class="fa fa-phone" aria-hidden="true"></i></a></p>
               </div>
               <div class="rami_creator_div" style="width: 100%;text-align: center;padding: 2px;">
                  <span >Created By: </span>
                   <a href="https://sisfy.com/" target="_blank">SISFY Web & Software Services</a>
              </div>
            </div>

         </div>

      </footer>
      @show