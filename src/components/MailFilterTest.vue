<!--
  - SPDX-FileCopyrightText: 2024 Nextcloud GmbH and Nextcloud contributors
  - SPDX-License-Identifier: AGPL-3.0-or-later
-->
<template>
	<div class="mail-filter-row">
		<NcSelect required="true" input-label="Field" input-id="field" :options="['subject', 'to']" :value.sync="test.field" />
		<NcSelect required="true" input-label="Operator" input-id="operator" :options="['is', 'contains', 'matches']" :value.sync="test.operator" />
		<div class="mail-filter-value">
			<label for="mail-filter-value-field">Value</label>
			<NcTextField required="true" id="mail-filter-value-field" label="Value" :label-outside="true" :value.sync="test.value" />
		</div>

	</div>
</template>
<script>
import {NcButton, NcInputField, NcModal, NcSelect, NcTextField} from "@nextcloud/vue";

export default {
	name: 'MailFilterTest',
	components: {
		NcModal,
		NcButton,
		NcTextField,
		NcSelect,
	},
	// setup() {
	// 	return {
	// 		// modalRef: ref(null),
	// 	}
	// },
	props: {
		test: {
			type: Object,
			required: true,
		},
	},
	data() {
		return {
			modal: false,
			firstName: '',
			lastName: '',
			pizza: [],
		}
	},
	methods: {
		showModal() {
			this.firstName = ''
			this.lastName = ''
			this.modal = true
		},
		closeModal() {
			this.modal = false
		}
	}
}
</script>
<style lang="scss" scoped>
.mail-filter-row {
	display: flex;
	gap: 5px;
}

.mail-filter-value label {
	display: block;
}

.form-group {
	margin: calc(var(--default-grid-baseline) * 4) 0;
	display: flex;
	flex-direction: column;
	align-items: flex-start;
}

.external-label {
	display: flex;
	width: 100%;
	margin-top: 1rem;
}

.external-label label {
	padding-top: 7px;
	padding-right: 14px;
	white-space: nowrap;
}
</style>
