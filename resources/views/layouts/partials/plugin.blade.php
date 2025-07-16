<script src="{{ asset('libs/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('libs/metismenu/metisMenu.min.js') }}"></script>
<script src="{{ asset('libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('libs/node-waves/waves.min.js') }}"></script>
<script>
    function getChartColorsArray(e) {
        if (null !== document.getElementById(e)) {
            var t = document.getElementById(e).getAttribute("data-colors");
            if (t)
                return (t = JSON.parse(t)).map(function(e) {
                    var t = e.replace(" ", "");
                    if (-1 === t.indexOf(",")) {
                        var r = getComputedStyle(
                            document.documentElement
                        ).getPropertyValue(t);
                        return r || t;
                    }
                    var a = e.split(",");
                    return 2 != a.length ?
                        t :
                        "rgba(" +
                        getComputedStyle(
                            document.documentElement
                        ).getPropertyValue(a[0]) +
                        "," +
                        a[1] +
                        ")";
                });
        }
    }
</script>
@stack('js')
<!-- App js -->
<script src="{{ asset('js/app.js') }}"></script>

@livewireScripts
<script id="sweetalert-js" src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
<x-livewire-alert::scripts />
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mengambil tema dari localStorage atau default ke 'dark' jika tidak ada
        const savedTheme = localStorage.getItem('theme') || 'light';
        setTheme(savedTheme);

        // Listen to Livewire event to change the theme
        Livewire.on('themeChanged', theme => {
            setTheme(theme);
        });

        // Function to dynamically change theme
        function setTheme(theme) {
            const themeCssLink = document.getElementById('theme-css');
            const sweetalertJs = document.getElementById('sweetalert-js');

            if (theme === 'dark') {
                // Apply dark theme
                themeCssLink.href = 'https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark/dark.css';
            } else {
                // Apply borderless or other light theme
                themeCssLink.href = 'https://cdn.jsdelivr.net/npm/@sweetalert2/theme-default/default.css';
            }

            // Save the theme to localStorage
            localStorage.setItem('theme', theme);
        }


    });
</script>
