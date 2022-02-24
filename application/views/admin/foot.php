<div class="footer-wrapper">
    <div class="footer-section f-section-1">
        <p class="">Copyright © <?= date('Y') ?> <a target="_blank" href="<?= base_url(); ?>">Kolaan</a>, All rights reserved.</p>
    </div>
    <div class="footer-section f-section-2">
        <p class="">Coded with <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg> by <a href="https://www.evolusi.id/" target="_blank">Evolusi.ID</a></p>
    </div>
</div>
</div>
<script src="<?= base_url('assets/bootstrap/js/popper.min.js') ?>"></script>
<script src="<?= base_url('assets/bootstrap/js/bootstrap.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js') ?>"></script>
<script src="<?= base_url('assets/js/app-1.js') ?>"></script>
<script>
    $(document).ready(function() {
        App.init();
    });
</script>
<script src="<?= base_url('assets/js/custom.js') ?>"></script>
<script src="<?= base_url('assets/plugins/jquery-ui/jquery-ui.min.js') ?>"></script>
<script>
    $(document).on("click", ".linkajax", function (e, i) {
        e.preventDefault()
        var url = $(this).attr("href");
        var title = $(this).attr("title");
        var formData = new FormData();
        formData.append("ajax", "YES");
        var xmlhttp = new XMLHttpRequest();
        $(this).parent().addClass('active').siblings().removeClass('active');
		xmlhttp.onreadystatechange = function() {
			if (this.readyState == XMLHttpRequest.DONE && this.status == 200) {
                document.querySelector('title').innerHTML = title
                document.querySelector('#judulPage').innerHTML = title
                history.replaceState(title, title, url)
                var $konten = document.querySelector('#content')
                $konten.innerHTML = this.responseText
                runScripts($konten)
			}
		};
		xmlhttp.open("POST", url, true);
		xmlhttp.send(formData);
    })

    function seq(arr, callback, index) {
        if (typeof index === 'undefined') {
            index = 0
        }

        arr[index](function () {
            index++
            if (index === arr.length) {
            callback()
            } else {
            seq(arr, callback, index)
            }
        })
    }

    function scriptsDone() {
        var DOMContentLoadedEvent = document.createEvent('Event')
        DOMContentLoadedEvent.initEvent('DOMContentLoaded', true, true)
        document.dispatchEvent(DOMContentLoadedEvent)
    }

    function insertScript($script, callback) {
        var s = document.createElement('script')
        s.type = 'text/javascript'
        if ($script.src) {
            s.onload = callback
            s.onerror = callback
            s.src = $script.src
        } else {
            s.textContent = $script.innerText
        }

        document.head.appendChild(s)
        $script.parentNode.removeChild($script)
        if (!$script.src) {
            callback()
        }
    }

    var runScriptTypes = [
        'application/javascript',
        'application/ecmascript',
        'application/x-ecmascript',
        'application/x-javascript',
        'text/ecmascript',
        'text/javascript',
        'text/javascript1.0',
        'text/javascript1.1',
        'text/javascript1.2',
        'text/javascript1.3',
        'text/javascript1.4',
        'text/javascript1.5',
        'text/jscript',
        'text/livescript',
        'text/x-ecmascript',
        'text/x-javascript'
    ]

    function runScripts($konten) {
        var $scripts = $konten.querySelectorAll('script')
        var runList = []
        var typeAttr

        [].forEach.call($scripts, function ($script) {
            typeAttr = $script.getAttribute('type')

            if (!typeAttr || runScriptTypes.indexOf(typeAttr) !== -1) {
            runList.push(function (callback) {
                insertScript($script, callback)
            })
            }
        })

        seq(runList, scriptsDone)
    }
</script>
</body>
</html>