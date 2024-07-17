<!--
  - SPDX-FileCopyrightText: 2024 Nextcloud GmbH and Nextcloud contributors
  - SPDX-License-Identifier: AGPL-3.0-or-later
-->
<template>
	<NcModal
		size="large"
		@close="closeModal"
		name="Name inside modal">
		<div class="modal__content">
			<NcTextField :value.sync="filter.name"
			 	label="Filter name"
			 	:required="true"
			/>

			<div class="tests">
				<MailFilterTest v-for="test in filter.tests"
								v-bind:key="test.id"
								:test="test"
								v-on:delete-test="deleteTest(test.id)"
				/>
				<NcButton class="app-settings-button"
						  type="secondary"
						  :aria-label="t('mail', 'New test')"
						  @click.prevent.stop="createTest">
					<template #icon>
						<IconLock :size="16" />
					</template>
					{{ t('mail', 'New test') }}
				</NcButton>
			</div>

			<div class="form-group">
				<NcTextField label="First Name" :value.sync="firstName" />
			</div>
			<div class="form-group">
				<NcTextField label="Last Name" :value.sync="lastName" />
			</div>
			<div class="form-group">
				<label for="pizza">What is the most important pizza item?</label>
				<NcSelect input-id="pizza" :options="['Cheese', 'Tomatos', 'Pineapples']" v-model="pizza" />
			</div>

			<NcButton
				:disabled="!firstName || !lastName || !pizza"
				@click="closeModal"
				type="primary">
				Submit
			</NcButton>
		</div>
	</NcModal>
</template>
<script>
import {NcButton, NcInputField, NcModal, NcSelect, NcTextField} from "@nextcloud/vue";
import MailFilterTest from "./MailFilterTest.vue";
import IconLock from "vue-material-design-icons/Lock.vue";
import { Test } from '../sieve/Test'
import {randomId} from "../util/randomId";

export default {
	name: 'MailFilterModal',
	components: {
		IconLock,
		MailFilterTest,
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
		filter: {
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
		createTest() {
			this.filter.createTest()
		},
		deleteTest(testId) {
			this.filter.deleteTest(testId)
		},
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
.modal__content {
	margin: 50px;
}

.modal__content h2 {
	text-align: center;
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
