<footer>
  <div id="rt_warning" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Error</h4>
        </div>
        <div class="modal-body">
          <p class="rt_errormsg">Error Message Here...</p>

        </div>
      </div>
    </div>
  </div>
  <div class="rt_loader"><img src="{{ url('/assets/front/images')}}/loading-final.gif" alt="Loader"></div>
  <div class="container">
    <div class="row">
      <div class="col-md-2 footer-right">
        <img src="{{ url('/assets/front/images')}}/footer-logo.jpg" width="137" height="53" alt=""
          href="{{ url('/') }}">
        <p>היער השחור ( Schwarzwald) היער השחור נמצא בקצה הדרום-מערבי של גרמניה.
          הוא תחום על ידי הגבול עם שווייץ מדרום והגבול עם צרפת (לאורך נהר הריין) במערב. היער השחור מיעדי החופשה
          הפופולאריים באירופה,
          נקרא כך בשל צפיפות העצים והאפלה השוררת בו.
        </p>
      </div>
      {{--Black Forest Vacation Packages --}}
      <div class="col-md-2 footer-nav-box">
        <h4>
          <a>חבילות נופש ליער השחור</a>
        </h4>
        <ul>
          <li><a href="{{ url('חבילות-נופש-ליער-השחור-קיץ-2019-2') }}">חבילות נופש ליער השחור קיץ 2020</a></li>
          {{--Vacation Packages for the Black Forest--}}
          <li><a href="{{ url('/חבילות-נופש-לאוסטריה-תאריכים') }}">חבילות נופש למשפחות לאוסטריה – זלצבורג</a></li>
          {{--Holiday packages for families in Austria - Salzburg--}}
          <li><a href="{{ url('/חבילות-נופש-ליער-השחור-ראש-השנה-סוכות') }}">חבילות נופש ליער השחור לראש השנה וסוכות
              2020</a></li> {{--Vacation packages for the Black Forest for Rosh Hashana and Sukkot 2019--}}
          <li><a href="{{ url('/כפרי-נופש-ביער-השחור-2') }}">כפרי נופש ביער השחור</a></li>
          {{--Holiday Villages in the Black Forest--}}
          <li><a href="{{ url('/חבילות-נופש-לפסח') }}">חבילות נופש ליער השחור לפסח 2020</a></li>
          {{--Vacation Packages for the Black Forest for Pesach--}}
          <li><a href="{{ url('/חבילות-אירוח-לזלצבורג-אוסטריה') }}">חבילות אירוח לזלצבורג אוסטריה</a></li>
          {{--Accommodation packages to Salzburg Austria--}}
          <li><a href="{{ url('/כל-חבילות-הנופש-לאוסטריה') }}">כל חבילות הנופש לאוסטריה</a></li>
          {{--Holiday packages to Austria --}}
          <li><a href="{{ url('/היער-השחור') }}">היער השחור מידע מקיף</a></li>
          {{--Black Forest Comprehensive information--}}
        </ul>
      </div>
      <div class="col-md-2 footer-nav-box">
        <h4>
          <a> טיסות ולינה</a>{{--Flights and accommodation --}}
        </h4>
        <ul>
          <li><a href="{{ url('/מידע-כללי-לנוסע-על-היער-השחור') }}">מידע כללי לנוסע על היער השחור</a></li>
          {{--  Vacation Packages for the Black Forest --}}
          <li><a href="{{ url('/מידע-לנוסע-על-אוסטריה') }}">מידע לנוסע על אוסטריה</a></li>
          {{--Knowledge of passengers on Austria--}}
          <li><a href="{{ url('/טיסות-ליער-השחור') }}">טיסות ליער השחור</a></li>
          {{--Flights to the Black Forest --}} 
          <li><a href="{{ url('/טיסות-לזלצבורג') }}">טיסות לזלצבורג</a></li> {{--Flights to Salzburg--}}
          <li><a href="{{ url('/טיסות-למינכן') }}">טיסות למינכן</a></li> {{--Flights to Munich--}}
          <li><a href="{{ url('/טיסות-לציריך') }}">טיסות לציריך</a></li> {{--Flights to Zurich--}}
          <li><a href="{{ url('/טיסות-לפרנקפורט') }}">טיסות לפרנקפורט</a></li> {{--Flights to Frankfurt--}}
          <li><a href="{{ url('/טיסות-לבריסל') }}">טיסות לבריסל</a></li> {{--Flights to Frankfurt--}}
          <li><a href="{{ url('/לינה-ביער-השחור') }}">אפשרויות לינה ביער השחור</a></li>
          {{--Accommodation in the Black Forest--}}
          <li><a href="{{ url('/לינה-בזלצבורג') }}">אפשרויות לינה בזלצבורג</a></li>
          {{--Accommodation in Salzburg--}}
          <li><a href="{{ url('/כפרי-נופש-בהולנד') }}">כפרי נופש בהולנד</a></li>
          <li><a href="{{ url('/הולנד-עם-ילדים') }}">הולנד עם ילדים</a></li>
          <li><a href="{{ url('/טיסות-לבריסל') }}">טיסות לבריסל</a></li>
          <li><a href="{{ url('/טיסות-זולות-לבריסל') }}">טיסות זולות לבריסל</a></li>
        </ul>
      </div>
      <div class="col-md-2 footer-nav-box">
        <h4>
          <a href="javascript:void(0)"> אטרקציות וטיולים </a> {{-- Attractions and excursions --}}
        </h4>
        <ul>
          <li><a href="{{ url('/28') }}">ערים מרכזיות והמלצות לטיולים ביער השחור</a>
          </li> {{--And recommendations for trips in the Black Forest--}}
          <li><a href="{{ url('/אאוטלטים-קניות-ושווקים-ביער-השחור') }}">אאוטלטים, קניות ושווקים ביער השחור</a></li>
          {{--Eutels, shopping and markets in the Black Forest--}}
          <li><a href="{{ url('/קניות-שווקים-וחנויות-בפרייבורג-היער-ה') }}">קניות, שווקים וחנויות בפרייבורג היער
              השחור</a></li> {{--Nayot, markets and shops in Freiburg the Black Forest--}}
          <li><a href="{{ url('/מידע-למטייל-על-אגם-קונסטנץ-אוסטריה') }}">מידע למטייל על אגם קונסטנץ אוסטריה</a></li>
          {{--Learn about Lake Constance Austria--}}
          <li><a href="{{ url('/8-האטרקציות-הכי-השוות-ביער-השחור') }}">8 האטרקציות הכי שוות ביער השחור</a></li>
          {{--8 The most equal attractions in the Black Forest--}}
          <li><a href="{{ url('/מפת-מקומות-ואטרקציות-ביער-השחור') }}">מפת מקומות ואטרקציות ביער השחור</a></li>
          {{--Map of places and attractions in the Black Forest--}}
          <li><a href="{{ url('/פארק-אירופה') }}">פארק אירופה</a></li>{{--Europe park--}}
          <li><a href="{{ url('/מסלול-טיול-ציריך-והיער-השחור-10-ימים') }}">מסלול טיול התחלה בציריך וליער השחור</a></li>
          {{--Paved tour starting in Zurich and Black Leer--}}
          <li><a href="{{ url('/דרכים-ומסלולי-נסיעה-מומלצים-ביער-השחו') }}">דרכים ומסלולי נסיעה מומלצים ביער השחור</a>
          </li>{{--And recommended hiking trails in the Black Forest--}}
        </ul>
      </div>
      <div class="col-md-2 footer-nav-box ft-cont">
        <h4>
        </h4>
        <ul>
          <li><a href="{{ url('/קונסטנץ-ואגם-קונסטנץ-konstanz') }}">קונסטנץ ואגם קונסטנץ (Konstanz)</a></li>
          {{--Wenceslas and Lake Konstanz--}}
          <li><a href="{{ url('/טירת-נוישוונשטיין-אטרקציית-חובה-בטי') }}">טירת נוישוונשטיין – אטרקציית חובה בטיולי
              משפחות באזור מינכן</a></li>
          {{--Yacht Neuschwanstein - A mandatory attraction for family trips in the Munich area--}}
          <li><a href="{{ url('/מסלול-טיול-התחלה-במינכן-וליער-השחור') }}">מסלול טיול התחלה במינכן וליער השחור</a></li>
          {{-- A tour of Munich and the Black Forest--}}
          <li><a href="{{ url('/מסלול-טיול-מומלץ-ל-8-ימים-ביער-השחור') }}">מסלול טיול מומלץ ל-8 ימים ביער השחור</a></li>
          {{--Recommended for 8 days in the Black Forest--}}
          <li><a href="{{ url('/יעדים-מומלצים-לטיולים-ביער-השחור')}}">יעדים מומלצים לטיולים ביער השחור – חלק א'</a></li>
          {{--Recommended Destinations for Black Forest Trips - Part--}}
          <li><a href="{{ url('/יעדים-מומלצים-לטיולים-ביער-השחור-חלק-ב') }}">יעדים מומלצים לטיולים ביער השחור – חלק
              ב'</a></li>{{--Recommended witnesses for trips in the Black Forest - Part 2--}}
          <li><a href="{{ url('/יעדים-מומלצים-לטיולים-ביער-השחור-חלק-ג') }}">יעדים מומלצים לטיולים ביער השחור – חלק
              ג'</a></li>{{--Recommended Destinations for Black Forest Trips - Part 3--}}
        </ul>
      </div>
      <div class="col-md-2 footer-nav-box">
        <h4><a href="javascript:void(0)"> כרטיסי היער השחור וזלצבורגלנד </a></h4>
        {{-- Black Forest Rats and Salzburg --}}
        <ul>
          <li><a href="{{ url('/כרטיסי-היער-השחור') }}">כרטיסי היער השחור</a></li>{{--Black Forest Cards--}}
          <li><a href="{{ url('/כרטיס-היער-השחור-החדש-schwarzwaldcard') }}">כרטיס היער השחור החדש Schwarzwald Card</a>
          </li>{{--The new Schwarzwald Card--}}
          <li><a href="{{ url('/כרטיס-הקונוס-של-היער-השחור-konus') }}">כרטיס הקונוס של היער השחור Konus</a></li>
          {{--The cones of the Black Forest--}}
          <li><a href="{{ url('/הכרטיס-האדום-של-היער-השחור-hochschwarzwald-card') }}">הכרטיס האדום של היער השחור
              Hochschwarzwald Card</a></li>{{--The Red Card of the Black Forest--}}
          <li><a href="{{ url('/כרטיס-הזלצבורגלנד-salzburgerland-card') }}">כרטיס זלצבורגלנד – SalzburgerLand Card</a>
          </li>{{--Salzburland card
--}}
        </ul>
      </div>
    </div>
  </div>
  <div class="container footer-bottom">
    <div class="row">
      <div class="col-md-2 footer-number">
        <p>לשירותכם גם נציג שירות </p>
        <p class="footer-number-text"><a href="tel:072-372-6240">072-372-6240</a></p>
      </div>
      <div class="col-md-2 footerFB">
        <p> <a href="https://www.facebook.com/RmNsywtWtyyrwt"><img
              src="{{ url('/assets/front/images') }}/footer-facebook.jpg" width="39" height="38" alt=""></a> רם בפייסבוק
        </p>
      </div>
      <div class="col-md-8 footer-bottom-link">
        <ul>
          <li><a href="{{ url('/') }}" aria-current="page">דף הבית</a></li>
          <li><a href="{{ url('/אודות-רם-נסיעות-ותיירות') }}">אודות רם נסיעות</a></li>
          <li><a href="{{ url('/תקנון-אתר-רם-נסיעות-ותיירות') }}">תקנון האתר</a></li>
          <li><a href="{{ url('/אבטחת-מידע') }}">אבטחת מידע</a></li>
          <li><a href="{{ url('/contact') }}">צור קשר</a></li>
          <li><a href="{{ url('/היער-השחור') }}">היער השחור מידע</a></li>

          <li class="btn-group">
            <a data-toggle="dropdown"> יעדי רם נסיעות </a>
            <ul class="dropdown-menu drop-up" role="menu" aria-labelledby="dropdownMenu">
              <li class="dropdown-submenu"><a class="dropdown-item" tabindex="-1" href="">היער השחור</a>
                {{--Black Forest --}}
                <ul class="dropdown-menu drop-up1">
                  <li><a class="dropdown-item" href="{{ url('/היער-השחור-גרמניה') }}">היער השחור גרמניה</a></li>
                  {{--Black Forest Germany--}}
                  <li><a class="dropdown-item" href="{{ url('/package-category/דילים-ליער-השחור/') }}">דילים ליער
                      השחור</a></li>{{--Yelim to the Black Forest --}}
                  <li><a class="dropdown-item" href="{{ url('/חופשה-ביער-השחור') }}">חופשה ביער השחור</a></li>
                  {{--Pasha in the Black Forest--}}
                  <li><a class="dropdown-item" href="{{ url('/טיול-ליער-השחור') }}">טיול ליער השחור</a></li>
                  {{--A trip to the Black Forest--}}
                  <li><a class="dropdown-item" href="{{ url('/כפרי-נופש-ביער-השחור-2') }}">כפרי נופש ביער השחור</a></li>
                  {{--Fruit holiday in the Black Forest--}}
                  <li><a class="dropdown-item" href="{{ url('/כפר-נופש-ביער-השחור') }}">כפר נופש ביער השחור</a></li>
                  {{--A holiday in the Black Forest--}}
                  <li><a class="dropdown-item" href="{{ url('/היער-השחור-עם-ילדים') }}">היער השחור עם ילדים</a></li>
                  {{--The Black Forest with Children--}}
                  <li><a class="dropdown-item" href="{{ url('/טיול-מאורגן-ליער-השחור-למשפחות') }}">טיול מאורגן ליער
                      השחור למשפחות</a></li>{{--An organized tour to the Black Forest for families--}}
                </ul>
              </li>
              {{--Westeria --}}
              <li class="dropdown-submenu"><a class="dropdown-item" tabindex="-1" href="">אוסטריה</a>
                <ul class="dropdown-menu drop-up1">
                  <li><a class="dropdown-item" href="{{ url('/מידע-אוסטריה') }}">מידע אוסטריה</a></li>
                  {{--Information Austria--}}
                  <li><a class="dropdown-item" href="{{ url('/אוסטריה-וחבל-טירול') }}">אוסטריה וחבל טירול</a></li>
                  {{--Austria and the Tyrol region--}}
                  <li><a class="dropdown-item" href="{{ url('/דילים-לאוסטריה') }}">דילים לאוסטריה</a></li>
                  {{--To Austria--}}
                  <li><a class="dropdown-item" href="{{ url('/טיול-באוסטריה') }}">טיול באוסטריה</a></li>
                  {{--A Trip in Austria--}}
                  <li><a class="dropdown-item" href="{{ url('/אוסטריה-למשפחות') }}">אוסטריה למשפחות</a></li>
                  {{--Austria for families--}}
                  <li><a class="dropdown-item" href="{{ url('/טיול-מאורגן-לאוסטריה') }}">טיול מאורגן לאוסטריה</a></li>
                  {{--Organized tour to Austria--}}
                  <li><a class="dropdown-item" href="{{ url('/טיול-לאוסטריה-עם-ילדים') }}">טיול לאוסטריה עם ילדים</a>
                  </li>{{--A trip to Austria with children--}}
                  <li><a class="dropdown-item" href="{{ url('/דירות-נופש-בזלצבורג') }}">דירות נופש בזלצבורג</a></li>
                  {{--Vacation apartments in Salzburg--}}
                  <li><a class="dropdown-item" href="{{ url('/accomodation/כפרי-נופש-באוסטריה') }}">צימרים בזלצבורג</a>
                  </li>{{--Accommodation in Salzburg--}}
                  <li><a class="dropdown-item" href="{{ url('/כפרי-נופש-באוסטריה') }}">כפרי נופש באוסטריה</a></li>
                  {{--Holiday villages in Austria--}}
                  <li><a class="dropdown-item" href="{{ url('/כפר-נופש-באוסטריה') }}">כפר נופש באוסטריה</a></li>
                  {{--Austria vacation rentals--}}
                  <li><a class="dropdown-item" href="{{ url('/דירות-נופש-באוסטריה') }}">דירות נופש באוסטריה</a></li>
                  {{--Holiday apartments in Austria--}}
                  <li><a class="dropdown-item" href="{{ url('/צימרים-באוסטריה') }}">צימרים באוסטריה</a></li>
                  {{--In Austria--}}
                </ul>
              </li>
              {{--Waland --}}
              <li class="dropdown-submenu"><a class="dropdown-item" tabindex="-1" href="javascript:void(0)">הולנד</a>
                <ul class="dropdown-menu drop-up1">
                  <li><a class="dropdown-item" href="{{ url('/הולנד-עם-ילדים') }}">הולנד עם ילדים</a></li>
                  {{--Waland with children--}}
                  <li><a class="dropdown-item" href="{{ url('/כפרי-נופש-בהולנד') }}">כפרי נופש בהולנד </a></li>
                  {{--Fruit Holiday in the Netherlands--}}
                  <li><a class="dropdown-item" href="{{ url('/כפר-נופש-בהולנד-למשפחות') }}">כפר נופש בהולנד למשפחות </a>
                  </li>{{--A holiday in the Netherlands for families--}}
                  <li><a class="dropdown-item" href="{{ url('/חבילות-נופש-להולנד') }}">חבילות נופש להולנד </a></li>
                  {{--Holiday packages to the Netherlands--}}
                  <li><a class="dropdown-item" href="{{ url('/חופשה-בהולנד-עם-ילדים') }}">חופשה בהולנד עם ילדים </a>
                  </li>{{--And spent time in the Netherlands with children--}}
                  <li><a class="dropdown-item" href="{{ url('/נופש-בהולנד-עם-ילדים') }}">נופש בהולנד עם ילדים</a></li>
                  {{--And Pash in the Netherlands with children --}}
                  <li><a class="dropdown-item" href="{{ url('/נופש-בהולנד-למשפחות') }}">נופש בהולנד למשפחות </a></li>
                  {{--Holiday in the Netherlands for families--}}
                  <li><a class="dropdown-item" href="{{ url('/לינה-בהולנד-עם-ילדים') }}">לינה בהולנד עם ילדים</a></li>
                  {{--Accommodation in the Netherlands with children--}}
                  <li><a class="dropdown-item" href="{{ url('/חופשה-בהולנד') }}">חופשה בהולנד </a></li>
                  {{--In the Netherlands--}}
                </ul>
              </li>
              {{-- Witch --}}
              <li class="dropdown-submenu"><a class="dropdown-item" tabindex="-1" href="javascript:void(0)">שוויץ </a>
                <ul class="dropdown-menu drop-up1">
                  <li><a class="dropdown-item" href="{{ url('/מידע-שוויץ') }}">מידע שוויץ </a></li>
                  {{--Information Switzerland --}}
                </ul>
              </li>
            </ul>
          </li>
          {{-- Vacation packages --}}
          <li class="btn-group">
            <a data-toggle="dropdown">חבילות נופש </a>
            <ul class="dropdown-menu drop-up" role="menu" aria-labelledby="dropdownMenu">
              <li><a class="dropdown-item" href="{{ url('/חבילות-נופש-ליעד-השחור') }}">חבילות נופש ליער השחור</a></li>
              {{--Black Forest Vacation Packages--}}
              <li><a class="dropdown-item" href="{{ url('/חבילות-נופש-לאוסטריה') }}">חבילות נופש לאוסטריה</a></li>
              {{--Holiday packages to Austria --}}
            </ul>
          </li>
          {!! last_footer_menu_for_pages() !!}
        </ul>
      </div>
    </div>
  </div>
</footer>
