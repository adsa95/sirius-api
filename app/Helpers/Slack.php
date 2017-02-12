<?php declare(strict_types = 1);

namespace App\Helpers;

// Exceptions
use App\Exceptions\SlackTokenException;

class Slack
{
    public static function getUserDetails(string $token): UserDetails
    {
        $url = "https://slack.com/api/auth.test?token=$token";

        $response = json_decode(file_get_contents($url));

        if (!$response->ok) {
            throw SlackTokenException::invalidToken();
        }

        return new UserDetails($response->user_id, $response->team_id);
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
        return "$this->teamId.$this->userId";
    }
}