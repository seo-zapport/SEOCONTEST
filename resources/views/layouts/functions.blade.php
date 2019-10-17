<!-- Mainly scripts -->
<script src="{{ asset('/js/jquery-2.1.1.js') }}"></script>
<script src="{{ asset('/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('/js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('/js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

<!-- Custom and plugin javascript -->
<script src="{{ asset('/js/inspinia.js') }}"></script>
<script src="{{ asset('/js/plugins/pace/pace.min.js') }}"></script>
<script src="{{ asset('/js/general.js') }}"></script>
<script src="{{ asset('js/plugins/validate/jquery.validate.min.js') }}"></script>


@if ( Request::is('system/theme-settings') || Request::is('system/theme-settings/*') || Request::is('system/profile') || Request::is('system/profile/*') || Request::is('system/media') || Request::is('system/media/*') || Request::is('system/banner') || Request::is('system/banner/*') || Request::is('system/pages') || Request::is('system/pages/*') )
    <script src="{{ asset('/js/plugins/dropzone/dropzone.js') }}"></script>
    <script src="{{ asset('/js/system-js/mediapages.js') }}"></script>
@endif

@if ( Request::is('system/theme-settings') || Request::is('system/theme-settings/*') || Request::is('system/pages') || Request::is('system/pages/*'))
    <script src="{{ asset('/js/plugins/tinymce/tinymce.js') }}"></script>
    <script src="{{ asset('/js/plugins/tinymce/tinymce.jquery.js') }}"></script>
@endif


@if ( Request::is('system/theme-settings') || Request::is('system/theme-settings/*') )

    <script src="{{ asset('/js/plugins/jasny/jasny-bootstrap.min.js') }}"></script>
    <script src="{{ asset('/js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('/js/plugins/colorpicker/bootstrap-colorpicker.min.js') }}"></script>
    <script src="{{ asset('/js/plugins/chosen/chosen.jquery.js') }}"></script>
    <script src="{{ asset('/js/plugins/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('/js/plugins/switchery/switchery.js') }}"></script>
    <script src="{{ asset('/js/system-js/theme-settings.js') }}"></script>
    <script src="{{ asset('/js/plugins/fullcalendar/moment.min.js') }}"></script>
    <script src="{{ asset('/js/plugins/daterangepicker/daterangepicker.js') }}"></script>
    
    <script type="text/javascript">
    $(document).ready(function(){
            var elem = document.querySelector('.js-switch');
            var switchery = new Switchery(elem, { color: '#1AB394' });
     });       
    </script>

@elseif( Request::is('system/admin') || Request::is('system/support'))

    <script src="{{ asset('/js/system-js/dashboard.js') }}"></script>

@elseif( Request::is('system/profile') || Request::is('system/profile/*'))

    <script src="{{ asset('/js/system-js/profile.js') }}"></script>

@elseif( Request::is('system/pages') || Request::is('system/pages/*'))

    <script src="{{ asset('/js/system-js/pages.js') }}"></script>
    <script src="{{ asset('/js/plugins/diff_match_patch/diff_match_patch.js') }}"></script>
    <script src="{{ asset('/js/plugins/preetyTextDiff/jquery.pretty-text-diff.min.js') }}"></script>
    

@elseif( Request::is('system/menu') || Request::is('system/menu/*') )

    <script src="{{ asset('/js/plugins/nestable/jquery.nestable.js') }}"></script>
    <script src="{{ asset('/js/system-js/menupages.js') }}"></script>
    
@elseif( Request::is('system/banner') || Request::is('system/banner/*') || Request::is('system/profile') || Request::is('system/profile/*'))

    <script src="{{ asset('/js/system-js/categorypages.js') }}"></script>
    <script src="{{ asset('/js/system-js/bannerpages.js') }}"></script>

@elseif( Request::is('system/contest') || Request::is('system/contest/*'))

    <script src="{{ asset('/js/system-js/participantpages.js') }}"></script>

    
@elseif( Request::is('system/merchant') || Request::is('system/merchant/*'))

    <script src="{{ asset('/js/system-js/merchantpages.js') }}"></script>

@elseif( Request::is('system/reward') || Request::is('system/reward/*'))

    <script src="{{ asset('/js/system-js/rewardpages.js') }}"></script>

@elseif( Request::is('system/account') || Request::is('system/account/*'))

    <script src="{{ asset('/js/system-js/accountpages.js') }}"></script>

@elseif ( Request::is('system/settings-general') )

    <script src="{{ asset('js/system-js/general-settings.js') }}"></script>

@elseif ( Request::is('system/bank') )

    <script src="{{ asset('js/system-js/bankpage.js') }}"></script>

@elseif ( Request::is('system/winner') || Request::is('system/winner/*') || Request::is('system/winner/merchantfilter') )

    <script src="{{ asset('/js/system-js/winpages.js') }}"></script>
    <script src="{{ asset('/js/plugins/chosen/chosen.jquery.js') }}"></script>
    <script src="{{ asset('/js/plugins/select2/select2.full.min.js') }}"></script>

@endif

@if (Request::is('system/*'))
    <script src="{{ asset('/js/plugins/footable/footable.all.min.js') }}"></script>
    <script>
            $(document).ready(function() {
                $('.footable').footable();
            });
    </script>
@endif 