!function(a){var b=/iPhone/i,c=/iPod/i,d=/iPad/i,e=/(?=.*\bAndroid\b)(?=.*\bMobile\b)/i,f=/Android/i,g=/IEMobile/i,h=/(?=.*\bWindows\b)(?=.*\bARM\b)/i,i=/BlackBerry/i,j=/BB10/i,k=/Opera Mini/i,l=/(?=.*\bFirefox\b)(?=.*\bMobile\b)/i,m=new RegExp("(?:Nexus 7|BNTV250|Kindle Fire|Silk|GT-P1000)","i"),n=function(a,b){return a.test(b)},o=function(a){var o=a||navigator.userAgent,p=o.split("[FBAN");return"undefined"!=typeof p[1]&&(o=p[0]),this.apple={phone:n(b,o),ipod:n(c,o),tablet:!n(b,o)&&n(d,o),device:n(b,o)||n(c,o)||n(d,o)},this.android={phone:n(e,o),tablet:!n(e,o)&&n(f,o),device:n(e,o)||n(f,o)},this.windows={phone:n(g,o),tablet:n(h,o),device:n(g,o)||n(h,o)},this.other={blackberry:n(i,o),blackberry10:n(j,o),opera:n(k,o),firefox:n(l,o),device:n(i,o)||n(j,o)||n(k,o)||n(l,o)},this.seven_inch=n(m,o),this.any=this.apple.device||this.android.device||this.windows.device||this.other.device||this.seven_inch,this.phone=this.apple.phone||this.android.phone||this.windows.phone,this.tablet=this.apple.tablet||this.android.tablet||this.windows.tablet,"undefined"==typeof window?this:void 0},p=function(){var a=new o;return a.Class=o,a};"undefined"!=typeof module&&module.exports&&"undefined"==typeof window?module.exports=o:"undefined"!=typeof module&&module.exports&&"undefined"!=typeof window?module.exports=p():"function"==typeof define&&define.amd?define("isMobile",[],a.isMobile=p()):a.isMobile=p()}(this);

$(document).ready(function(){   
    if (!isMobile.any) {
        $(document).on('click', '.g-ajax-data', function(event){
            event.preventDefault();
            //$.arcticmodal('close');

            // var href = $(this).attr('href'),
            var href = $(this).attr('href') ? $(this).attr('href') : $(this).data('href'),
                specialId = $(this).attr('data-specialId');

            //Особый id для особых стилей особых страниц..)
            if (specialId != 'undefined') {
                specialId = 'id="'+specialId+'"';
            }
            $.arcticmodal({
            type: 'ajax',
            url: href,
            ajax: {
                    type: 'POST',
                    cache: false,
                    success: function(data, el, responce) {
                        var h = $('<div '+ specialId +'class="m-box-modal">' +
                                '<div class="box-modal_close arcticmodal-close" title="Закрыть"></div>' +
                                 responce +
                                '</div>');
                        data.body.html(h);
                    }
                }
            });
            return false;
        });
    }
});