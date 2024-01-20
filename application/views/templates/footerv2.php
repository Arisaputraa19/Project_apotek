<?php
$categoriesLimit = $this->Categories_model->getCategoriesLimit();
$setting = $this->Settings_model->getSetting();
?>

    <footer class="bg-info">
        <div class="copyright">
            <p class="mb-0">Copyright &copy; <span id="footer-cr-years"></span></p>
        </div>
    </footer>

        <?php
        if($this->session->userdata('login')){
            $cart = $this->db->get_where('cart', ['user' => $this->session->userdata('id')]);
            $totalall = 0;
            foreach($cart->result_array() as $c){
                $totalall += intval($c['price']) * intval($c['qty']);
            }
        }
        ?>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="<?= base_url(); ?>assets/js/jquery.countdown.min.js"></script>
    <script src="<?= base_url(); ?>assets/lightbox2-2.11.1/dist/js/lightbox.js"></script>
    <script src="<?= base_url(); ?>assets/select2-4.0.6-rc.1/dist/js/select2.min.js"></script>
    <script>
        $('.recent-product').slick({
            infinite: false,
            slidesToShow: 6,
            slidesToScroll: 1
        });

        $("i.icon-search-navbar").on('click', function(){
            $("div.search-form").slideDown('fast');
            $("div.search-form input").focus();
        })

        $("div.search-form i").on('click', function(){
            $("div.search-form").slideUp('fast');
        })

        $("i.fa-bars").on('click', function(){
            $("div.dropdown-mobile-menu").slideToggle('fast');
        })

        $("div.product-wrapper div.main-product button.slick-prev").html("<i class='fa fa-chevron-left'></i>")
        $("div.product-wrapper div.main-product button.slick-next").html("<i class='fa fa-chevron-right'></i>")

        const years = new Date().getFullYear();
        $("#footer-cr-years").text(years);

        //loading screen
        $(window).ready(function(){
            $(".loading-animation-screen").fadeOut("slow");
        })

        // detail
        $("#detailBtnPlusJml").click(function(){
            var val = parseInt($(this).prev('input').val());
            $(this).prev('input').val(val + 1).change();
            return false;
        })

        $("#detailBtnMinusJml").click(function(){
            var val = parseInt($(this).next('input').val());
            if (val !== 1) {
                $(this).next('input').val(val - 1).change();
            }
            return false;
        })

        function number_format (number, decimals, decPoint, thousandsSep) {
            number = (number + '').replace(/[^0-9+\-Ee.]/g, '')
            var n = !isFinite(+number) ? 0 : +number
            var prec = !isFinite(+decimals) ? 0 : Math.abs(decimals)
            var sep = (typeof thousandsSep === 'undefined') ? ',' : thousandsSep
            var dec = (typeof decPoint === 'undefined') ? '.' : decPoint
            var s = ''

            var toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec)
            return '' + (Math.round(n * k) / k)
                .toFixed(prec)
            }

            // @todo: for IE parseFloat(0.55).toFixed(0) = 0;
            s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.')
            if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep)
            }
            if ((s[1] || '').length < prec) {
            s[1] = s[1] || ''
            s[1] += new Array(prec - s[1].length + 1).join('0')
            }

            return s.join(dec)
        }

    </script>
</html>
