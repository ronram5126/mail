<?php

declare(strict_types=1);

/**
 * SPDX-FileCopyrightText: 2020 Nextcloud GmbH and Nextcloud contributors
 * SPDX-License-Identifier: AGPL-3.0-or-later
 */

namespace OCA\Mail\Service;

use OCA\Mail\Contracts\IInternalAddressService;
use OCA\Mail\Db\InternalAddressMapper;

class InternalAddressService implements IInternalAddressService {
	private InternalAddressMapper $mapper;

	public function __construct(InternalAddressMapper $mapper) {
		$this->mapper = $mapper;
	}

	public function isTrusted(string $uid, string $email): bool {
		return $this->mapper->exists(
			$uid,
			$email
		);
	}

	public function trust(string $uid, string $email, string $type, ?bool $trust = true): void {
		if ($trust && $this->isTrusted($uid, $email)) {
			// Nothing to do
			return;
		}

		if ($trust) {
			$this->mapper->create(
				$uid,
				$email,
				$type
			);
		} else {
			$this->mapper->remove(
				$uid,
				$email,
				$type
			);
		}
	}

	public function getTrusted(string $uid): array {
		return $this->mapper->findAll($uid);
	}
}
