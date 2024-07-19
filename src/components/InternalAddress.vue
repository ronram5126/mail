<!--
  - SPDX-FileCopyrightText: 2020 Nextcloud GmbH and Nextcloud contributors
  - SPDX-License-Identifier: AGPL-3.0-or-later
-->

<template>
	<div>
		<div v-for="domain in sortedDomains"
			:key="domain.address">
			{{ domain.address }}
			{{ senderType(domain.type) }}
			<ButtonVue type="tertiary"
				class="button"
				:aria-label="t('mail','Remove')"
				@click="removeInternalAddress(domain)">
				{{ t('mail','Remove') }}
			</ButtonVue>
		</div>
        <div v-for="email in sortedEmails"
			:key="email.address">
			{{ email.address }}
			{{ t('mail', 'domain')}}
			<ButtonVue type="tertiary"
				class="button"
				:aria-label="t('mail','Remove')"
				@click="removeInternalAddress(email)">
				{{ t('mail','Remove') }}
			</ButtonVue>
		</div>
		<span v-if="!sortedSenders.length"> {{ t('mail', 'No senders are trusted at the moment.') }}</span>
	</div>
</template>

<script>

import { fetchInternalAdresses, removeInternalAddress, addInternalAddress } from '../service/InternalAddressService.js'
import { NcButton as ButtonVue } from '@nextcloud/vue'
import prop from 'lodash/fp/prop.js'
import sortBy from 'lodash/fp/sortBy.js'
import logger from '../logger.js'
import { showError } from '@nextcloud/dialogs'

const sortByAddress = sortBy(prop('address'))

export default {
	name: 'InternalAddress',
	components: {
		ButtonVue,
	},

	data() {
		return {
			list: [],
		}
	},
	computed: {
		sortedDomains() {
			return sortByAddress(this.list.filter(a => a.type === 'domain'))
		},
        sortedEmails(){
            return sortByAddress(this.list.filter(a => a.type === 'individual'))
        },
	},
	async mounted() {
		this.list = await fetchInternalAdresses()
	},
	methods: {
		async removeInternalAddress(sender) {
			// Remove the item immediately
			this.list = this.list.filter(s => s.id !== sender.id)
			try {
				await removeInternalAddress (
					sender.email,
					sender.type
				)
			} catch (error) {
				logger.error(`Could not remove internal address ${sender.email}`, {
					error,
				})
				showError(t('mail', 'Could not remove trusted sender {sender}', {
					sender: sender.email,
				}))
				// Put the sender back
				this.list.push(sender)
			}
		},
		senderType(type) {
			switch (type) {
			case 'individual':
				return t('mail', 'individual')
			case 'domain':
				return t('mail', 'domain')
			}
			return type
		},
	},
}
</script>

<style lang="scss" scoped>
.button-vue:deep() {
	display: inline-block !important;
}
</style>
