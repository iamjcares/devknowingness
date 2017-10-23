<h4 style="text-align: left;"><strong><span style="color: #ff0000;"><sup>&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Select Currency</sup></span></strong></h4>	&nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp;	<img src="{{ $env.protocol }}://ffcustoms.com/files/images/canada.png" width="45px" height="27px" Alt="View prices in CAN Dollars" title="View prices in Canadian Dollars" style="cursor: hand; cursor:pointer;" onclick="dc_select_currency('CAD');"/>
<img src="{{ $env.protocol }}://ffcustoms.com/files/images/united-states.png" width="45px" height="27px" Alt="View prices in USD Dollars" title="View prices in USD Dollars" style="cursor: hand; cursor:pointer;" onclick="dc_select_currency('USD');"/>
<p></p>
<p><a href="http://ffcustoms.com/p-37490-website-navigation-help.html"><img style="cursor: pointer; display: block; margin-left: auto; margin-right: auto;" title="Website Navigation Help?" src="{{ $env.protocol }}://ffcustoms.com/files/images/helpvideoiconclear.png" alt="Free shipping Canada &amp; USA" width="92" height="50" /></a></p><div class="list-group have-a-question side-nav" style="display: none;">
    <h3>{{ $store->config.title }} <span>Difference</span></h3>
    <a class="list-group-item" href="/contact.html" title="{{ $store->config.title }} Difference">
        <i class="fa fa-2x fa-users fa-fw" aria-hidden="true"></i>
        <strong>We're the Experts</strong><br />
        <span>Ask us anything. We are the professionals!</span>
    </a>
    <a class="list-group-item" href="/catalog.html" title="Largest Selection">
        <i class="fa fa-2x fa-cubes fa-fw" aria-hidden="true"></i>
        <strong>Largest Selection</strong><br />
        <span>If you don't find the part, we'll get it for you!</span>
    </a>
    <a class="list-group-item" href="{{ $faq_returns_url }}" title="Phone">
        <i class="fa fa-2x fa-truck fa-fw" aria-hidden="true"></i>
        <strong>Free Shipping</strong><br />
        <span>On any orders over $50</span>
    </a>
</div>
<div align="center" style="margin: 0px; padding: 0px; border: 2px solid rgb(136, 136, 136); width: 240px; background-color: rgb(255, 255, 255);"><div align="center" style="width: 100%; border-bottom: 1px solid rgb(136, 136, 136); margin: 0px; padding: 0px; text-align: center; color: rgb(0, 0, 0); background-color: rgb(204, 204, 204);"><a class="V2label" href="https://fx-rate.net/CAD/USD/" style="text-decoration: none; font-size: 12px; font-weight: bold; text-align: center; font-family: Arial; margin-bottom: 6px; color: rgb(0, 0, 0);"><img src="{{ $env.protocol }}://fx-rate.net/images/countries/ca.png" style="margin: 0px; padding: 0px; border: none;"> Canadian Dollar to <img src="{{ $env.protocol }}://fx-rate.net/images/countries/us.png" style="margin: 0px; padding: 0px; border: none;"> American Dollar</a></div><script type="text/javascript" src="{{ $env.protocol }}://fx-rate.net/converter.php?layout=vertical&amount=1000&tcolor=000000&currency=CAD&currency_pair=USD&default_pair=CAD/USD"></script></div>
<p>&nbsp;</p>
<div class="list-group have-a-question side-nav">
    <h3>Have a <strong>question?</strong></h3>
    <a class="list-group-item" href="/contact.html" title="Email us">
        <i class="fa fa-envelope fa-2x" aria-hidden="true"></i>
        <strong>Email Us</strong><br />
        <span>Get answers from the pros</span>
    </a>
    <a class="list-group-item" href="tel:{{ if $store->config.toll_free }}{{ $store->config.toll_free }}{{ else }}{{ $store->config.phone }}{{ /if }}" title="Call Us">
        <i class="fa fa-2x fa-mobile fa-fw" aria-hidden="true"></i>
        <strong>Call Us</strong><br />
        <span>Give us a call now!<br />{{ if $store->config.toll_free }}{{ $store->config.toll_free }}{{ else }}{{ $store->config.phone }}{{ /if }}</span>
    </a>
    <a class="list-group-item" href="sms:+1-613-604-0222" title="text us">
        <i class="fa fa-commenting fa-2x fa-fw" aria-hidden="true"></i>

        <strong>SMS Message!</strong>
        <span class="phone-num">Text now! 613-604-0222</span>
    </a>
</div>
<div id="y-badges" class="yotpo yotpo-badge badge-init">&nbsp;</div>
