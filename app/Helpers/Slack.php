<?php declare(strict_types = 1);

namespace App\Helpers;
use App\Exceptions\SlackException;

class Slack
{
    public static function getUserDetails(string $token): UserDetails
    {
        return new UserDetails('abc', '123');
        $url = "https://slack.com/api/auth.test?token=$token";

        $response = json_decode(file_get_contents($url));

        if (!$response->ok) {
            throw new SlackException;
        }

        if (!array_key_exists('user_id', $response) || !array_key_exists('team_id', $response)) {
            throw new SlackException;
        }

        return new UserDetails($response['user_id'], $response['team_id']);
    }
}

class UserDetails
{
    public $userId;
    public $teamId;

    public function __construct(string $userId, string $teamId)
    {
        $this->userId = $userId;
        $this->teamId = $teamId;
    }

    public function __toString(): string
    {
        return "$this->userId.$this->teamId";
    }
}