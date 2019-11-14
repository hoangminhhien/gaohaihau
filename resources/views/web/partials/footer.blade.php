<div class="container-fluid">
    <section id="footer" class="row">
        <div class="col-sm-6">
            <div class="row">
                <div class="col-sm-5 info">
                    <a href="tel:{{ config('common.footer_info.hotline_fedback') }}" class="info-text">
                        <i class="fa fa-phone-square"></i>
                        {{ CommonHelper::formatPhonenumber(config('common.footer_info.hotline_fedback')) }}
                    </a>
                </div>
                <div class="col-sm-7 info">
                    <a href="{{ config('common.footer_info.address_link') }}" target="_bank" class="info-text"><i class="fas fa-map-marker-alt"></i>
                        {{ config('common.footer_info.address') }}
                    </a>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="row">
                <div class="col-sm-7 info">
                    <a href="mailto:{{ config('common.footer_info.email') }}" class="info-text">
                        <i class="fa fa-envelope"></i>
                        {{ config('common.footer_info.email') }}
                    </a>
                </div>
                <div class="col-sm-5 info">
                    <a href="{{ config('common.footer_info.facebook_link') }}" target="_bank" class="info-text">
                        <i class="fab fa-facebook"></i>
                        {{ config('common.footer_info.facebook') }}
                    </a>
                </div>
            </div>
        </div>
        <div class="bg-footer"
            style="background: url('{{ asset('/images/bg-footer.jpg') }}')"
        ></div>
    </section>

    <section id="copyright" class="row">
        <div class="col-xs-12">
            {{ config('common.footer_info.copyright') }}
        </div>
    </section>
</div>
