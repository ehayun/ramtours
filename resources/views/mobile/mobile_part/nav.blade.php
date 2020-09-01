<header class="masthead">
   <div class="rtmenu">
      <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
         <div class="container">
            <button class="navbar-toggler nav-close" type="button">
               <img src="{{url('assets/mobile')}}/images/rt_menu.png" class="nvbar">
            </button>
            <div class="collapse navbar-collapse">
               <img src="{{url('assets/mobile')}}/images/rt_navclse.png" class="nvclose">
               <ul class="navbar-nav text-uppercase ml-auto">
                  <li class="nav-item">
                     <a class="nav-link js-scroll-trigger {{ get_rami_active_menu('') }}" href="{{url('/')}}">דף
                        הבית</a>
                  </li>
                  {{-- vacation packages --}}
                  
                  <li class="nav-item dropdown">
                     <a href="#" class="nav-link {{ get_rami_active_menu('vacation-packages') }}" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">חבילות נופש</a>
                        <ul class="dropdown-menu" role="menu">
                  <li class="dropdown-item dropdown">
                     <a href="#" class="dropdown-toggle {{ get_rami_active_menu('accommodation') }}">
                        {{_("חבילות נופש ביער השחור")}} </a>
                     <ul class="dropdown-menu">
                        <li class="dropdown-item"><a href="{{ url('/package-category/21') }}">חבילות נופש באיזור היער השחור גרמניה</a></li>
                        <li class="dropdown-item"><a href="{{ url('/20') }}">חבילות נופש ליער השחור לפסח</a></li>
                        <li class="dropdown-item"><a href="{{ url('/44') }}">חבילות נופש ליער השחור קיץ </a></li>
                        <li class="dropdown-item"><a href="{{ url('/70') }}">חבילות נופש ליער השחור לראש השנה וסוכות </a></li>
                     </ul>
                  </li>
                  <li class="dropdown-item dropdown">
                     <a href="#" class="dropdown-toggle {{ get_rami_active_menu('accommodation') }} "> חבילות וכפרי נופש ברחבי הולנד</a>
                     <ul class="dropdown-menu">
                        <li class="dropdown-item"><a href="{{ url('/package-category/82') }}"> חבילות וכפרי נופש בהולנד</a></li>
                        <li class="dropdown-item"><a href="{{ url('/264') }}"> חבילות נופש להולנד פסח</a></li>
                        <li class="dropdown-item"><a href="{{ url('/265') }}"> חבילות נופש להולנד בקיץ</a></li>
                        <li class="dropdown-item"><a href="{{ url('/266') }}"> חבילות נופש להולנד ראש השנה וסוכות</a></li>
                     </ul>
                  </li>
                  <li class="dropdown-item dropdown">
                     <a href="#" class="dropdown-toggle {{ get_rami_active_menu('accommodation') }} "> חבילות נופש זלצבורג אוסטריה</a>
                     <ul class="dropdown-menu">
                        <li class="dropdown-item"><a href="{{ url('/package-category/55') }}"> חבילות נופש באיזור זלצבורג אוסטריה</a></li>
                        <li class="dropdown-item"><a href="{{ url('/262') }}"> חבילות נופש לזלצבורג פסח </a></li>
                        <li class="dropdown-item"><a href="{{ url('/74') }}"> חבילות נופש לזלצבורג בקיץ </a></li>
                        <li class="dropdown-item"><a href="{{ url('/263') }}"> חבילות נופש לזלצבורג ראש השנה וסוכות </a></li>
                     </ul>
                  </li>
                  <li class="dropdown-item dropdown">
                     <a href="#" class="dropdown-toggle {{ get_rami_active_menu('accommodation') }} "> חבילות נופש טירול אוסטריה</a>
                     <ul class="dropdown-menu">
                        <li class="dropdown-item"><a href="{{ url('/package-category/54') }}"> חבילות נופש באיזור טירול אוסטריה</a></li>
                        <li class="dropdown-item"><a href="{{ url('/268') }}"> חבילות נופש לטירול לפסח </a></li>
                        <li class="dropdown-item"><a href="{{ url('/269') }}"> חבילות נופש לטירול ראש השנה וסוכות </a></li>
                        <li class="dropdown-item"><a href="{{ url('/267') }}"> חבילות נופש לטירול לקיץ </a></li>
                     </ul>
                  </li>
                  <li class="dropdown-item"><a href="{{ url('/280') }}"> חבילות נופש לקרואטיה </a></li>
               </ul>
                     
                  </li>
                  {{-- fly and travel menu --}}
                  {{-- <li class="nav-item dropdown"> 
                           <a href="#" class="nav-link dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">בבילות טוס וסע</a>
                           <ul class="dropdown-menu" role="menu">
                              <li class=""><a href="{{ url('/package-category/21') }}" class="dropdown-item">חבילות טוס
                  וסע לפרנקפורט</a></li>
                  <li class=""><a href="{{ url('/package-category/21') }}" class="dropdown-item">חבילות טוס וסע
                        למינכן</a></li>
                  <li class=""><a href="{{ url('/package-category/21') }}" class="dropdown-item">חבילות טוס וסע
                        לציריך</a></li>
                  <li class=""><a href="{{ url('/package-category/21') }}" class="dropdown-item">חבילות טוס וסע
                        לבריסל</a></li>
               </ul>
               </li> --}}
               {{-- Accomodation --}}
               <li class="nav-item dropdown">
                  <a href="#" class="nav-link dropdown-toggle {{ get_rami_active_menu('accommodation') }}" role="button"
                     data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">אפשרויות לינה</a>
                  <ul class="dropdown-menu" role="menu">
                     <li class="dropdown-item dropdown">
                        <a href="javascript:void(0)"
                           class="dropdown-toggle {{ get_rami_active_menu('accommodation') }}">
                           לינה בגרמניה </a>
                        <ul class="dropdown-menu">
                           <li class="dropdown-item"><a href="{{ url('/loc-accommodation/21') }}">לינה ביער השחור</a>
                           </li>
                           <li class="dropdown-item"><a href="{{ url('/loc-accommodation/43') }}">לינה בפרייבורג</a>
                           </li>
                           <li class="dropdown-item"><a href="{{ url('/loc-accommodation/49') }}">לינה בברלין</a></li>
                           <li class="dropdown-item"><a href="{{ url('/loc-accommodation/44') }}">לינה במינכן</a></li>
                           <li class="dropdown-item"><a href="{{ url('/loc-accommodation/45') }}">לינה בפרנקפורט</a>
                           </li>
                           <li class="dropdown-item"><a href="{{ url('/loc-accommodation/47') }}">לינה באוגסבורג</a>
                           </li>
                           <li class="dropdown-item"><a href="{{ url('/loc-accommodation/104') }}">לינה באגם קונסטנץ</a>
                           </li>
                           <li class="dropdown-item"><a href="{{ url('/loc-accommodation/48') }}">לינה בהיידלברג</a>
                           </li>
                           <li class="dropdown-item"><a href="{{ url('/loc-accommodation/30') }}">לינה בפארק אירופה</a>
                           </li>
                        </ul>
                     </li>
                     <li class="dropdown-item dropdown">
                        <a href="javascript:void(0)"
                           class="dropdown-toggle {{ get_rami_active_menu('accommodation') }}">לינה באוסטריה</a>
                        <ul class="dropdown-menu">
                           <li class="dropdown-item"><a href="{{ url('/loc-accommodation/54') }}">לינה בטירול</a></li>
                           <li class="dropdown-item"><a href="{{ url('/loc-accommodation/55') }}">לינה בזלצבורג</a></li>
                        </ul>
                     </li>
                     <li class=""><a href="{{ url('/loc-accommodation/82') }}" class="dropdown-item">לינה בהולנד</a>
                     </li>
                     <li class=""><a href="{{ url('/loc-accommodation/80') }}" class="dropdown-item">לינה בבלגיה</a>
                     </li>
                  </ul>
               </li>
               {{-- flights --}}
               <li class="nav-item dropdown">
                  <a href="#" class="nav-link dropdown-toggle {{ get_rami_active_menu('flights') }}" id="navbarDropdown"
                     role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">טיסות </a>
                  <ul class="dropdown-menu" role="menu">
                     <li class="dropdown-item dropdown">
                        <a href="javascript:void(0)" class="dropdown-toggle {{ get_rami_active_menu('flights') }}">
                           טיסות ליער השחור </a>
                        <ul class="dropdown-menu">
                           <li class="dropdown-item"><a href="{{ url('/flights/44') }}">טיסות למינכן</a></li>
                           <li class="dropdown-item"><a href="{{ url('/flights/45') }}">טיסות לפרנקפורט</a></li>
                           <li class="dropdown-item"><a href="{{ url('/flights/71') }}">טיסות לציריך</a></li>
                        </ul>
                     </li>
                     <li><a href="{{ url('/flights/81') }}" class="dropdown-item">טיסות לבריסל</a></li>
                     <li class="dropdown-item dropdown">
                        <a href="#" class="dropdown-toggle {{ get_rami_active_menu('flights') }}">
                           טיסות לזלצבורג </a>
                        <ul class="dropdown-menu">
                           <li><a href="{{ url('/flights/64') }}" class="dropdown-item">טיסות לוינה </a></li>
                           <li><a href="{{ url('/flights/44') }}" class="dropdown-item">טיסות למינכן </a></li>
                        </ul>
                     </li>
                     <li class="dropdown-item dropdown">
                     <a href="#" class="dropdown-toggle {{ get_rami_active_menu('flights') }} ">   טיסות לקרואטיה </a>
                     <ul class="dropdown-menu">
                        <li class="dropdown-item"><a href="{{ url('/flights/105') }}">טיסות לדוברובניק</a></li>
                        <li class="dropdown-item"><a href="{{ url('/flights/107') }}">טיסות לזאגרב</a></li>
                     </ul>
                  </li>
                  </ul>
               </li>
               {{-- Black forest Cards --}}
               <li class="nav-item dropdown">
                  <a href="#" class="nav-link dropdown-toggle {{ get_rami_active_menu('blackforest-cards') }}"
                     id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true"
                     aria-expanded="false">כרטיסי היער השחור</a>
                  <ul class="dropdown-menu" role="menu">
                     <li><a href="{{ url('/הכרטיס-האדום-של-היער-השחור-hochschwarzwald-card') }}"
                           class="dropdown-item">כרטיס אדום</a></li>
                     <li><a href="{{ url('/כרטיס-היער-השחור-החדש-schwarzwaldcard') }}" class="dropdown-item">הכרטיס
                           השחור החדש</a></li>
                     <li><a href="{{ url('/כרטיס-הקונוס-של-היער-השחור-konus') }}" class="dropdown-item">כרטיס קונוס</a>
                     </li>
                  </ul>
               </li>

               <li class="nav-item">
                  <a class="nav-link js-scroll-trigger {{ get_rami_active_menu('testimonials') }}"
                     href="{{ url('/testimonials') }}">המלצות לקוחות</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link js-scroll-trigger {{ get_rami_active_menu('blackforest-info') }}"
                     href="{{ url('/היער-השחור') }}">היער השחור מידע</a>
               </li>
               <li class="nav-item dropdown">
                  <a href="#" class="nav-link dropdown-toggle {{ get_rami_active_menu('tourist-info') }}"
                     id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true"
                     aria-expanded="false">מידע למטייל</a>
                  <ul class="dropdown-menu" role="menu">
                     <li class="dropdown-item dropdown">
                        <a href="javascript:void(0)"
                           class="dropdown-toggle {{ get_rami_active_menu('flights') }}">הולנד</a>
                        <ul class="dropdown-menu">
                           <li class="dropdown-item"><a href="{{ url('/כפרי-נופש-בהולנד') }}">כפרי נופש בהולנד</a></li>
                           <li class="dropdown-item"><a href="{{ url('/הולנד-עם-ילדים') }}">הולנד עם ילדים</a></li>
                           <li class="dropdown-item"><a href="{{ url('/כפר-נופש-בהולנד-למשפחות') }}">כפר נופש בהולנד
                                 למשפחות</a></li>
                           <li class="dropdown-item"><a href="{{ url('/חבילות-נופש-להולנד') }}">חבילות נופש להולנד</a>
                           </li>
                           <li class="dropdown-item"><a href="{{ url('/חופשה-בהולנד-עם-ילדים') }}">חופשה בהולנד עם
                                 ילדים</a></li>
                           <li class="dropdown-item"><a href="{{ url('/חופשה-בהולנד') }}">חופשהבהולנד</a></li>
                           <li class="dropdown-item"><a href="{{ url('/נופש-בהולנד-למשפחות') }}">ופש בהולנד למשפחות</a>
                           </li>
                           <li class="dropdown-item"><a href="{{ url('/נופש-בהולנד-עם-ילדים') }}">נופש בהולנד עם
                                 ילדים</a></li>
                           <li class="dropdown-item"><a href="{{ url('/לינה-בהולנד-עם-ילדים') }}"> לינה בהולנד עם
                                 ילדים</a></li>
                        </ul>
                     </li>
                     <li class="dropdown-item dropdown">
                        <a href="" class="dropdown-toggle {{ get_rami_active_menu('tourist-info') }}">היער השחור</a>
                        <ul class="dropdown-menu">
                           <li class="dropdown-item"><a href="{{ url('/היער-השחור-גרמניה') }}">יער השחור גרמניה</a></li>
                           <li class="dropdown-item"><a href="{{ url('/package-category/דילים-ליער-השחור') }}">טילים
                                 ליער השחור</a></li>
                           <li class="dropdown-item"><a href="{{ url('/flights/יסות-ליער-השחור') }}">טיסות ליער
                                 השחור</a></li>
                           <li class="dropdown-item"><a href="{{ url('/היער-השחור-עם-ילדים') }}">היער השחור עם ילדים</a>
                           </li>
                           <li class="dropdown-item"><a href="{{ url('/טיול-מאורגן-ליער-השחור-למשפחות') }}">טיול מאורגן
                                 ליער השחור למשפחות</a></li>
                           <li class="dropdown-item"><a href="{{ url('/טיול-ליער-השחור') }}">טיול ליער השחור</a></li>
                           <li class="dropdown-item"><a href="{{ url('/כפר-נופש-ביער-השחור') }}">כפרי נופש ביער
                                 השחור</a></li>
                           <li class="dropdown-item"><a href="{{ url('/חופשה-ביער-השחור') }}">חופשה ביער השחור</a></li>
                           <li class="dropdown-item"><a href="{{ url('/כרטיס-היער-השחור-החדש-schwarzwaldcard') }}">כרטיס
                                 היער השחור</a></li>
                           <li class="dropdown-item"><a href="{{ url('/מלונות-מומלצים-ביער-השחור') }}">מלונות ביער
                                 השחור</a></li>
                           <li class="dropdown-item"><a href="{{ url('/accomodation/לינה-ביער-השחור') }}">אפשרויות לינה
                                 ביער השחור</a></li>
                           <li class="dropdown-item"><a href="{{ url('/צימרים-ודירות-נופש-ביער-השחור') }}">צימרים ודירות
                                 נופש ביער השחור</a></li>
                           <li class="dropdown-item"><a href="{{ url('/חוות-ביער-השחור') }}">חוות ביער השחור</a></li>
                           <li class="dropdown-item"><a href="{{ url('/בקתות-ביער-השחור') }}">בקתות ביער השחור</a></li>
                           <li class="dropdown-item"><a href="{{ url('/חבילות-נופש-ליעד-השחור') }}">חבילות נופש ליער
                                 השחור</a></li>
                        </ul>
                     </li>
                     <li class="dropdown-item dropdown">
                        <a href="" class="dropdown-toggle {{ get_rami_active_menu('tourist-info') }}">אוסטריה</a>
                        <ul class="dropdown-menu">
                           <li class="dropdown-item"><a href="{{ url('/היער-השחור-גרמניה') }}">טיול מאורגן לאוסטריה</a>
                           </li>
                           <li class="dropdown-item"><a href="{{ url('/package-category/דילים-ליער-השחור/') }}">טיול
                                 באוסטריה</a></li>
                           <li class="dropdown-item"><a href="{{ url('/flights/טיסות-ליער-השחור') }}">כפר נופש
                                 באוסטריה</a></li>
                           <li class="dropdown-item"><a href="{{ url('/היער-השחור-עם-ילדים') }}">דילים לאוסטריה</a></li>
                           <li class="dropdown-item"><a href="{{ url('/טיול-מאורגן-ליער-השחור-למשפחות') }}">חבילות נופש
                                 לאוסטריה</a></li>
                           <li class="dropdown-item"><a href="{{ url('/טיול-ליער-השחור') }}">טיסות לזלצבורג</a></li>
                           <li class="dropdown-item"><a href="{{ url('/כפר-נופש-ביער-השחור') }}">טיול לאוסטריה עם
                                 ילדים</a></li>
                           <li class="dropdown-item"><a href="{{ url('/חופשה-ביער-השחור') }}">אוסטריה למשפחות</a></li>
                           <li class="dropdown-item"><a
                                 href="{{ url('/כרטיס-היער-השחור-החדש-schwarzwaldcard') }}">צימרים באוסטריה</a></li>
                           <li class="dropdown-item"><a href="{{ url('/מלונות-מומלצים-ביער-השחור') }}">דירות נופש
                                 באוסטריה</a></li>
                           <li class="dropdown-item"><a href="{{ url('/accommodation/לינה-ביער-השחור') }}">צימרים
                                 בזלצבורג</a></li>
                           <li class="dropdown-item"><a href="{{ url('/צימרים-ודירות-נופש-ביער-השחור') }}">דירות נופש
                                 בזלצבורג</a></li>
                        </ul>
                     </li>
                     <li class="dropdown-item dropdown">
                        <a href="" class="dropdown-toggle {{ get_rami_active_menu('tourist-info') }}">בריסל</a>
                        <ul class="dropdown-menu">
                           <li class="dropdown-item"><a href="{{ url('/טיסות-לבריסל') }}">יסות לבריסל</a></li>
                           <li class="dropdown-item"><a href="{{ url('/טיסות-זולות-לבריסל') }}">טיסות זולות לבריסל</a>
                           </li>
                           <li class="dropdown-item"><a href="{{ url('/טיסות-לבריסל-אל-על') }}">טיסות לבריסל אל על</a>
                           </li>
                           <li class="dropdown-item"><a href="{{ url('/טיסות-לבריסל-בריסל-איירליינס') }}">טיסות לבריסל
                                 בריסל איירליינס</a></li>
                           <li class="dropdown-item"><a href="{{ url('/כרטיס-טיסה-לבריסל') }}">כרטיס טיסה לבריסל</a>
                           </li>
                           <li class="dropdown-item"><a href="{{ url('/טיסה-לבלגיה-בריסל') }}">טיסה לבלגיה בריסל</a>
                           </li>
                           <li class="dropdown-item"><a href="{{ url('/טיסה-לבריסל-לואו-קוסט') }}">טיסה לבריסל לואו
                                 קוסט</a></li>

                        </ul>
                     </li>
                     <li class="dropdown-item dropdown">
                        <a href="" class="dropdown-toggle {{ get_rami_active_menu('tourist-info') }}">כללי</a>
                        <ul class="dropdown-menu">
                           <li class="dropdown-item"><a href="{{ url('/פארק-אירופה') }}">פארק אירופה</a></li>
                        </ul>
                     </li>
                  </ul>
               </li>

               <li class="nav-item">
                  <a class="nav-link js-scroll-trigger {{ get_rami_active_menu('contact') }}"
                     href="{{ url('/תקנון-אתר-רם-נסיעות-ותיירות') }}">תקנון האתר </a>
               </li>
               <li class="nav-item">
                  <a class="nav-link js-scroll-trigger {{ get_rami_active_menu('contact') }}"
                     href="{{ url('/contact') }}">צור קשר</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link js-scroll-trigger {{ get_rami_active_menu('contact') }}"
                     href="{{ url('/אודות-רם-נסיעות-ותיירות') }}"> אודות רם נסיעות</a>
               </li>
               </ul>
            </div>
         </div>
      </nav>
   </div>
</header>