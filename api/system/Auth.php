<?php
use \Firebase\JWT\JWT;

/**
 * [Auth Class handling the JSON Web Token authentification]
 * using the php-jwt library
 */
class Auth {
    private $privateKey = <<<EOD
    -----BEGIN PRIVATE KEY-----
    MIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQCMsYr3Q1xxBwq6
    vGShZIPkzh6Vhxbj30eRjCzz3gjfug1A0bYccdi+wtU8nZqmWzvrxb1aPbPFuh5G
    OMKonGIz51yDkQTMbNyQk/VPw9RECLbBJSA+/9AgTXcWgjkRknHjfRfM/eQyfRxR
    ec0xP2wDG6LRPCt3XwwTd6TN57bIZ74RVYDisFtUA99NKDimisxh8RvC1YbsTRda
    QJrDCVGgd6TXe2RsE2mnPiihu3C7X6vJbNaz3Mp0S0iPWgw4ndTYzzQle8g44OA7
    62SJ7E4HlrP4t3plLvRpl3Pv5roukhCWk7vM3/aDLpscLxBb4sw+orMxSh9xdgJw
    PvlrvX4DAgMBAAECggEASaJyVM8Qhqdk2i7XjBCLZyjpoOC+/ixRzL9Ml6XRhyZc
    4VvgsCp1ggF+kOb7la2SQuePHrfEauvqBF6Yop6WVwvzw3gWxtcC6ThG36RiZ+kX
    nSbNJavFReLFPSaSr7uxl5pU5pjK4hHQzGOvHONQqJ/CKzgOl79LFrU7r/hiFahO
    hgLe5re1ePnHpyO2hUJceOztr8Rixej/XlQGikoii5+nXMHUXwGglf66BIjZUW2p
    auVyqz7Otc5VBN78o7f4E+UaFpG7NECxCErdJB8Gvir+42HyK8cHOOrUillt3zW2
    iTeM9Wx5iH5mm8GYNpJNSdUYET+V1+Aff+TBXu/IAQKBgQDSIHs6KGKB5nvVzn3S
    fBe5nO/BQcTBi7elVbibcJgYRXsfla9MO2s62S1fRkxdK2YcYkA2e9WPfao+oeHU
    bIAxCRXig7HJgRGGyvnXUmv3SeW+RG+fdxARnkNmQizrlJN6rnUMJit6vI5Piogg
    e3cBmSuGTuOtS7Tmow1ylRfJAwKBgQCraJZpKuyzxs0V0VYyoVKMlIL2ChxdhvK6
    9ORjw6T8K8U88m+RXLT2pubmplEWxQiOPAseI4mHiO/VNgPsqfU/psjym8KEqLv+
    hxiev7HvaBYRc25bBZO+KdyBmAHQVAyS/S5u1JSMGVKmqv8vtCiH83TzsjAtfJ2O
    j6HUMWznAQKBgQCfg2bojHXTdPu3IG1l1yxPjLJ5PAs4fm8oRP3CimP7sOs52/Da
    ZxUM9Ic8F2qrI+H9VBy4/6LsrhIKP+vmzYM3NlV1wlG5zZBXikjFy90IOgH9QYiX
    PtRk+4bg3wWoxP58GGnkkilZoEBMY7bZKcD65qMi70ppaNpoZ4ky3bnTrwKBgC1D
    TwSyexL2Gk36m4J/KydISFTkUp0393z7EhxuG3Ejtc/kTSXbj0XayPp7TMpweVPl
    8yGgTL7noD1zKBIkx0hpqIK4MuOJEyuhTRUOldQcbkdpbejHTj5XG411MHVs3G0s
    QkiuBhQA09yDJyPXtSRBW87GbQZ1870jnJ5F9vYBAoGAVJ3kJA71OWsShCrvFlJz
    MHnjaHOCQpK6ZjrDMuKYOmtshBvMoLq/Rbdj38bHsUXjT/3Dw1Qt5MLxokDeWMdr
    xXZiBFV4TPbJYrO/RQljBSuxawCrIPkjxvKwWpymW2R2XCM/q6PTmMokYxSUOaoM
    uIxs+YK+xRew3s+lPpxsBBk=
    -----END PRIVATE KEY-----
    EOD;

    private $publicKey = <<<EOD
    -----BEGIN PUBLIC KEY-----
    MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAjLGK90NccQcKurxkoWSD
    5M4elYcW499HkYws894I37oNQNG2HHHYvsLVPJ2apls768W9Wj2zxboeRjjCqJxi
    M+dcg5EEzGzckJP1T8PURAi2wSUgPv/QIE13FoI5EZJx430XzP3kMn0cUXnNMT9s
    Axui0Twrd18ME3ekzee2yGe+EVWA4rBbVAPfTSg4porMYfEbwtWG7E0XWkCawwlR
    oHek13tkbBNppz4oobtwu1+ryWzWs9zKdEtIj1oMOJ3U2M80JXvIOODgO+tkiexO
    B5az+Ld6ZS70aZdz7+a6LpIQlpO7zN/2gy6bHC8QW+LMPqKzMUofcXYCcD75a71+
    AwIDAQAB
    -----END PUBLIC KEY-----
    EOD;

    private $payload = [
        "aud"=>"http://localhost:80/",
    ];

    public function __construct($user) {
        $this->payload['nbf']=time();
        $this->payload['iat']=time();
        $this->payload['user']=$user;
    }

    public function encode() {
        return JWT::encode($this->payload, $this->privateKey,'RS256');
    }

    public function decode($jwt) {
        return JWT::decode($jwt, $this->publicKey, ['RS256']);
    }
}
