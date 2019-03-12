<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{

    public function index() {
        $score = $this->calculateScore('sheyilaaw');
        return $score;
    }

    /**
     * @param $username
     * @return int
     */
    public function calculateScore(string $username) : int {
        $response = $this->callAPI('GET',"https://api.github.com/users/{$username}/events/public");
        $data = json_decode($response);
        $totalScore = 0;
        foreach($data as $obj){
            $eventType = $obj->type;
            $score = $this->assignScore($eventType);
            $totalScore+=$score;
        }
        return $totalScore;
    }

    /**
     * @param $method
     * @param $url
     * @param $data
     * @return string
     */
    public function callAPI(string $method, string $url, array $data = []): string {
        $curl = curl_init();

        switch ($method) {
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);

                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_PUT, 1);
                break;
            default:
                if ($data)
                    $url = sprintf("%s?%s", $url, http_build_query($data));
        }

        $config['useragent'] = 'Mozilla/5.0 (Windows NT 6.2; WOW64; rv:17.0) Gecko/20100101 Firefox/17.0';
        $config['headers'] = array(
            'Accept: application/json',
            'Content-Type: application/json',
        );
        curl_setopt($curl, CURLOPT_USERAGENT, $config['useragent']);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $config['headers']);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($curl);
        if(curl_errno($curl)){
            throw new Exception(curl_error($curl));
        }
        curl_close($curl);

        return $result;
    }

    /**
     * @param $eventType
     * @return int
     */
    public function assignScore($eventType) : int {
        $eventsPoints = [
            'PushEvent' => 10,
            'PullRequestEvent' => 5,
            'IssueCommentEvent' => 4
        ];
        $points = array_key_exists($eventType, $eventsPoints) ? $eventsPoints[$eventType] : 1;
        return $points;
    }
}
