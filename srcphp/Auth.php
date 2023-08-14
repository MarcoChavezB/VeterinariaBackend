<?php
    
    namespace proyecto;
    use Firebase\JWT\JWT;
    use Firebase\JWT\Key;
    use Carbon\Carbon;
    use proyecto\Models\Usuarios;

    class Auth
    {
        private $Usuarios;

        public static function generateToken($data, $time = 3600): string
        {
            $t = Carbon::now()->timestamp + $time;
            $key = 'orimar174';
            $payload = ['exp' => $t, 'data' => $data];
            return JWT::encode($payload, $key, 'HS256');
        }

        /**
         * @return mixed
         */
        public static function getUser()
        {
            $secretKey = 'orimar174';
            $jwt = Router::getBearerToken();
            $token = JWT::decode($jwt, new key($secretKey, 'HS256'));
            return User::find($token->data[0]);
        }

        /**
         * @param mixed $user
         */
        public static function setUser($Usuarios): void
        {
            $session = new Session();
            $session->set('Usuarios', $Usuarios);

        }

        public function clearUser($Usuarios): void
        {
            $se = new Session();
            $se->remove("Usuarios");
        }
    
        
    
        
    }
