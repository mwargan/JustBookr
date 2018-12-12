<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'JustBookr') }}</title>



    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">

    <style>

    .navbar {
        font-weight: 500;
        border-bottom: 1px solid #dee9f2;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.04);
    }

.navbar-nav {
    flex-direction: row;
}

.b-nav {
    height: 4.1rem;
    border-top: 1px solid #dee9f2;
}

.invalid-feedback {
    display: block;
}

@media (min-width: 992px) {
    .b-nav {
        display: none;
    }
    #page-footer {
        padding-bottom: initial;
    }
}
    </style>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-76122959-2"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-76122959-2');
</script>
  <!-- Facebook Pixel Code -->
<script>

 // Hotjar Tracking Code for justbookr.com
    (function(h,o,t,j,a,r){
        h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
        h._hjSettings={hjid:1126144,hjsv:6};
        a=o.getElementsByTagName('head')[0];
        r=o.createElement('script');r.async=1;
        r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
        a.appendChild(r);
    })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
</script>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top">
        <div class="container" style="max-width: 100%;">
            <a class="navbar-brand"  href="{!! url('/') !!}">
                <img itemprop="image" src="/images/logoDark.svg" height="45" alt="JustBookr Logo" />
                JustBookr
            </a>
            <div class="collapse navbar-collapse" id="navbarToggler">
                <ul data-v-5f14decd="" class="navbar-nav mr-auto mt-2 mt-lg-0"></ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="{{ url('/login') }}" class="nav-link btn" active-class="active">
                            Log in
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/register') }}" class="nav-link btn" active-class="active">
                            Sign up
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container body-content">
        @yield('content')
    </div>

      <nav class="navbar fixed-bottom navbar-light navbar-expand-lg bg-white b-nav">
            <ul class="navbar-nav w-100 d-flex justify-content-between">
                    <li class="nav-item">
                        <a href="{{ url('/login') }}" class="nav-link py-1 m-3" active-class="active">
                            Log in
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/register') }}" class="nav-link py-1 m-3 text-primary" active-class="active">
                            Sign up
                        </a>
                    </li>
            </ul>
        </nav>

    <!-- Scripts -->


{{--     <script src="{{ asset('js/app.js') }}"></script>
 --}}    {{-- <script type="text/javascript">
        $(function(){

             // sends the uploaded file file to the fielselect event
            $(document).on('change', ':file', function() {
                var input = $(this);
                var label = input.val().replace(/\\/g, '/').replace(/.*\//, '');

                input.trigger('fileselect', [label]);
            });

            // Set the label of the uploaded file
            $(':file').on('fileselect', function(event, label) {
                $(this).closest('.uploaded-file-group').find('.uploaded-file-name').val(label);
            });

            // Deals with the upload file in edit mode
            $('.custom-delete-file:checkbox').change(function(e){
                var self = $(this);
                var container = self.closest('.input-width-input');
                var display = container.find('.custom-delete-file-name');

                if (self.is(':checked')) {
                    display.wrapInner('<del></del>');
                } else {
                    var del = display.find('del').first();
                    if (del.is('del')) {
                        del.contents().unwrap();
                    }
                }
            }).change();

            // Sets the validator defaults
            $.validator.setDefaults({
                errorElement: "span",
                errorClass: "help-block",
                highlight: function (element, errorClass, validClass) {
                    $(element).closest('.form-group').addClass('has-error');
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).closest('.form-group').removeClass('has-error');
                },
                errorPlacement: function (error, element) {
                    if (element.parent('.input-group').length) {
                        error.insertAfter(element.parent());
                    } else if(element.prop('type') === 'checkbox' || element.prop('type') === 'radio') {
                        error.appendTo(element.closest(':not(input, label, .checkbox, .radio)').first());
                    } else {
                        error.insertAfter(element);
                    }
                }
            });

            // Makes sure any input with the required class is actually required
            $('form').each(function(index, item){
                var form = $(item);
                form.validate();

                form.find(':input.required').each(function(i, input){
                    $(input).attr('required', true);
                });
            });

        });
    </script> --}}

</body>
</html>
