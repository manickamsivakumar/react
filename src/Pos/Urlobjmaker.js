import qs from 'qs';

class Urlobjmaker {

    constructor(postdata, callmethodname, calltype = "POST") {
        //var retkval = 0;
        //location.origin
        this.postdata = postdata;
        this.callmethodname = callmethodname;
        this.calltype = calltype;
        this.domain = 'https://dev.skyhms.in/mob_mis_v2/';
        this.madeurl = 'https://dev.skyhms.in/mob_mis_v2/' + this.callmethodname;
        this.options = function () {
            return {
                url: this.madeurl,
                async: false,
                type: this.calltype,
                data: { postdetails: this.postdata },
                dataType: "json"
            }
        }
    }
}

export default Urlobjmaker;

