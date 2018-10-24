<?php

return [
    'hashAlgo' => 'SHA256',
    'algoPrefix' => 'EMS',
    'vendorKey' => 'EMS',
    'authHeaderKey' => 'X-EMS-Auth',
    'dateHeaderKey' => 'X-EMS-Date',
    'clockSkew' => '300',
    'credentialScope' => env('ESCHER_CREDENTIAL_SCOPE'),
    'keyId' => env('ESCHER_KEY'),
    'secret' => env('ESCHER_SECRET'),
];
