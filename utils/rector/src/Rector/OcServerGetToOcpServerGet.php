<?php

declare(strict_types=1);

namespace OCA\Mail\Utils\Rector\Rector;

use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use Rector\Core\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

class OcServerGetToOcpServerGet extends AbstractRector {

	public function getRuleDefinition(): RuleDefinition {
		return new RuleDefinition(
			'Change method calls from set* to change*.', [
				new CodeSample(
					'\OC::$server->get(\OCP\IUserSession::class);',
					'\OCP\Server::get(\OCP\IUserSession::class);'
				),
			]
		);
	}

	public function getNodeTypes(): array {
		return [MethodCall::class];
	}

	/**
	 * @param MethodCall $node
	 */
	public function refactor(Node $node) {
		if ($node->var instanceof Node\Expr\StaticPropertyFetch
			&& $node->var->class->toString() === \OC::class
			&& $node->var->name->toString() === 'server'
			&& $this->getName($node->name) === 'get') {
			return new Node\Expr\StaticCall(
				new Node\Name\FullyQualified(\OCP\Server::class),
				'get',
				$node->args,
			);
		}
		return null;
	}
}
