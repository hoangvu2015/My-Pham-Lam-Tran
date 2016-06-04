@section('sidebar_footer')
    <style>
        .footer-section {margin-bottom: 0;}
        .bottom-footer body {padding-bottom: 0 !important;}
    </style>
    <section class="footer-section">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-md-3">
                    {!! widget('left_footer') !!}
                </div>
                <div class="col-sm-6 col-md-3">
                    {!! widget('middle_footer') !!}
                </div>
                <div class="col-xs-12 col-md-6">
                    {!! widget('right_footer') !!}
                </div>
            </div>
        </div>
        {!! widget('bottom_footer', '<div id="bottom-footer-widgets">', '</div>') !!}
    </section>
@show