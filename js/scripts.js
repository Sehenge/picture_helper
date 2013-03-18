/**
 * Created with JetBrains PhpStorm.
 * User: sehenge
 * Date: 3/18/13
 * Time: 1:32 PM
 * To change this template use File | Settings | File Templates.
 */

function Helper() {
    this.imgCont = $(".img_container");
    this.imgContEyewear = this.imgCont.find(".eyewear");
    this.imgContrCases = this.imgCont.find(".cases");
}

Helper.prototype.InitEvents = function Helper_initEvents() {
    var self = this;
}

Helper.prototype.PrintImages = function Helper_printImages(data) {
    this.imgContEyewear.empty();
    this.imgContrCases.empty();
    var images = data.split(',');
    var cases = new Array();
    for (var key in images) {
        var image = images[key];
        if (image.indexOf('i:') !== -1) {
            this.imgContEyewear.append('<img src="' + image.substr(image.indexOf('i:')+2) + '"/><br/>');
        } else if (image.indexOf('c:') !== -1) {
            cases.push(image.substr(image.indexOf('c:')));
        }
    }
}