/**
 * SPDX-FileCopyrightText: 2024 Nextcloud GmbH and Nextcloud contributors
 * SPDX-License-Identifier: AGPL-3.0-or-later
 */
import {randomId} from "../util/randomId";

export class Filter {
	id= 0
	name = ''
	operator = 'AllOf'
	tests = []
	actions = []
	active = true

	createTest() {
		this.tests.push(new Test(randomId()))
	}
	deleteTest(testId) {
		this.tests = this.tests.filter(test => test.id !== testId)
	}
}
