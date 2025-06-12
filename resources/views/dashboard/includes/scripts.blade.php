<!--begin::Javascript-->
<!--begin::Global Javascript Bundle(used by all pages)-->
    <script src="{{ asset('mazer/assets/static/js/components/dark.js') }}"></script>
    <script src="{{ asset('mazer/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('mazer/assets/compiled/js/app.js') }}"></script>
    <script src="{{ asset('mazer/assets/extensions/jquery/jquery.min.js') }}"></script>
    <script>
        function formSubmit(obj){
            $(obj).find(".indicator-label").addClass("d-none");
            $(obj).find(".indicator-progress").removeClass("d-none");
        }
    </script>
<!--end::Global Javascript Bundle-->

<!--begin::Page Custom Javascript-->    
    @stack('scripts')
<!--end::Page Custom Javascript-->

<!--end::Javascript-->