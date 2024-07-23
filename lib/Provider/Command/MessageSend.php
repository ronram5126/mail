<?php

declare(strict_types=1);

/**
 * SPDX-FileCopyrightText: 2024 Nextcloud GmbH and Nextcloud contributors
 * SPDX-License-Identifier: AGPL-3.0-or-later
 */
namespace OCA\Mail\Provider\Command;

use OCA\Mail\Db\LocalMessage;
use OCA\Mail\Service\AccountService;
use OCA\Mail\Service\Attachment\AttachmentService;
use OCA\Mail\Service\OutboxService;
use OCA\Mail\Service\SmimeService;
use OCP\IConfig;
use OCP\Mail\Provider\IMessage;

class MessageSend {

	public function __construct(
		protected IConfig $config,
		protected AccountService $accountService,
		protected OutboxService $outboxService,
		protected AttachmentService $attachmentService,
		protected SmimeService $smimeService
	) {
	}

	public function perform(string $userId, string $serviceId, IMessage $message, array $option = []): void {
		// find user mail account details
		$account = $this->accountService->find($userId, (int) $serviceId);
		// convert mail provider message to local message
		$localMessage = new LocalMessage();
		$localMessage->setType($localMessage::TYPE_OUTGOING);
		$localMessage->setAccountId($account->getId());
		$localMessage->setSubject($message->getSubject());
		$localMessage->setBody($message->getBody());
		$localMessage->setHtml(true);
		$localMessage->setSendAt(time());
		
		// convert all mail provider attachments to local attachments
		$attachments = [];
		if (count($message->getAttachments()) > 0) {
			// iterate attachments and save them
			foreach ($message->getAttachments() as $entry) {
				$attachments[] = $this->attachmentService->addFileFromString(
					$userId,
					$entry->getName(),
					$entry->getType(),
					$entry->getContents()
				)->jsonSerialize();
			}
		}
		// convert recipiant addresses
		$to = $this->convertAddressArray($message->getTo());
		$cc = $this->convertAddressArray($message->getCc());
		$bcc = $this->convertAddressArray($message->getBcc());
		// save message for sending
		$localMessage = $this->outboxService->saveMessage(
			$account,
			$localMessage,
			$to,
			$cc,
			$bcc,
			$attachments
		);

		// evaluate if job scheduler is NOT cron, send message right away otherwise let cron job handle it
		if ($this->config->getAppValue('core', 'backgroundjobs_mode', 'ajax') !== 'cron') {
			$localMessage = $this->outboxService->sendMessage($localMessage, $account);
		}

	}

	protected function convertAddressArray(array|null $in) {
		// construct place holder
		$out = [];
		// convert format
		foreach ($in as $entry) {
			$out[] = (!empty($entry->getLabel())) ? ['email' => $entry->getAddress(), 'label' => $entry->getLabel()] : ['email' => $entry->getAddress()];
		}
		// return converted addressess
		return $out;
	}

}
