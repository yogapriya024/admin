<?php

namespace App\Http\Controllers;

use App\Imports\Importer;
use App\Mail\LeadEmail;
use Illuminate\Http\Request;
use Excel;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;

class VendorController extends Controller
{
    // List of allowed page extensions
    public $allowedExtensions = array('.css', '.xml', '.rss', '.ico', '.js', '.gif', '.jpg', '.jpeg', '.png', '.bmp', '.wmv'
    , '.avi', '.mp3', '.flash', '.swf', '.css', '.pdf');

    public $startPath;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = [];
        if ($request->hasFile('excel')) {
            $rows = Excel::toArray(new Importer, $request->file('excel'));
            $data = $rows[0];
            array_walk_recursive($data, function(&$v) {
                $v = trim($v);
            });

        }
        return view('vendor.index', compact('data'));
    }

    public function getEmail($url)
    {
        $sPageContent = $this->getPageContent($url);
        preg_match_all('/([\w+\.]*\w+@[\w+\.]*\w+[\w+\-\w+]*\.\w+)/is', $sPageContent, $aResults);
        $resutls = array_filter($aResults);
        if (!empty($resutls)) {
            return $aResults;
        }
        return false;
    }

    public function searchEmail($url)
    {
        $urls = $this->getUrls($url);
        $email = [];
        $start = microtime(true);
        $limit = 30;
        foreach ($urls as $url) {
            $rslt = $this->getEmail($url);
            if ($rslt) {
                $email[] = array_unique(Arr::flatten($rslt));
            }
            if (microtime(true) - $start >= $limit) {
                break;
            }
        }

        return $this->multi_unique($email);
    }

    public function multi_unique($src)
    {
        $output = array_map("unserialize",
            array_unique(array_map("serialize", $src)));
        return array_unique(Arr::flatten($output));
    }

    public function sendMail(Request $request)
    {
        for ($i = 0; $i < count($request->email); $i++) {
            $mail = [
                'view' => 'mail.vendor',
                'subject' => 'Looking for ' . $request->location[$i] . ' based ' . $request->request_for[$i],
                'location' => $request->location[$i],
                'request' => $request->request_for[$i],
                'to' => env('email_to', $request->email[$i])
            ];
            $this->sendEmail($mail);

        }
        return redirect()->back()->with('success', 'Email Sent Successfully');
    }

    /**
     * @param $inputs
     */
    public function sendEmail($inputs)
    {
        Mail::to($inputs['to'])
            ->cc(env('email_cc'))
            ->send(new LeadEmail($inputs));
    }

    function cleanListURLs($linkList)
    {
        foreach ($linkList as $sub => $url) {
            $allowed = true;
            if (strlen($url) <= 1) {
                unset($linkList[$sub]);
            }
            if (strpos($url, 'googleapis') !== false) {
                $allowed = false;
                unset($linkList[$sub]);
            }
            if (strpos($url, '#') !== false) {
                $allowed = false;
                unset($linkList[$sub]);
            }
            if (strpos($url, 'xmlrpc') !== false) {
                $allowed = false;
                unset($linkList[$sub]);
            }
            if (strpos($url, 'wp-json') !== false) {
                $allowed = false;
                unset($linkList[$sub]);
            }
            str_replace($this->allowedExtensions, '', $url, $count);
            if ($count > 0) {
                $allowed = false;
                unset($linkList[$sub]);
            }
            if (substr($url, 0, 1) == '#') {
                $allowed = false;
                unset($linkList[$sub]);
            }

            // If everything is OK and path is relative, add starting path
            if (!$this->checkValidUrl($url) && $allowed) {
                if (strpos($url,'http') == false){
                    $newurl = $linkList[$sub] = $this->startPath . $url;
                    if (!$this->checkValidUrl($newurl)){
                        unset($linkList[$sub]);
                    }else{

                        $linkList[$sub] = $newurl;
                    }
                }else{
                    $linkList[$sub] = $url;
                }

            }
        }
        return $linkList;
    }

    public function getUrls($url)
    {
        $parsed = parse_url($url);
        if (empty($parsed['scheme'])) {
            $url = 'http://'.$url;
        }
        $this->setStartPath($url);
        $pageContent = $this->getPageContent($url);
        preg_match_all('/href="([^"]+)"/Umis', $pageContent, $results);
        $currentList = $this->cleanListURLs($results[1]);
        return $currentList;
    }

    public function getPageContent($url)
    {
        if (function_exists('curl_init')) {
            $rCh = curl_init();
            curl_setopt($rCh, CURLOPT_URL, $url);
            curl_setopt($rCh, CURLOPT_HEADER, 0);
            curl_setopt($rCh, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($rCh, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($rCh, CURLOPT_SSL_VERIFYPEER, false);
            $mResult = curl_exec($rCh);
            curl_close($rCh);
            unset($rCh);
            $sPageContent = $mResult;
        } else {
            if (strpos($url,'mailto') === false){
                $sPageContent = file_get_contents($url);
            }else{
                $sPageContent = $url;
            }

        }
        return $sPageContent;
    }

    function setStartPath($path = NULL)
    {
        if (!is_null($path)) {
            if (substr($path, -1) != '/') {
                $path = $path . '/';
            }
            $this->startPath = $path;
        }
    }

    function checkValidUrl($url)
    {
        return filter_var($url, FILTER_VALIDATE_URL);
    }

    public function extractEmail(Request $request)
    {
        $emails = $this->searchEmail($request->url);
        $emails = array_values($emails);
        return json_encode($emails);
    }
}
