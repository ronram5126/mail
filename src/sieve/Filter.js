/**
 * SPDX-FileCopyrightText: 2024 Nextcloud GmbH and Nextcloud contributors
 * SPDX-License-Identifier: AGPL-3.0-or-later
 */

export class Filter {
	name = ''
	operator = 'AllOf'
	tests = []
	actions = []
	active = true
}
