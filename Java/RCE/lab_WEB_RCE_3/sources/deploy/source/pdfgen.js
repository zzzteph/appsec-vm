var page = require('webpage').create(),
    system = require('system'),
    fs = require('fs');

page.paperSize = {
    format: 'A4',
    orientation: 'portrait',
    margin: {
        top: "1.5cm",
        bottom: "1cm"
    },
    footer: {
        height: "1cm",
        contents: phantom.callback(function (pageNum, numPages) {
            return '' +
                '<div style="margin: 0 1cm 0 1cm; font-size: 0.65em">' +
                '   <div style="color: #888; padding:20px 20px 0 10px; border-top: 1px solid #ccc;">' +
                '       <span>Generate by PhantomJS</span> ' +
                '       <span style="float:right">' + pageNum + ' / ' + numPages + '</span>' +
                '   </div>' +
                '</div>';
        })
    }
};

// This will fix some things that I'll talk about in a second
page.settings.dpi = "96";

page.content = fs.read(system.args[1]);

var output = system.args[2];

window.setTimeout(function () {
    page.render(output, {format: 'pdf'});
    phantom.exit(0);
}, 2000);
