<?php
/* Front Page Template */
get_header();

?>

    <div class="imageContainer">
        <div class="row">
            <div class="col-md-6">
                <div class="text_banner">
                    <h1 class="bannerHeading">A World Free From Sexual Violence</h1>
                    <p class="mainPara">Providing specialised support for survivors of sexual abuse & assault across Wellington, Porirua & Kapiti</p>
                </div>
                <div class="buttonBox">
                    <a href="https://carey.kwan.yoobee.net.nz/summative/shop/" class="action">Donate</a>
                    <a href="https://carey.kwan.yoobee.net.nz/summative/volunteer/" class="action">Volunteer</a>
                </div>
            </div>

            <div class="col-md-6">
                <div class="volunteerBox">
                    <h1 class="volun">Find an event</h1>
                    <p class="volunText">We are always looking for volunteers for events, so let us know about your skills, interests and availability</p>
                    <a href="https://carey.kwan.yoobee.net.nz/summative/volunteer/" class="volunButton">Volunteer here!</a>
                </div>
            </div>
        </div>
    </div>

    <div class="secondBanner">
        <h1 class="charity">Charities</h1>
            <div class="container">
                <div class="row logos">
                    <div class="col-xs-6 col-sm-3 one">
                        <img class="thumbLogo" src="<?php bloginfo('template_url') ?>/images/network.png" alt="network logo">
                        <a href="http://sexualabuseprevention.org.nz/" target='_blank' class="donateSite donate">Donate</a>
                    </div>

                    <div class="col-xs-6 col-sm-3 two">
                        <img class="thumbLogo" src="<?php bloginfo('template_url') ?>/images/nope.png" alt="nope logo">
                        <a href="https://www.nopesisters.com/" target='_blank' class="donateSite donate1">Donate</a>
                    </div>
                    
                    <div class="col-xs-6 col-sm-3 three">
                        <img class="thumbLogo" src="<?php bloginfo('template_url') ?>/images/wa.png" alt="wa logo">
                        <a href="https://wacollective.org.nz/" target='_blank' class="donateSite donate2">Donate</a>
                    </div>

                    <div class="col-xs-6 col-sm-3 four">
                        <img class="thumbLogo" src="<?php bloginfo('template_url') ?>/images/youth.png" alt="network logo">
                        <a href="https://www.youthline.co.nz/good2great.html" target='_blank' class="donateSite donate3">Donate</a>
                    </div>
                </div>
            </div>
    </div>

<?php get_footer(); ?>