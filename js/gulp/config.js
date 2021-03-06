var p = require('./util/PathHelper').create('css', 'js', 'vendor'),
    path = require('path');

module.exports = {
    output: {
        js_build: path.join('public', 'js', 'dist'),
        js_mnm: path.join('public', 'js'),
        css_build: path.join('public', 'css', 'dist'),
        css_mnm: path.join('public', 'css'),
        polybuild: '.'
    },
    builds: {
        /**
         * MAIN SIZZLE APPLICATION BUILD
         */
        sizzle: {
            vendor_js: [
            /** TODO: These should generally be pulled from one of the package manager directories **/
                p.vendor_js('bootstrap.min'),
                p.vendor_js('smoothscroll'),
                p.vendor_js('jquery.scrollTo.min'),
                p.vendor_js('jquery.localScroll.min'),
                p.vendor_js('jquery-ui.min'),
                p.vendor_js('simple-expand.min'),
                p.vendor_js('wow'),
                p.vendor_js('jquery.stellar.min'),
                p.vendor_js('retina-1.1.0.min'),
                p.vendor_js('matchMedia'),
                p.vendor_js('jquery.ajaxchimp.min')
            ],
            vendor_css: [
                p.css('owl.theme'),
                p.css('owl.carousel'),
                p.css('font-awesome.min'),
                p.css('animate')
            ],
            js: [
                p.js('Sizzle'),
                p.component('Form'),
                p.component('Slider'),
                p.controller('controller_factory'),
                p.controller('Pricing'),
                p.js('custom'),
                p.js('account')
            ],
            css: [
                // Vanilla css
                p.css('styles'),

                // Stylus
                p.styl('variables'),
                p.styl('Pricing')
            ]
        },

        /**
         * API DOCUMENTATION BUILD
         */
        api_documentation: {
            vendor_js: [
                p.vendor_js('jquery-migrate-1.2.1.min'),
                p.vendor_js('jquery.slideto.min'),
                p.vendor_js('jquery.wiggle.min'),
                p.vendor_js('jquery.ba-bbq.min'),
                p.vendor_js('handlebars-2.0.0.min'),
                p.vendor_js('highlight.7.3.pack'),
                p.vendor_js('underscore-min'),
                p.vendor_js('backbone-min'),
                p.vendor_js('swagger-ui.min'),
                p.vendor_js('highlight.7.3.pack'),
                p.vendor_js('jsoneditor.min'),
                p.vendor_js('marked.min'),
                p.vendor_js('swagger.oath.min')
            ],
            vendor_css: [],
            js: [],
            css: []
        }
    },

    polybuild: [
        'recruiting_token.php'
    ],

    minify_and_migrate: {
        js: [
            p.vendor_js('react.min'),
            p.vendor_js('JSXTransformer'),
            p.js('create_common'),
            p.js('create_recruiting'),
            p.js('free-trial.min'),
            p.js('contact'),
            p.js('login'),
            p.js('signup'),
            p.js('linkedin-scraper')
        ],

        json: [
            path.join('js', 'api-v1.json')
        ],

        css: [
            p.css('create_recruiting'),
            p.css('datatables'),
            p.css('at-at'),
            p.css('ball-robot')
        ]
    }
};
