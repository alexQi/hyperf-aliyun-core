<?php

declare(strict_types=1);
/**
 * Created by PhpStorm.
 *​
 * AssumeRoleRequest.php
 *
 * User：YM
 * Date：2020/4/23
 * Time：10:46 AM
 */


namespace Ym\AliyunCore\Auth;

use Ym\AliyunCore\RpcAcsRequest;

/**
 *
 */
define('STS_PRODUCT_NAME', 'Sts');
/**
 *
 */
define('STS_DOMAIN', 'sts.aliyuncs.com');
/**
 *
 */
define('STS_VERSION', '2015-04-01');
/**
 *
 */
define('STS_ACTION', 'AssumeRole');
/**
 *
 */
define('STS_REGION', 'cn-hangzhou');
/**
 *
 */
define('ROLE_ARN_EXPIRE_TIME', 3600);

class AssumeRoleRequest extends RpcAcsRequest
{
    /**
     * AssumeRoleRequest constructor.
     *
     * @param $roleArn
     * @param $roleSessionName
     */
    public function __construct($roleArn, $roleSessionName)
    {
        parent::__construct(STS_PRODUCT_NAME, STS_VERSION, STS_ACTION);

        $this->queryParameters['RoleArn']         = $roleArn;
        $this->queryParameters['RoleSessionName'] = $roleSessionName;
        $this->queryParameters['DurationSeconds'] = ROLE_ARN_EXPIRE_TIME;
        $this->setRegionId(ROLE_ARN_EXPIRE_TIME);
        $this->setProtocol('https');

        $this->setAcceptFormat('JSON');
    }
}
