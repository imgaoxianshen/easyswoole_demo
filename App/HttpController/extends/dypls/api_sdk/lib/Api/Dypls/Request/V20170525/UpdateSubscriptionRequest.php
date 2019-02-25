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
namespace Dyplsapi\Request\V20170525;

class UpdateSubscriptionRequest extends \RpcAcsRequest
{
    public function  __construct()
    {
        parent::__construct("Dyplsapi", "2017-05-25", "UpdateSubscription");
		$this->setMethod("POST");
    }

    protected $phoneNoB;

    protected $phoneNoA;

    protected $resourceOwnerId;

    protected $resourceOwnerAccount;

    protected $ownerId;

    protected $productType;

    protected $poolKey;

    protected $subsId;

    protected $phoneNoX;

    protected $expiration;

    protected $operateType;

    protected $callRestrict;

    public function getPhoneNoB() {
	    return $this->phoneNoB;
    }

    public function setPhoneNoB($phoneNoB) {
    	$this->phoneNoB = $phoneNoB;
    	$this->queryParameters['PhoneNoB'] = $phoneNoB;
	}

    public function getPhoneNoA() {
	    return $this->phoneNoA;
    }

    public function setPhoneNoA($phoneNoA) {
    	$this->phoneNoA = $phoneNoA;
    	$this->queryParameters['PhoneNoA'] = $phoneNoA;
	}

    public function getResourceOwnerId() {
	    return $this->resourceOwnerId;
    }

    public function setResourceOwnerId($resourceOwnerId) {
    	$this->resourceOwnerId = $resourceOwnerId;
    	$this->queryParameters['ResourceOwnerId'] = $resourceOwnerId;
	}

    public function getResourceOwnerAccount() {
	    return $this->resourceOwnerAccount;
    }

    public function setResourceOwnerAccount($resourceOwnerAccount) {
    	$this->resourceOwnerAccount = $resourceOwnerAccount;
    	$this->queryParameters['ResourceOwnerAccount'] = $resourceOwnerAccount;
	}

    public function getOwnerId() {
	    return $this->ownerId;
    }

    public function setOwnerId($ownerId) {
    	$this->ownerId = $ownerId;
    	$this->queryParameters['OwnerId'] = $ownerId;
	}

    public function getProductType() {
	    return $this->productType;
    }

    public function setProductType($productType) {
    	$this->productType = $productType;
    	$this->queryParameters['ProductType'] = $productType;
	}

    public function getPoolKey() {
	    return $this->poolKey;
    }

    public function setPoolKey($poolKey) {
    	$this->poolKey = $poolKey;
    	$this->queryParameters['PoolKey'] = $poolKey;
	}

    public function getSubsId() {
	    return $this->subsId;
    }

    public function setSubsId($subsId) {
    	$this->subsId = $subsId;
    	$this->queryParameters['SubsId'] = $subsId;
	}

    public function getPhoneNoX() {
	    return $this->phoneNoX;
    }

    public function setPhoneNoX($phoneNoX) {
    	$this->phoneNoX = $phoneNoX;
    	$this->queryParameters['PhoneNoX'] = $phoneNoX;
	}

    public function getExpiration() {
	    return $this->expiration;
    }

    public function setExpiration($expiration) {
    	$this->expiration = $expiration;
    	$this->queryParameters['Expiration'] = $expiration;
	}

    public function getOperateType() {
	    return $this->operateType;
    }

    public function setOperateType($operateType) {
    	$this->operateType = $operateType;
    	$this->queryParameters['OperateType'] = $operateType;
	}

    public function getCallRestrict() {
	    return $this->callRestrict;
    }

    public function setCallRestrict($callRestrict) {
    	$this->callRestrict = $callRestrict;
    	$this->queryParameters['CallRestrict'] = $callRestrict;
	}

}
