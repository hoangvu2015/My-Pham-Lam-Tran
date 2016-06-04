<div id="{{ $html_id }}" class="page-section widget-featured-reviews">
    <div class="container">
        @if(!empty($name))
            <div class="text-center">
                <h3 class="text-display-1"
                    style="border-bottom: 1px solid rgba(79,187,188,0.3);display: inline-block;padding-bottom: 5px">{{ $name }}</h3>
                @if(!empty($description))
                    <p class="lead text-muted">{{ $description }}</p>
                @endif
            </div>
            <br>
        @endif
        <div class="text-center">
            @if($randomIndex == 1)
                <a href="{{localizedURL('teacher/{id?}',['id'=>22])}}">
                    <img src="/dang-ky-hoc-thu-4/images/avatar0.png" alt="person" class="img-circle width-50 height-50">
                    <span style="font-size:16px;"> Lê Nguyễn Bích Thủy </span> </br>


                <span style="font-size:24px; line-height: 150%;"> <p class="">Chị Thủy hiện là giáo viên Tiếng Anh tại
                        THCS Đặng Công Bỉnh chia sẻ:
                        "Hôm nay, buổi học cuối khoá của con trai với cô giáo Pearl. Tâm trạng con trai
                        không thể hiện, nhưng mẹ thì cảm xúc đong đầy. Mẹ và con trai cùng cám ơn cô giáo.
                        Cuộc đời là chuỗi ngày gặp rồi xa nhau. Chúc nhau sự bình an và niềm vui. "
                    </p>

                    <p class="">
                        "Về ngữ pháp tiếng Anh thì chị đã dạy hết cho con rồi, nhưng để luyện giao tiếp thì
                        con cần được học với giáo viên nước ngoài. Ngay cả học sinh của chị chị cũng khuyên
                        chúng nó như vậy."</p>

                    <p class="tag" style="font-size:18px;">Nhật Minh tiếp tục đăng ký học khóa thứ 2 với gia sư <a
                                style="color:#00C0BA;" href="{{localizedURL('teacher/{id?}',['id'=>22])}}" target="_blank"
                                tabindex="0"><span>Ken</span></a>
                    </p>
                </span>
                </a>@endif

            @if($randomIndex == 2)
                <a href="{{localizedURL('teacher/{id?}',['id'=>61])}}">
                    <img src="/dang-ky-hoc-thu-4/images/avatar1.png" alt="person" class="img-circle width-50 height-50">
                    <span style="font-size:16px;"> Phạm Thị Hải Ninh </span> </br>


                <span style="font-size:24px; line-height: 150%;"> <p class="">“Gia sư của tôi rất nhiệt tình, kiên trì
                        hướng dẫn học viên. Tôi cảm thấy
                        được hỗ trợ tốt và có thể nâng cao khả năng giao tiếp. Thường cuối tuần tôi khá bận
                        và trong tuần cũng hay phải điều chỉnh lịch học nhưng gia sư vẫn linh động điều
                        chỉnh theo lịch của tôi. Vì thế nên tôi đã đặt lịch học với giáo viên Sagi trong 2
                        năm.”</p>

                    <p class="tag" style="font-size:18px;">Học <b>Professional English</b> với giáo viên <a
                                style="color:#00C0BA;" href="{{localizedURL('teacher/{id?}',['id'=>61])}}" target="_blank"
                                tabindex="0"><span>Sagi</span></a>
                    </p>
                </span>
                </a>@endif

            @if($randomIndex == 3)
                <a href="{{localizedURL('teacher/{id?}',['id'=>72])}}">
                    <img src="/dang-ky-hoc-thu-4/images/avatar2.png" alt="person" class="img-circle width-50 height-50">
                    <span style="font-size:16px;"> Nguyễn Bình Đức </span> </br>


                <span style="font-size:24px; line-height: 150%;"> <p class="">"Công việc của mình bận, thường xuyên phải
                        đi công tác nên hình thức học của
                        Antoree rất phù hợp với mình. Ngoài ra việc học cũng theo yêu cầu của mình nên
                        thường mình học giao tiếp để chuẩn bị cho các chuyến công tác nước ngoài. Giáo viên
                        Quỳnh Anh thì vui tính và nhiệt tình. Giọng cô cũng hay và ngữ pháp cô nắm chắc nên
                        cô củng cố giúp mình được cả phát âm và ngữ pháp. Cô cũng tâm lý và cách giảng dạy
                        dễ hiểu."</p>

                    <p class="tag" style="font-size:18px;">Học <b>Giao tiếp</b> với giáo viên <a style="color:#00C0BA;"
                                                                                                 href="{{localizedURL('teacher/{id?}',['id'=>72])}}"
                                                                                                 target="_blank"
                                                                                                 tabindex="0"><span>Quỳnh Anh</span></a>
                    </p>
                </span>
                </a>@endif

            @if($randomIndex == 4)
                <a href="{{localizedURL('teacher/{id?}',['id'=>57])}}">
                    <img src="/dang-ky-hoc-thu-4/images/avatar3.png" alt="person" class="img-circle width-50 height-50">
                    <span style="font-size:16px;"> Vũ Đức Dũng </span> </br>


                <span style="font-size:24px; line-height: 150%;"> <p class="">"Hình thức học của Antoree rất thú vị và
                        hiệu quả. Đây là lần đầu tiên mình
                        học với giáo viên bản ngữ mà lại được học trực tuyến. Vốn làm việc trong lĩnh vực
                        công nghệ, mình thật sự rất ấn tượng với hình thức học tiên tiến này. Giáo viên của
                        mình là cô Jonna giọng hay, dạy rất nhiệt tình và tận tâm. Phương pháp sư phạm của
                        cô cũng tốt và học vui. Mình đã chia sẻ với cộng đồng fan của minh trên Facebook,
                        Google và các bạn đã học cũng đều có phản hồi tốt về chất lượng giáo viên và dịch vụ
                        của Antoree."</p>
<p class="tag" style="font-size:18px;">Học <b>Giao tiếp</b> với giáo viên <a style="color:#00C0BA;"
                                                                             href="{{localizedURL('teacher/{id?}',['id'=>57])}}"
                                                                             target="_blank"
                                                                             tabindex="0"><span>Jonna</span></a>
</p>
                </span>
                </a>@endif


        </div>
    </div>
</div>

{{--<div id="{{ $html_id }}" class="page-section widget-featured-reviews">--}}
{{--<div class="container">--}}
{{--@if(!empty($name))--}}
{{--<div class="text-center">--}}
{{--<h3 class="text-display-1" style="border-bottom: 1px solid rgba(79,187,188,0.3);display: inline-block;padding-bottom: 5px">{{ $name }}</h3>--}}
{{--@if(!empty($description))--}}
{{--<p class="lead text-muted">{{ $description }}</p>--}}
{{--@endif--}}
{{--</div>--}}
{{--<br>--}}
{{--@endif--}}
{{--<div class="text-center">--}}
{{--@foreach($review->teachers as $teacher)--}}
{{--<a href="{{localizedURL('teacher/{id?}',['id'=>$teacher->id])}}">--}}
{{--<img src="{{$review->user->profile_picture}}" alt="person" class="img-circle width-50 height-50">--}}
{{--<span style="font-size:16px;"> {{$review->user->name}} </span> </br>--}}
{{--<span style="font-size:24px; line-height: 150%;"> {{escHtml($review->content)}} </span>--}}
{{--</a>--}}
{{--@endforeach--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}

