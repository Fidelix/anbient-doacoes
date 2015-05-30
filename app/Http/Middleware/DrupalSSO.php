<?php namespace App\Http\Middleware;

use App\User;
use Closure;
use DB;
use Auth;

class DrupalSSO {

	// Verifica se o usuário tem um cookie de sessão do Drupal
	// e se realmente está logado no banco de dados com o cookie.
	public function getUserDataFromSession(){
		foreach($_COOKIE as $key => $cookie){
			if(strpos($key, 'SESS') === 0){
				$session = $cookie;
				break;
			}
		}
		if (!empty($session)) {
			$user_row = DB::connection('drupal_mysql')
				->table('sessions')
				->leftJoin('users', 'users.uid', '=', 'sessions.uid')
				->where('sessions.uid', '>', 0)
				->where('sid', $session)
				->orderBy('sessions.uid', 'DESC')
				->first(['sessions.uid', 'timestamp', 'users.name', 'users.mail']);
			if(!empty($user_row->uid)) return $user_row;
		}

		return FALSE;
	}

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if ($user_data = $this->getUserDataFromSession()) {
			// Usuário está logado no Drupal. Pega ele no banco do laravel
			// se ele já existe, ou o cria.
			$user = User::where('drupal_uid', $user_data->uid);
			d($user);
			exit;
			if (!$user) $user = User::create([
				'name' => $user_data->name,
				'email' => $user_data->mail,
				'drupal_uid' => $user_data->uid
			]);
			Auth::login($user, TRUE);
		}
		return $next($request);
	}

}
