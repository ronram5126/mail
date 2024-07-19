/**
 * SPDX-FileCopyrightText: 2020 Nextcloud GmbH and Nextcloud contributors
 * SPDX-License-Identifier: AGPL-3.0-or-later
 */
import { generateUrl } from '@nextcloud/router'
import axios from '@nextcloud/axios'

export async function addInternalAddress(email, type) {
	const url = generateUrl('/apps/mail/api/internalAddress/{email}?type={type}', {
		email,
		type,
	})
		await axios.put(url)
}

export async function removeInternalAddress(email, type) {
	const url = generateUrl('/apps/mail/api/internalAddress/{email}?type={type}', {
		email,
		type,
	})
		await axios.put(url)
}

export async function fetchInternalAdresses() {
	const url = generateUrl('/apps/mail/api/internalAddress')
	const response = await axios.get(url)
	return response.data.data
}
