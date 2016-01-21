<?php
namespace Sizzle;

/**
 * This class is for routing URI requests
 */
class Route
{
    protected $default;
    protected $endpointPieces;
    protected $endpointMap;
    protected $gets;

    /**
     * Includes appropriate file based on the provided endpoint pieces
     *
     * @param array $endpointPieces - the parsed pieces of the endpoint
     * @param array $gets           - associative array of GET variables
     */
    public function __construct($endpointPieces, $gets = array())
    {
        if (is_array($endpointPieces)) {
            $this->endpointPieces = $endpointPieces;
            $this->gets = $gets;
        }
        $this->default = __DIR__.'/../error.php';
    }

    /**
     * Includes appropriate file based on the provided endpoint pieces
     *
       PLEASE ADD A TEST TO src/RoutingTest.php FOR EACH ENDPOINT ADDED HERE
     */
    public function go()
    {
        if (!isset($this->endpointPieces[1])) {
            include __DIR__.'/../index.php';
        } else {
            switch ($this->endpointPieces[1]) {
            case '':
            case 'index.html':
                include __DIR__.'/../lp/sizzle1.php';
                break;
            case 'about':
                include __DIR__.'/../about.php';
                break;
            case 'activate':
                include __DIR__.'/../activate.php';
                break;
            case 'admin':
                if (!isset($this->endpointPieces[2]) || '' == $this->endpointPieces[2]) {
                    include __DIR__.'/../admin.php';
                } else {
                    switch ($this->endpointPieces[2]) {
                    case 'active_users':
                        include __DIR__.'/../admin/active_users.php';
                        break;
                    case 'add_city':
                        include __DIR__.'/../admin/add_city.php';
                        break;
                    case 'stalled_new_customers':
                        include __DIR__.'/../admin/stalled_new_customers.php';
                        break;
                    case 'tokens':
                        include __DIR__.'/../admin/token_stats.php';
                        break;
                    case 'transfer_token':
                        include __DIR__.'/../admin/transfer_token.php';
                        break;
                    case 'visitors':
                        include __DIR__.'/../admin/visitors.php';
                        break;
                    default:
                        include $this->default;
                    }
                }
                break;
            case 'ajax':
                include __DIR__.'/../ajax/route.php';
                break;
            case 'api_documentation':
                include __DIR__.'/../api_documentation.php';
                break;
            case 'create_company':
                include __DIR__.'/../create_company.php';
                break;
            case 'create_recruiting':
                include __DIR__.'/../create_recruiting.php';
                break;
            case 'free_trial':
                include __DIR__.'/../lp/free-trial.php';
                break;
            case 'forgot_password':
                include __DIR__.'/../forgot_password.php';
                break;
            case 'invoice':
                include __DIR__.'/../invoice.php';
                break;
            case 'js':
                if (!isset($this->endpointPieces[2]) || '' == $this->endpointPieces[2]) {
                    include $this->default;
                } else {
                    switch ($this->endpointPieces[2]) {
                    case 'pay_with_stripe.js':
                        include __DIR__.'/../pay_with_stripe.php';
                        break;
                    case 'JSXTransformer.js': // yuicompressor also barfs on this one
                        include __DIR__.'/../js/JSXTransformer.js';
                        break;
                    default:
                        include $this->default;
                    }
                }
                break;
            case 'password_reset':
                include __DIR__.'/../password_reset.php';
                break;
            case 'payments':
                include __DIR__.'/../payments.php';
                break;
            case 'pricing':
                include __DIR__.'/../pricing.php';
                break;
            case 'privacy':
                include __DIR__.'/../privacypolicy.php';
                break;
            case 'profile':
                include __DIR__.'/../profile.php';
                break;
            case 'recruiting_made_easy':
                include __DIR__.'/../lp/bc1.php';
                break;
            case 'terms':
                include __DIR__.'/../termsservice.php';
                break;
            case 'thankyou':
                include __DIR__.'/../thankyou.php';
                break;
            case 'token':
                if (isset($this->endpointPieces[2],$this->endpointPieces[3]) && 'recruiting' == $this->endpointPieces[2]) {
                    // don't display in native android browser
                    $detect = new \Mobile_Detect;
                    if ($detect->isMobile()) {
                        if (strpos($_SERVER['HTTP_USER_AGENT'], 'AppleWebKit') !== false
                            && strpos($_SERVER['HTTP_USER_AGENT'], 'Safari') === false
                            && strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') === false
                        ) {
                            include __DIR__.'/../get_chrome.html';
                            die;
                        }
                    }
                    include __DIR__.'/../recruiting_token.build.html';
                } else {
                    include $this->default;
                }
                break;
            case 'tokens':
                include __DIR__.'/../tokens.php';
                break;
            case 'token_responses':
                include __DIR__.'/../token_responses.php';
                break;
            case 'upgrade':
                include __DIR__.'/../upgrade.php';
                break;
            case 'upload':
                include __DIR__.'/../upload.php';
                break;
            case 'user':
                include __DIR__.'/../admin/user_info.php';
                break;
            case 'teapot':
                include __DIR__.'/../teapot.php';
                break;
            case 'test':
                // this endpoint is just for non-production testing
                if (ENVIRONMENT != 'production') {
                    include __DIR__.'/../lp/sizzle1.php';
                    break;
                }
            default:
                include $this->default;
            }
        }
    }

    /**
     * Register an endpoint for routing.
     *
     * @param string $endpoint   - the URI endpoint to process
     * @param string $fileToLoad - file to load for that endpoint
     *
     * @return boolean - was registration successful
     */
    public function register($endpoint, $fileToLoad)
    {
        $endpoint = ltrim($endpoint,'/');
        $endpointParts = explode('/', $endpoint);
        switch (count($endpointParts)) {
            case 0:
            $this->endpointMap[''] = $fileToLoad;
            break;
            case 1:
            $this->endpointMap[$endpointParts[0]] = $fileToLoad;
            break;
            case 2:
            if (!isset($this->endpointMap[$endpointParts[0]])) {
                $this->endpointMap[$endpointParts[0]] = array();
            } else {
                if (!is_array($this->endpointMap[$endpointParts[0]])) {
                    $temp = $this->endpointMap[$endpointParts[0]];
                    $this->endpointMap[$endpointParts[0]] = array();
                    $this->endpointMap[$endpointParts[0]][''] = $temp;
                }
            }
            $this->endpointMap[$endpointParts[0]][$endpointParts[1]] = $fileToLoad;
            break;
            case 3:
            if (!isset($this->endpointMap[$endpointParts[0]])) {
                $this->endpointMap[$endpointParts[0]] = array();
            } else {
                if (!is_array($this->endpointMap[$endpointParts[0]])) {
                    $temp = $this->endpointMap[$endpointParts[0]];
                    $this->endpointMap[$endpointParts[0]] = array();
                    $this->endpointMap[$endpointParts[0]][''] = $temp;
                }
            }
            if (!isset($this->endpointMap[$endpointParts[0]][$endpointParts[1]])) {
                $this->endpointMap[$endpointParts[0]][$endpointParts[1]] = array();
            } else {
                if (!is_array($this->endpointMap[$endpointParts[0]][$endpointParts[1]])) {
                    $temp = $this->endpointMap[$endpointParts[0]][$endpointParts[1]];
                    $this->endpointMap[$endpointParts[0]][$endpointParts[1]] = array();
                    $this->endpointMap[$endpointParts[0]][$endpointParts[1]][''] = $temp;
                }
            }
            $this->endpointMap[$endpointParts[0]][$endpointParts[1]][$endpointParts[2]] = $fileToLoad;
            break;
            case 4:
            if (!isset($this->endpointMap[$endpointParts[0]])) {
                $this->endpointMap[$endpointParts[0]] = array();
            } else {
                if (!is_array($this->endpointMap[$endpointParts[0]])) {
                    $temp = $this->endpointMap[$endpointParts[0]];
                    $this->endpointMap[$endpointParts[0]] = array();
                    $this->endpointMap[$endpointParts[0]][''] = $temp;
                }
            }
            if (!isset($this->endpointMap[$endpointParts[0]][$endpointParts[1]])) {
                $this->endpointMap[$endpointParts[0]][$endpointParts[1]] = array();
            } else {
                if (!is_array($this->endpointMap[$endpointParts[0]][$endpointParts[1]])) {
                    $temp = $this->endpointMap[$endpointParts[0]][$endpointParts[1]];
                    $this->endpointMap[$endpointParts[0]][$endpointParts[1]] = array();
                    $this->endpointMap[$endpointParts[0]][$endpointParts[1]][''] = $temp;
                }
            }
            if (!isset($this->endpointMap[$endpointParts[0]][$endpointParts[1]][$endpointParts[2]])) {
                $this->endpointMap[$endpointParts[0]][$endpointParts[1]][$endpointParts[2]] = array();
            } else {
                if (!is_array($this->endpointMap[$endpointParts[0]][$endpointParts[1]][$endpointParts[2]])) {
                    $temp = $this->endpointMap[$endpointParts[0]][$endpointParts[1]][$endpointParts[2]];
                    $this->endpointMap[$endpointParts[0]][$endpointParts[1]][$endpointParts[2]] = array();
                    $this->endpointMap[$endpointParts[0]][$endpointParts[1]][$endpointParts[2]][''] = $temp;
                }
            }
            $this->endpointMap[$endpointParts[0]][$endpointParts[1]][$endpointParts[2]][$endpointParts[3]] = $fileToLoad;
            break;
        }
    }
}