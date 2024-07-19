<?php

declare(strict_types=1);

/**
 * SPDX-FileCopyrightText: 2020 Nextcloud GmbH and Nextcloud contributors
 * SPDX-License-Identifier: AGPL-3.0-or-later
 */

namespace OCA\Mail\Controller;

use OCA\Mail\AppInfo\Application;
use OCA\Mail\Contracts\IInternalAddressService;
use OCA\Mail\Http\JsonResponse;
use OCA\Mail\Http\TrapError;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http;
use OCP\IRequest;

class TrustedSendersController extends Controller {
	private ?string $uid;
	private IInternalAddressService $internalAddressService;

	public function __construct(IRequest $request,
		?string $UserId,
		IInternalAddressService $internalAddressService) {
		parent::__construct(Application::APP_ID, $request);

		$this->uid = $UserId;
		$this->internalAddressService = $internalAddressService;
	}

	/**
	 * @NoAdminRequired
	 *
	 * @param string $email
	 * @param string $type
	 * @return JsonResponse
	 */
	#[TrapError]
	public function setAddress(string $address, string $type): JsonResponse {
		$this->internalAddressService->trust(
			$this->uid,
			$address,
			$type
		);

		return JsonResponse::success(null, Http::STATUS_CREATED);
	}

	/**
	 * @NoAdminRequired
	 *
	 * @param string $email
	 * @param string $type
	 * @return JsonResponse
	 */
	#[TrapError]
	public function removeAddress(string $address, string $type): JsonResponse {
		$this->internalAddressService->trust(
			$this->uid,
			$address,
			$type,
			false
		);

		return JsonResponse::success(null);
	}
	/**
	 * @NoAdminRequired
	 *
	 * @return JsonResponse
	 */
	#[TrapError]
	public function list(): JsonResponse {
		$list = $this->internalAddressService->getTrusted(
			$this->uid
		);

		return JsonResponse::success($list);
	}
}
