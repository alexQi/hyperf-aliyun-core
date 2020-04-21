<?php

/*
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 */
namespace  Ym\AliyunCore\Http;

use Ym\AliyunCore\Exception\ClientException;
use Hyperf\Guzzle\HandlerStackFactory;
use GuzzleHttp\Client;

class HttpHelper
{
    /**
     * @var int
     */
    public static $connectTimeout = 30;//30 second
    /**
     * @var int
     */
    public static $readTimeout = 80;//80 second

    /**
     * @param string $url
     * @param string $httpMethod
     * @param null   $postFields
     * @param null   $headers
     *
     * @return HttpResponse
     * @throws ClientException
     */
    public static function curl($url, $httpMethod = 'GET', $postFields = null, $headers = null)
    {
        $factory = new HandlerStackFactory();
        $stack = $factory->create(['max_connections' => 500]);
        $stackClient = make(Client::class, [
            'config' => [
                'handler' => $stack,
            ],
        ]);
        try {
            $response = $stackClient->request($httpMethod,$url,['form_params' => $postFields,'headers' => $headers]);
            $responseCode = $response->getStatusCode();
            $resBody = $response->getBody();
        } catch (Exception $e) {
            throw new ClientException($e->getMessage(),$e->getCode());
        }
        $httpResponse = new HttpResponse();
        $httpResponse->setBody($resBody);
        $httpResponse->setStatus($responseCode);

        return $httpResponse;
    }

}
