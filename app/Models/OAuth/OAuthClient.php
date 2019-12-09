<?php

namespace App\Models\OAuth;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OAuthClient
 *
 * @property-read int $id
 * @property string $user_id
 * @property string $name
 * @property string $secret
 * @property string $redirect
 * @property boolean $personal_access_client
 * @property boolean $password_client
 * @property boolean $revoked
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @package App\Models\OAuth
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OAuth\OAuthClient newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OAuth\OAuthClient newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OAuth\OAuthClient query()
 * @mixin \Eloquent
 */
class OAuthClient extends Model
{
    protected $table = 'oauth_clients';
}
