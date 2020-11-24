<?php
/**
 * Created by PhpStorm.
 * User: dungang
 * Date: 20-11-23
 * Time: 下午9:36
 */

namespace app\console;


use yii\console\Controller;

class KeyGenerateController extends Controller
{

    protected $key;
    /**
     * 生成密钥
     * @throws \Exception
     */
    public function actionIndex(){
        $this->key = $key = getenv('APP_KEY');
        if(strlen($key)!==0 ) {
            if($this->confirm('key值不为空，确认重新生成？')){
                $this->writeNewEnvironmentFileWith($this->generateRandomString());
            }
        } else {
            $this->writeNewEnvironmentFileWith($this->generateRandomString());
        }
    }

    /**
     * @return string
     * @throws \Exception
     */
    protected function generateRandomString()
    {
        if (!extension_loaded('openssl')) {
            throw new \Exception('The OpenSSL PHP extension is required by Yii2.');
        }
        $length = 32;
        $bytes = openssl_random_pseudo_bytes($length);
        return strtr(substr(base64_encode($bytes), 0, $length), '+/=', '_-.');
    }

    /**
     * Write a new environment file with the given key.
     *
     * @param  string  $key
     * @return void
     */
    protected function writeNewEnvironmentFileWith($key)
    {
        $envFilePath = \Yii::$app->basePath . '/.env';
        file_put_contents($envFilePath, preg_replace(
            $this->keyReplacementPattern(),
            'APP_KEY='.$key,
            file_get_contents($envFilePath)
        ));
    }

    /**
     * Get a regex pattern that will match env APP_KEY with any random key.
     *
     * @return string
     */
    protected function keyReplacementPattern()
    {
        $escaped = preg_quote('='.$this->key, '/');

        return "/^APP_KEY{$escaped}/m";
    }
}