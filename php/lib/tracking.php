
<!-- Matomo -->

<script type = "text/javascript">

    var _paq = _paq || [];


    _paq.push([function() { 
        var self = this; 
        function getOriginalVisitorCookieTimeout() {  
              
            var now = new Date(),        
            nowTs = Math.round(now.getTime() / 1000),        
            visitorInfo = self.getVisitorInfo();        
            var createTs = parseInt(visitorInfo[2]);        
            var cookieTimeout = 33696000;               // 13 mois en secondes        
            var originalTimeout = createTs + cookieTimeout - nowTs;        

            return originalTimeout;  
        }  
        this.setVisitorCookieTimeout( getOriginalVisitorCookieTimeout() );  
    }]);
        

    _paq.push(['trackPageView']);
    _paq.push(['enableLinkTracking']);

    (function() {

        var url = "//imagotv.fr/analytics/";
            
        _paq.push(['setTrackerUrl', url + 'piwik.php']);
        _paq.push(['setSiteId', '1']);
    
        var d = document; 

        g = d.createElement('script');      
        g.type = 'text/javascript'; 
        g.async = true; 
        g.defer = true; 
        g.src = url + 'piwik.js'; 

        s = d.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(g,s);

    })();

</script>



