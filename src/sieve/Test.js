/**
 * SPDX-FileCopyrightText: 2024 Nextcloud GmbH and Nextcloud contributors
 * SPDX-License-Identifier: AGPL-3.0-or-later
 */

export class Test {
	field = ''
	operator = ''
	value = ''

	toSieve() {
		let script = ''
		let extensions = []

		if (this.field === 'subject') {
			script = `header :${this.operator} "subject" "${this.value}"`
		}

		if (this.field === 'to') {
			script = `address :${this.operator} :all "to" "${this.value}"`
		}

		return {
			script: script,
			extensions: extensions,
		}
	}
}
