#Sirius API

This is the web API meant to be used with kayex/sirius Slack extensions server. It provides an easy way for users to register their tokens and what plugins they want enabled, and notifies the Sirius server about changes or new/deleted configurations.

## Methods

### GET /configs
This method is intended to be used only by the Sirius server. It returns all saved configurations. In order to access this route, an access token (set with the `SIRIUS_TOKEN` environment variable) must be present in the request, either through a `token` query variable or in the shape of an Authorization header: `Authorization: Bearer {token}`

### POST /configs
This method saves or updates an existing config. The request body should be a JSON representation of the user configuration, example below:
```json
{
    "slack_token": "{token}",
    "config": {
        "thumbs_up": {},
        "bad_words": {
            "strict": true
        }
    }
}
```
The API decides when to save a new and when to update a configuration, the database is searched for the specific Slack token, and if not found, it also uses the Slack API to get the user team and user id and compare those with what's already in the database. This is to avoid dublicate entries for the same user but with different tokens.

### GET /configs/{sirius_id}
This method returns the configuration for a specific sirius_id.

### DELETE /configs/{sirius_id}
This method deletes the configuration with a specific sirius_id.
