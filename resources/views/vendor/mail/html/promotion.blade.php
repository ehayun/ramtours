<table class="promotion" align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation">
    <tr>
        <td align="right">
            {{ Illuminate\Mail\Markdown::parse($slot) }}
            <strong>שם הגורם המשלם  : </strong>{{$payee_name}}<br>
            <strong>דוא"ל הגורם המשלם   : </strong>{{$email}}<br>
            @if(!empty($start_date))
            <strong>תאריך התחלה   : </strong>{{$start_date}}<br>
            @endif
            @if(!empty($end_date))
            <strong>תאריך סיום : </strong>{{$end_date}}<br>
            @endif
            <strong>רכיבי החבילה   : </strong>{{$pakage_components}}<br>
            <strong>כמות  : </strong>{{$total_peoples}}<br>
            <strong>מבוגרים  : </strong>{{$adults}}<br>
            <strong>ילדים   : </strong>{{$childs}}<br>
            @if ($card > 0)
            <strong>כרטיס יער שחור   : </strong>{{$card}}<br>
            @endif
            <strong>סה"כ מחיר בשקלים  : </strong>₪{{$total_price_in_skl}}<br>
            <strong>סה"כ מחיר ביורו   : </strong>€{{$total_price_in_euro}}<br>
            <strong>שולמו באתר באשראי  : </strong>₪{{$amount_paid_in_skl}}<br>
            @if(!empty($remaining_amount_in_skl))
            <strong>הסכום שנותר לתשלום: </strong>₪{{$remaining_amount_in_skl}}<br>
            @endif
        </td>
    </tr>
</table>
